<?php

namespace Buku\Model\Entity;

class Hjual
{
	private $id;
	private $tgl;
	private $kasir;
	private $customer;
	private $total;
	private $status;
	
	public function setId($id)
	{
		$this->id = $id;
	}
	
	public function setTgl($tgl)
	{
		$this->tgl = $tgl;
	}
	
	public function setKasir($kasir)
	{
		$this->kasir = $kasir;
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
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getTgl()
	{
		return $this->tgl;
	}
	
	public function getKasir()
	{
		return $this->kasir;
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