<?php
namespace Book\Model\Entity;

class DetailSell
{
	private $id;
	private $book;
	private $qty;
	private $price;

	public function setID($id)
	{
		$this->id = $id;
	}

	public function setBook($book)
	{
		$this->book = $book;
	}

	public function setQty($qty)
	{
		$this->qty = $qty;
	}

	public function setPrice($price)
	{
		$this->price = $price;
	}

	public function getID()
	{
		return $this->id;
	}

	public function getBook()
	{
		return $this->book;
	}

	public function getQty()
	{
		return $this->qty;
	}

	public function getPrice()
	{
		return $this->price;
	}
}
?>