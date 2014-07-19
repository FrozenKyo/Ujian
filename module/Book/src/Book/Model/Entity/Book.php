<?php
namespace Book\Model\Entity;

class Book 
{
	private $id;
	private $name;
	private $stock;
	private $price;
	private $status;

	public function setID($id) {
		$this->id = $id;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function setStock($stock) {
		$this->stock = $stock;
	}

	public function setPrice($price) {
		$this->price = $price;
	}

	public function setStatus($status) {
		$this->status = $status;
	}

	public function getID() {
		return $this->id;
	}

	public function getName() {
		return $this->name;	
	}

	public function getStock() {
		return $this->stock;
	}

	public function getPrice() {
		return $this->price;
	}

	public function getStatus() {
		return $this->status;
	}
}