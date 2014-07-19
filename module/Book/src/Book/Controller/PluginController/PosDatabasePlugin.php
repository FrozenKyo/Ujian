<?php
namespace Book\Controller\PluginController;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Book\Model\Entity\Book as Book;

class PosDatabasePlugin extends AbstractPlugin
{
	public function getCasheerName($id)
	{
		$objectManager = $this->getController()->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$casheerAdapter = $objectManager->getRepository('Book\Model\Entity\Casheer');
		$casheer = $casheerAdapter->find($id);
		return $casheer->getName(); 
	}

	public function getBooks($filter)
	{
		$objectManager = $this->getController()->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$queryBuilder = $objectManager->createQueryBuilder();
		$queryBuilder->select(array('b'))
				     ->from('Book\Model\Entity\Book','b')
				     ->where('b.status = :status AND lower(b.name) like :name')
				     ->setParameter('status',true)
				     ->setParameter('name','%' . strtolower($filter) . '%')
				     ->orderBy('b.id','DESC');
		$query=$queryBuilder->getQuery();
		return $query->getResult();
	}

	public function getBookAvailability($id)
	{
		$availableID = array();
		$availableStock = 1;
		$objectManager = $this->getController()->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$queryBuilder = $objectManager->createQueryBuilder();
		$queryBuilder->select(array('b'))
				     ->from('Book\Model\Entity\Book','b')
				     ->where('b.status = :status AND b.stock > 0')
				     ->setParameter('status',true)
				     ->orderBy('b.id','ASC');
		$query = $queryBuilder->getQuery();
		foreach ($query->getResult() as $book) {
			array_push($availableID, $book->getID());
			if(is_int($id)) {
				 if($id == $book->getID()) $availableStock = $book->getStock();
			}
		}
		return array('availableID' => $availableID, 'availableStock' => $book->getStock());
	}
	
	public function getBook($id)
	{	
		$objectManager = $this->getController()->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$bookAdapter = $objectManager->getRepository('Book\Model\Entity\Book');
		$book = $bookAdapter->find($id);

		return array('id'   => $book->getID(),
					 'name' => $book->getName(), 
					 'stock'=> $book->getStock(),
					 'price'=> $book->getPrice()
					);
	}

	public function saveBook($name,$stock,$price)
	{
		$objectManager = $this->getController()->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$book = new Book();
		$book->setName(ucwords(strtolower($name)));
		$book->setStock($stock);
		$book->setPrice($price);
		$book->setStatus(true);
		$objectManager->persist($book);
		$objectManager->flush();
	}

	public function updateBook($id,$name,$stock,$price)
	{
		$objectManager = $this->getController()->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$bookAdapter = $objectManager->getRepository('Book\Model\Entity\Book');
		
		$book = $bookAdapter->find($id);
		$book->setName(ucwords(strtolower($name)));
		$book->setStock($stock);
		$book->setPrice($price);
		$objectManager->flush();
	}

	public function getSellTransactions()
	{
		$objectManager = $this->getController()->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$queryBuilder = $objectManager->createQueryBuilder();
		$queryBuilder->select(array('h'))
				     ->from('Book\Model\Entity\HeaderSell','h')
				     ->where('h.status = :status')
				     ->setParameter('status',true)
				     ->orderBy('h.id','DESC');
		$query=$queryBuilder->getQuery();
		return $query->getResult();
	}
}
?>