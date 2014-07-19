<?php
namespace Book\Controller;

use \DateTime as DateTime;
use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use DoctrineModule\Paginator\Adapter\Collection as Collection;
use Zend\Paginator\Paginator;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Book\Model\Entity\HeaderSell as HeaderSell;
use Book\Model\Entity\DetailSell as DetailSell;
use Book\Form\HeaderSellForm as headerSellForm;
use Book\Form\HeaderSellFormValidator as headerSellFormValidator;
use Book\Form\DetailSellForm as detailSellForm;
use Book\Form\DetailSellFormValidator as detailSellFormValidator;

Class SellTransactionController extends AbstractActionController
{
	public function indexAction()
	{
		$routeMatch = $this->getEvent()->getRouteMatch();
    	$lang = $routeMatch->getParam('lang','en');
    	$page = $routeMatch->getParam('page',1);

		$headerSells = $this->posDatabasePlugin()->getSellTransactions();
		$collection = new ArrayCollection($headerSells);
		$paginator = new Paginator(new Collection($collection));
		$paginator->setCurrentPageNumber($page);
		$paginator->setItemCountPerPage(5);
        return new ViewModel(array(
        	'lang' => $lang,
        	'page' => $page,
        	'paginator'=> $paginator,
        	'messages' => $this->flashMessenger()->getMessages(),
        	'utilityPlugin' => $this->utilityPlugin(),
        	'posDatabasePlugin' => $this->posDatabasePlugin()
        ));
	}

	public function headerSellAction()
	{
		$routeMatch = $this->getEvent()->getRouteMatch();
    	$lang = $routeMatch->getParam('lang','en');
		$session = new Container('POSBookSellTransaction');
		$headerSellForm = new headerSellForm();
	    $request = $this->getRequest();
	    if($request->isPost()) {
	    	if($request->getPost('next')) {
	    		$headerSellFormValidator = new headerSellFormValidator();
		        {
					$headerSellForm->setInputFilter($headerSellFormValidator->getInputFilter());
					$headerSellForm->setData($request->getPost());
	 	        }
		        if($headerSellForm->isValid()) {
		        	$customer = $request->getPost('customer');
		        	$customer = str_replace(' ','-',trim(ucwords(strtolower($customer))));
		        	$this->flashMessenger()->addMessage('New Transaction Has Been Added !');
		            return $this->redirect()->toRoute('detail_sell', array('lang' => $lang,'customer' => $customer,'action' => 'detailSell'));
		        }
	    	}
	    }
		return new ViewModel(array(
		    'lang' => $lang,
		    'messages' => $this->flashMessenger()->getMessages(),
		    'headerSellForm' => $headerSellForm,
		));
	}

	public function detailSellAction()
	{
		$routeMatch = $this->getEvent()->getRouteMatch();
    	$lang = $routeMatch->getParam('lang','en');
    	$customer = $routeMatch->getParam('customer','Guest');
		$session = new Container('POSBookSellTransaction');
		$posDatabasePlugin = $this->posDatabasePlugin();
		$entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$detailSellForm = new detailSellForm($entityManager);
		$transactionDetails = array();
		if(isset($session->transactionDetails)) {
    		$transactionDetails = $session->transactionDetails;
		} else {
			$session->transactionDetails = array();
		}

		$request = $this->getRequest();
	    if($request->isPost()) {
	    	if($request->getPost('add')) {
	    		$bookAvailability = $this->posDatabasePlugin()->getBookAvailability($request->getPost('book'));
	    		$detailSellFormValidator = new detailSellFormValidator();
		        $detailSellFormValidator->setAvailableID($bookAvailability['availableID']);
		        $detailSellFormValidator->setAvailableStock($bookAvailability['availableStock']);
		        {
					$detailSellForm->setInputFilter($detailSellFormValidator->getInputFilter());
					$detailSellForm->setData($request->getPost());
	 	        }
		        if($detailSellForm->isValid()) {
		        	$bookID = $request->getPost('book');
		        	$bookQty = $request->getPost('qty');
		        	$exists = false;
		        	foreach ($transactionDetails as &$transactionDetail) {
		        		if($bookID === $transactionDetail['bookID']) {
		        			$exists = true;
		        			$transactionDetail['bookQty'] = $bookQty;
		        		}
		        	}
		        	if(!$exists) {
		        		$book = $this->posDatabasePlugin()->getBook($bookID);
		        		array_push($transactionDetails, array('bookID' => $bookID, 'bookName' => $book['name'], 'bookQty' => $bookQty, 'bookPrice' => $book['price']));
		        	}
		        	$session->transactionDetails = $transactionDetails;
		        }
	    	} elseif ($request->getPost('save')) {
	    		if(count($session->transactionDetails)) {
	    			$objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
					$headerSell = new HeaderSell();
					$dateTime = new DateTime;
					$dateTime = $dateTime->format('d M Y H:i:s');
					$headerSell->setDate($dateTime);
					$headerSell->setCasheer(1);
					$headerSell->setCustomer($customer);
					$headerSell->setTotal(0);
					$headerSell->setStatus(true);
					$objectManager->persist($headerSell);
					$objectManager->flush();

					foreach ($session->transactionDetails as $transactionDetail) {
						$detailSell = new DetailSell();
						$detailSell->setID($headerSell->getID());
						$detailSell->setBook($transactionDetail['bookID']);
						$detailSell->setQty($transactionDetail['bookQty']);
						$detailSell->setPrice($transactionDetail['bookPrice']);
						$objectManager->persist($detailSell);
						$objectManager->flush();						
					}
		    		unset($session->transactionDetails);
		    		$this->flashMessenger()->addMessage('Transaction has been saved !');
	           		return $this->redirect()->toRoute('sell_transaction', array('lang' => $lang,'action' => 'index'));
	    		}
	    	}
	    } else {
	    	// On Progress
	    }
		return new ViewModel(array(
			'lang' => $lang,
			'customer' => $customer,
		    'messages' => $this->flashMessenger()->getMessages(),
		    'detailSellForm' => $detailSellForm,
		    'transactionDetails' => $transactionDetails,
		    'utilityPlugin' => $this->utilityPlugin()
		));
	}
}
?>