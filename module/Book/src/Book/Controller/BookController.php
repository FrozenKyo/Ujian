<?php
namespace Book\Controller;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use DoctrineModule\Paginator\Adapter\Collection as Collection;
use Zend\Paginator\Paginator;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Book\Form\BookForm as BookForm; 
use Book\Form\BookFormValidator as BookFormValidator; 

Class BookController extends AbstractActionController
{
	public function indexAction()
    {
    	$routeMatch = $this->getEvent()->getRouteMatch();
    	$lang = $routeMatch->getParam('lang','en');
    	$page = $routeMatch->getParam('page',1);
    	$itemCountPerPage = 8;
    	$session = new Container('POSBookIndex');
		if(!isset($session->searchFilter)) {
			$session->searchFilter = '';
		} else {
			$session->searchFilter = '';
		}
    	
		$books = $this->posDatabasePlugin()->getBooks($session->searchFilter);
		$collection = new ArrayCollection($books);
		$paginator = new Paginator(new Collection($collection));
		$paginator->setCurrentPageNumber($page);
		$paginator->setItemCountPerPage($itemCountPerPage);
        return new ViewModel(array(
        	'lang' => $lang,
        	'page' => $page,
        	'itemCountPerPage' => $itemCountPerPage,
        	'paginator'=> $paginator,
        	'messages' => $this->flashMessenger()->getMessages(),
        	'utilityPlugin' => $this->utilityPlugin()
        ));
    }

	public function newAction()
	{
		$routeMatch = $this->getEvent()->getRouteMatch();
    	$lang = $routeMatch->getParam('lang','en');
		$session = new Container('POSBookEdit');
		$bookForm = new BookForm(); 
	    $request = $this->getRequest(); 
	    if($request->isPost()) {
	        $bookFormValidator = new BookFormValidator();
	        {
				$bookForm->setInputFilter($bookFormValidator->getInputFilter()); 
				$bookForm->setData($request->getPost()); 
 	        }
	        if($bookForm->isValid()) {
	        	$name = $request->getPost('name');
				$stock = $request->getPost('stock');
				$price = $request->getPost('price');
				$this->posDatabasePlugin()->saveBook($name,$stock,$price);
	        	$this->flashMessenger()->addMessage('New Book Has Been Added !');
	            return $this->redirect()->toRoute('book', array('lang' => $lang,'action' => 'index'));
	        }
	    }
		return new ViewModel(array(
		    'bookForm' => $bookForm,
		    'lang' => $lang
		));
	}

	public function editAction()
	{
		$routeMatch = $this->getEvent()->getRouteMatch();
    	$lang = $routeMatch->getParam('lang','en');
		$session = new Container('POSBookEdit');
		if(!isset($session->book)) {
			$this->flashMessenger()->addMessage('Book with the ID specified not found !');
    		return $this->redirect()->toRoute('book', array('lang' => $this->lang,'action' => 'index'));
		} else {
			$bookForm = new BookForm();
		    $request = $this->getRequest(); 
		    if($request->isPost()) {
		        $bookFormValidator = new BookFormValidator();
		        {
					$bookForm->setInputFilter($bookFormValidator->getInputFilter()); 
					$bookForm->setData($request->getPost()); 
	 	        }
		        if($bookForm->isValid()) {
					$this->posDatabasePlugin()->updateBook($session->book['id'],$request->getPost('name'),$request->getPost('stock'),$request->getPost('price'));
		        	$this->flashMessenger()->addMessage('Book Data Has Been Updated !');
		            return $this->redirect()->toRoute('book', array('lang' => $lang,'action' => 'index'));
		        }
		    } else {
		    	$bookForm->get('name')->setValue($session->book['name']);
		    	$bookForm->get('stock')->setValue($session->book['stock']);
		    	$bookForm->get('price')->setValue($session->book['price']);
		    }
			return new ViewModel(array(
			    'bookForm' => $bookForm,
			    'lang' => $lang
			));	
		}
	}

	public function prepareEditAction()
	{
		$routeMatch = $this->getEvent()->getRouteMatch();
    	$id = $routeMatch->getParam('id',null);
    	$lang = $routeMatch->getParam('lang','en');
		$session = new Container('POSBookEdit');
		$session->book = array();
    	if($id === null) {
    		$this->flashMessenger()->addMessage('Book with the ID specified not found !');
    		return $this->redirect()->toRoute('book', array('lang' => $lang,'action' => 'index'));
    	} else {
    		$session->book = $this->posDatabasePlugin()->getBook($id);
			return $this->redirect()->toRoute('edit_entry', array('lang' => $lang,'action' => 'edit'));
    	}
	}

	public function deleteAction()
	{
		return new ViewModel(array(
		    
		));
	}
}

?>