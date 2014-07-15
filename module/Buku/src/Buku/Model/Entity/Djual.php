<?php

namespace Buku\Model\Entity;

class Djual
{
	private $id;
	private $buku;
	private $harga;
	private $qty;
	private $subtotal;
	
	public function setId($id)
	{
		$this->id = $id;
	}
	
	public function setBuku($buku)
	{
		$this->buku = $buku;
	}
	
	public function setHarga($harga)
	{
		$this->harga = $harga;
	}
	
	public function setQty($qty)
	{
		$this->qty = $qty;
	}
	
	public function setSubtotal($subtotal)
	{
		$this->subtotal = $subtotal;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getBuku()
	{
		return $this->buku;
	}
	
	public function getHarga()
	{
		return $this->harga;
	}
	
	public function getQty()
	{
		return $this->qty;
	}
	
	public function getSubtotal()
	{
		return $this->subtotal;
	}
}
?>