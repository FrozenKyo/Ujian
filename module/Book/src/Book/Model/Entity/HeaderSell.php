<?php
namespace Book\Model\Entity;

class HeaderSell
{
	private $id;
	private $date;
	private $casheer;
	private $customer;
	private $total;
	private $status;

	public function setID($id)
	{
		$this->id = $id;
	}

	public function setDate($date)
	{
		$this->date = $date;
	}

	public function setCasheer($casheer)
	{
		$this->casheer = $casheer;
	}

	public function setCustomer($customer)
	{
		$this->customer = $customer;
	}

	public function setTotal($total)
	{
		$this->total = $total;
	}

	public function setStatus($status)
	{
		$this->status = $status;
	}

	public function getID()
	{
		return $this->id;
	}

	public function getDate()
	{
		return $this->date;
	}

	public function getCasheer()
	{
		return $this->casheer;
	}

	public function getCustomer()
	{
		return $this->customer;
	}

	public function getTotal()
	{
		return $this->total;
	}

	public function getStatus()
	{
		return $this->status;
	}
}
?>