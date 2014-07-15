<?php

namespace Buku\Controller;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use DoctrineModule\Paginator\Adapter\Collection as Collection;
use Zend\Paginator\Paginator;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Buku\Form\InsertForm as InsertForm;
use Buku\Form\SearchForm as SearchForm;
use Buku\Model\Entity\Buku as Buku; 

Class BukuController extends AbstractActionController
{
	public function indexAction()
	{
		$session = new Container('ujian');
		if(!isset($session->filtername)) {
			$session->filtername = '';
		}
		
		$this->AuthPlugin()->checkAuth();
		
		$form = new SearchForm;
		
		$matches = $this->getEvent()->getRouteMatch();
		$page = $matches->getParam('page', 1);
		$lang = $matches->getParam('lang', 'en');
		$nama = $session->filtername;
		$request = $this->getRequest();
		$response = $this->getResponse();
		
		if ($request->isPost()) {
			$btnDelete = $request->getPost('btnDelete');
			$btnSearch = $request->getPost('search');
			$btnEdit = $request->getPost('btnEdit');
			if ($btnDelete) {
				$id = $request->getPost('delete');
				$this->deleteBook(str_replace('delete-', '', $id));
				$this->flashMessenger()->addMessage($id);
			}
			if ($btnSearch) {
				$session->filtername = $request->getPost('nama');
				$nama = $session->filtername;
			}
			if ($btnEdit) {
				$edit = $request->getPost('edit');
				$edit = str_replace("edit-", "", $edit); 
				return $this->redirect()->toRoute('buku', array('lang'=>$this->lang, 'action'=>'update', 'page' => $edit));
			}
		}
		
		$objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		
		$qb = $objectManager->createQueryBuilder();
		$qb->select(array('b'))
		   ->from('Buku\Model\Entity\Buku','b')
		   ->where('b.status = :status AND b.nama like :nama')
		   ->setParameter('status', true)
		   ->setParameter('nama','%' . $nama . '%')
		   ->orderBy('b.id','DESC');
		$query=$qb->getQuery();
		$buku = $query->getResult();
		
		$collection = new ArrayCollection($buku);
		$paginator = new Paginator(new Collection($collection));
		 
		$paginator->setCurrentPageNumber($page);
		$paginator->setItemCountPerPage(5);
		
		return new ViewModel(array(
		    'paginator' => $paginator,
		    'lang' => $lang,
		    'messages' => $this->flashMessenger(),
		    'form' => $form,
		    'nama' => $nama,
		    'plugin' => $this->MyPlugin(),
		));
	}
	
	public function insertAction() {
		$this->AuthPlugin()->checkAuth();
		$form = new InsertForm;
		$cek = true;
		
		$nama = '';
        $stok = '';
		$harga = '';
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$nama = ucwords(strtolower($request->getPost('nama')));
	        $stok = (int)$request->getPost('stok');
			$harga = (int)$request->getPost('harga');
			
			if ($this->cekInput($nama,$stok,$harga)) {
				$objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
				$buku = new Buku(); // gunakan namespace
				$buku->setNama($nama);
				$buku->setStok($stok);
				$buku->setHarga($harga);
				$buku->setStatus(true);
				
				$objectManager->persist($buku);
				$objectManager->flush();
				$this->flashmessenger()->addMessage("Data Buku Berhasil Disimpan");
				
				return $this->redirect()->toRoute('buku', array('lang'=>$this->lang, 'action'=>'index', 'page' => $this->page));
			} else {
				return $this->redirect()->toRoute('buku', array('lang'=>$this->lang, 'action'=>'insert', 'page' => $this->page));
			}
		}
		
		return new ViewModel(array(
		    'form' => $form,
		    'messages' => $this->flashMessenger(),
		    'nama' => $nama,
		    'harga' => $harga,
		    'stok' => $stok,
		));
	}
	
	private function deleteBook($id) {
		echo '<script>$result</script>';
		$this->AuthPlugin()->checkAuth();
		$objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$bukuAdap = $objectManager->getRepository('Buku\Model\Entity\Buku');
		
		$selBuku = $bukuAdap->find($id);
		$selBuku->setStatus(false);
		$objectManager->flush();
		
        $this->flashmessenger()->addMessage("Data Buku Berhasil Dihapus");
		$this->redirect()->toRoute('buku', array('action'=>'index', 'lang'=>$this -> lang, 'page'=>$this -> page));
	}
	
	public function updateAction() {
		$this->AuthPlugin()->checkAuth();
		$form = new InsertForm;
		$cek = false;
		
		$id = $this->params('page');
		
		if (!$id) {
			return $this->redirect()->toRoute('buku', array('lang'=>$this->lang, 'action'=>'index', 'page' => 1));
		}
		
		$objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$bukuAdap = $objectManager->getRepository('Buku\Model\Entity\Buku');
		
		$buku = $bukuAdap->find($id);
		$nama = $buku->getNama();
		$harga = $buku->getHarga();
		$stok = $buku->getStok();
		$status = $buku->getStatus();
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$nama = ucwords(strtolower($request->getPost('nama')));
	        $stok = (int)$request->getPost('stok');
			$harga = (int)$request->getPost('harga');
			$status = fmod((int)$request->getPost('status'),2);
			
			if ($this->cekInput($nama,$stok,$harga)) {
				$buku->setNama($nama);
				$buku->setStok($stok);
				$buku->setHarga($harga);
				$buku->setStatus($status);
				
				$objectManager->flush();
				$this->flashmessenger()->addMessage("Data Buku Berhasil Diubah");
				
				return $this->redirect()->toRoute('buku', array('lang'=>$this->lang, 'action'=>'index', 'page' => $this->page));
			} else {
				return $this->redirect()->toRoute('buku', array('lang'=>$this->lang, 'action'=>'update', 'page' => $this->page));
			}
		}
		
		return new ViewModel(array(
		    'form' => $form,
		    'messages' => $this->flashMessenger(),
		    'id' => $id,
		    'nama' => $nama,
		    'harga' => $harga,
		    'stok' => $stok,
		    'status' => $status
		));
	}

	private function cekInput($nama, $stok, $harga) {
		$cek = true;
		if ($nama == "") {
			$cek = false;
			$this->flashMessenger()->addMessage("Nama Harus Diisi");
		}
		if (!is_int($stok) || $stok <= 0) {
			$cek = false;
			$this->flashMessenger()->addMessage("Stok Harus Angka dan > 0");
		}
		if (!is_int($harga) || $harga <= 0) {
			$cek = false;
			$this->flashMessenger()->addMessage("Harga Harus Angka dan > 0");
		}
		return $cek;
	}

}
?>