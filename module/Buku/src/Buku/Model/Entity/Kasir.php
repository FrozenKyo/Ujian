<?php

namespace Buku\Model\Entity;

class Kasir
{
	private $id;
	private $username;
	private $password;
	private $nama;
	private $status;
	
	public function setId($id)
	{
		$this->id = $id;
	}
	
	public function setUsername($username)
	{
		$this->username = $username;
	}
	
	public function setPassword($plaintextPassword, $salt)
    {
        $this->password = crypt($plaintextPassword, '$5$rounds=5000$'.$salt.'$');
        return $this;
    }

    public static function hashPassword($kasir, $password)
    {
        return ($kasir->getPassword() === crypt($password, $kasir->getPassword()));
    }
	
	public function setNama($nama)
	{
		$this->nama = $nama;
	}
	
	public function setStatus($status)
	{
		$this->status = $status;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getUsername()
	{
		return $this->username;
	}
	
	public function getPassword()
	{
		return $this->password;
	}
	
	public function getNama()
	{
		return $this->nama;
	}
	
	public function getStatus()
	{
		return $this->status;
	}
}
?>