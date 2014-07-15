<?php

namespace Buku\Controller;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use DoctrineModule\Paginator\Adapter\Collection as Collection;
use Zend\Paginator\Paginator;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Buku\Form as BF;
use Buku\Form\TransaksiForm as TransaksiForm;

Class TransaksiController extends AbstractActionController
{
	public function indexAction() // Header Transaksi
	{
		$this->AuthPlugin()->checkAuth();
		$matches = $this->getEvent()->getRouteMatch();
		$page = $matches->getParam('page', 1);
		$lang = $matches->getParam('lang', 'en');
		
		$objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$headerAdap = $objectManager->getRepository('Buku\Model\Entity\Hjual');
		$header = $headerAdap->findAll();
		
		$collection = new ArrayCollection($header);
		$paginator = new Paginator(new Collection($collection));
		 
		$paginator->setCurrentPageNumber($page);
		$paginator->setItemCountPerPage(5);
		
		return new ViewModel(array(
		    'paginator' => $paginator,
		    'lang' => $lang,
		));
	}
	
	public function detailAction()
	{
		$this->AuthPlugin()->checkAuth();
		$matches = $this->getEvent()->getRouteMatch();
		$page = $matches->getParam('page', 1);
		$lang = $matches->getParam('lang', 'en');
		
		$objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$headerAdap = $objectManager->getRepository('Buku\Model\Entity\Hjual');
		$header = $headerAdap->findAll();
		
		$collection = new ArrayCollection($header);
		$paginator = new Paginator(new Collection($collection));
		 
		$paginator->setCurrentPageNumber($page);
		$paginator->setItemCountPerPage(5);
		
		return new ViewModel(array(
		    'paginator' => $paginator,
		    'lang' => $lang,
		));
	}
	
	/*
	public function penjualanAction()
		{
			$this->AuthPlugin()->checkAuth();
			
			$session = new Container('ujian');
			$arrDetail = array();
			if (isset($session->detailpenjualan)) {
				$arrDetail = $session->detailpenjualan;
				//var_dump($arrDetail);exit;
			}
			
			$form = new TransaksiForm;
			$objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
			$qb = $objectManager->createQueryBuilder();
			$qb->add('select','b');
			$qb->add('from','Buku\Model\Entity\Buku b');
			$qb->add('where','b.status=:status');
			$qb->add('orderBy','b.nama asc');
			$qb->setParameter('status',true);
			$query=$qb->getQuery();
			$buku = $query->getResult();
			
			$auth = $this->getServiceLocator()->get('doctrine.authenticationservice.orm_default');
			$kasir = $auth->getIdentity();
			$customer = '';
			
			$arrNama = array();
			foreach ($buku as $value) {
				$arrNama[] = $value->getNama();
			}
			
			$request = $this->getRequest();
			if ($request->isPost()) {
				$customer = $request->getPost('customer');
				$btnAdd = $request->getPost('add');
				$btnSave = $request->getPost('save');
				$btnDelete = $request->getPost('delete');
				if ($btnAdd == "Add") {
					$cek = true;
					$selBook = $request->getPost('buku');
					$selQty = $request->getPost('qty');
					$stok = $buku[$selBook]->getStok();
					$bookId = $buku[$selBook]->getId();
					
					if($selQty <= 0) {
						$cek = false;
						$this->flashMessenger()->addMessage($selQty);
						$this->flashMessenger()->addMessage("Pastikan Qty yang dimasukkan tidak kosong");
					}
					if($selQty > $stok) {
						$cek = false;
						$this->flashMessenger()->addMessage("Jumlah stok buku tidak mencukupi");
					}
					$idx=0;
					
					foreach($arrDetail as $value) {
						if($value[0] == $bookId && $cek) {
							$cek = false;
							$arrDetail[$idx] = array($buku[$selBook]->getId(), $buku[$selBook]->getNama(), $selQty,$buku[$selBook]->getHarga(), ((int)$buku[$selBook]->getHarga()*(int)$selQty));
						}
						$idx++;
					}
					if($cek) {
						$arrDetail[] = array($buku[$selBook]->getId(), $buku[$selBook]->getNama(), $selQty,$buku[$selBook]->getHarga(), ((int)$buku[$selBook]->getHarga()*(int)$selQty));
						//$session->detail = $arrDetail;
						//$_SESSION['detail'] = $arrDetail;
					}
					$session->detailpenjualan = $arrDetail;
					//var_dump($session->detail);
				} 
				if ($btnSave == "Save")  {
					$customer = ucwords(strtolower($request->getPost('txtCustomer')));
					$tglTrans = $request->getPost('tglTrans');
					$cek = true;
					if (!isset($session->detailpenjualan)) {
						$cek = false;
						$this->flashMessenger()->addMessage("Tidak ada detail untuk disimpan");
					}				
					if ($customer == "") {
						$cek = false;
						$this->flashMessenger()->addMessage("Nama harus diisi");
					}
					if ($cek) {
						$total = 0;
						foreach ($session->detailpenjualan as $value) {
							$total += $value[4];
						}
						$objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
						$header = new \Buku\Model\Entity\Hjual();
						$header->setTgl($tglTrans);
						$header->setKasir($kasir->getId());
						$header->setCustomer($customer);
						$header->setTotal($total);
						$header->setStatus(true);
						$objectManager->persist($header);
						$objectManager->flush();
						$headerId = $header->getId();
						
						if (isset($session->detailpenjualan)) {
							//$this->flashMessenger()->addMessage($headerId);
							foreach ($session->detailpenjualan as $value) {
								$detail = new \Buku\Model\Entity\Djual();
								$detail->setId($headerId);
								$detail->setBuku($value[0]);
								$detail->setHarga($value[3]);
								$detail->setQty($value[2]);
								$detail->setSubtotal($value[4]);
								$objectManager->persist($detail);
								$objectManager->flush();
							}
						}
						$session->offsetUnset('detailpenjualan');
					}
				}
				if ($btnDelete) {
					$delId = $request->getPost('delete');
					$delId = str_replace("delete-", "", $delId);
					$this->flashMessenger()->addMessage($delId);
					$idx = 0;
					foreach ($arrDetail as $value) {
						if ($value[0]==$delId) {
							array_splice($arrDetail, $idx, 1);
						}
						$idx++;
					}
					$session->detailpenjualan = $arrDetail;
				}
	
			} 
			
			return new ViewModel(array(
				'customer' => $customer,
				'form' => $form,
				'kasir' => $kasir,
				'namaBuku' => $arrNama,
				'buku' => $buku,
				'messages' => $this->flashMessenger()->getCurrentMessages(),
				'mysession' => $session,
			));
		}*/
	
	public function penjualanAction()
	{
		//session_start();
		$session = new Container('ujian');
		$arrDetail = array();
		if(isset($session->tempDetail)) {
			$arrDetail = $session->tempDetail;
		}
		
		$form = new TransaksiForm;
		$objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$qb = $objectManager->createQueryBuilder();
		$qb->select('b');
		$qb->from('Buku\Model\Entity\Buku','b');
		$qb->where('b.status=:status');
		$qb->OrderBy('b.nama','ASC');
		$qb->setParameter('status',true);
		$query=$qb->getQuery();
		$buku = $query->getResult();
		
		$auth = $this->getServiceLocator()->get('doctrine.authenticationservice.orm_default');
        $kasir = $auth->getIdentity();
		$customer = '';
		
		$arrNama = array();
		foreach ($buku as $value) {
			$arrNama[] = $value->getNama();
		}
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$customer = $request->getPost('customer');
			$btnAdd = $request->getPost('add');
			$btnSave = $request->getPost('save');
			$btnDelete = $request->getPost('delete');
			if ($btnAdd == "Add") {
				$cek = true;
				$selBook = $request->getPost('buku');
				$selQty = $request->getPost('qty');
				$stok = $buku[$selBook]->getStok();
				$bookId = $buku[$selBook]->getId();
				
				if($selQty <= 0) {
					$cek = false;
					$this->flashMessenger()->addMessage($selQty);
					$this->flashMessenger()->addMessage("Pastikan Qty yang dimasukkan tidak kosong");
				}
				if($selQty > $stok) {
					$cek = false;
					$this->flashMessenger()->addMessage("Jumlah stok buku tidak mencukupi");
				}
				$idx=0;
				
				foreach($arrDetail as $value) {
					if($value[0] == $bookId && $cek) {
						$cek = false;
						$arrDetail[$idx] = array($buku[$selBook]->getId(), $buku[$selBook]->getNama(), $selQty,$buku[$selBook]->getHarga(), ((int)$buku[$selBook]->getHarga()*(int)$selQty));
					}
					$idx++;
				}
				if($cek) {
					$arrDetail[] = array($buku[$selBook]->getId(), $buku[$selBook]->getNama(), $selQty,$buku[$selBook]->getHarga(), ((int)$buku[$selBook]->getHarga()*(int)$selQty));
				}
				$session->tempDetail = $arrDetail;
			} 
			if ($btnSave == "Save")  {
				$customer = ucwords(strtolower($request->getPost('customer')));
				$tglTrans = $request->getPost('tglTrans');
				$cek = true;
				if (!isset($session->tempDetail)) {
					$cek = false;
					$this->flashMessenger()->addMessage("Tidak ada detail untuk disimpan");
				}				
				if ($customer == "") {
					$cek = false;
					$this->flashMessenger()->addMessage("Nama harus diisi");
				}
				if ($cek) {
					$total = 0;
					foreach ($session->tempDetail as $value) {
						$total += $value[4];
					}
					$objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
					$header = new \Buku\Model\Entity\Hjual();
					$header->setTgl($tglTrans);
					$header->setKasir($kasir->getId());
					$header->setCustomer($customer);
					$header->setTotal($total);
					$header->setStatus(true);
					$objectManager->persist($header);
					$objectManager->flush();
					$headerId = $header->getId();
					
					if (isset($session->tempDetail)) {
						//$this->flashMessenger()->addMessage($headerId);
						foreach ($session->tempDetail as $value) {
							$detail = new \Buku\Model\Entity\Djual();
							$detail->setId($headerId);
							$detail->setBuku($value[0]);
							$detail->setHarga($value[3]);
							$detail->setQty($value[2]);
							$detail->setSubtotal($value[4]);
							$objectManager->persist($detail);
							$objectManager->flush();
						}
					}
					unset($session->tempDetail);
				}
			}
			if ($btnDelete) {
				$delId = $request->getPost('delete');
				$delId = str_replace("delete-", "", $delId);
				$this->flashMessenger()->addMessage($delId);
				$idx = 0;
				foreach ($arrDetail as $value) {
					if ($value[0]==$delId) {
						array_splice($arrDetail, $idx, 1);
					}
					$idx++;
				}
				$session->tempDetail = $arrDetail;
			}

		} 
		
		return new ViewModel(array(
		    'customer' => $customer,
		    'form' => $form,
			'kasir' => $kasir,
			'namaBuku' => $arrNama,
			'buku' => $buku,
			'messages' => $this->flashMessenger()->getCurrentMessages(),
			'mysession' => $session,
		));
	}

	public function reportAction() {
		$this->AuthPlugin()->checkAuth();
		$objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$headerAdap = $objectManager->getRepository('Buku\Model\Entity\Hjual');
		$header = $headerAdap->findAll();
		
		$detailAdap = $objectManager->getRepository('Buku\Model\Entity\Djual');
		$detail = $detailAdap->findAll();
		
		$kasirAdap = $objectManager->getRepository('Buku\Model\Entity\Kasir');
		$kasir = $kasirAdap->findAll();
		
		$bukuAdap = $objectManager->getRepository('Buku\Model\Entity\Buku');
		$buku = $bukuAdap->findAll();
		
		return new ViewModel(array(
		    'header' => $header,
		    'detail' => $detail,
		    'kasirs' => $kasir,
		    'books' => $buku,
		));
	}
	
	public function invoiceAction() {
		$this->AuthPlugin()->checkAuth();
		$objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$headerAdap = $objectManager->getRepository('Buku\Model\Entity\Hjual');
		
		$id =  $this->params('page');
		
		if(!$id) {
			return $this->redirect()->toRoute('transaksi', array('lang'=>$this->lang, 'action'=>'index'));
		}
		$header = $headerAdap->findBy(array('id' => $id));
		
		$detailAdap = $objectManager->getRepository('Buku\Model\Entity\Djual');
		$details = $detailAdap->findBy(array('id' => $id));
		
		$kasirAdap = $objectManager->getRepository('Buku\Model\Entity\Kasir');
		$kasir = $kasirAdap->findAll();
		
		$bukuAdap = $objectManager->getRepository('Buku\Model\Entity\Buku');
		$buku = $bukuAdap->findAll();
		
		return new ViewModel(array(
		    'header' => $header,
		    'details' => $details,
		    'kasirs' => $kasir,
		    'books' => $buku,
		));
	}
}
?>