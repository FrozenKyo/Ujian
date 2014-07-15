<?php

namespace Buku\Model\Entity;

class Buku
{
	private $id;
	private $nama;
	private $stok;
	private $harga;
	private $status;
	
	public function setId($id)
	{
		$this->id = $id;
	}
	
	public function setNama($nama)
	{
		$this->nama = $nama;
	}
	
	public function setStok($stok)
	{
		$this->stok = $stok;
	}
	
	public function setHarga($harga)
	{
		$this->harga = $harga;
	}
	
	public function setStatus($status)
	{
		$this->status = $status;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getNama()
	{
		return $this->nama;
	}
	
	public function getStok()
	{
		return $this->stok;
	}
	
	public function getHarga()
	{
		return $this->harga;
	}
	
	public function getStatus()
	{
		return $this->status;
	}
}
?>