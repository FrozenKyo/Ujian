<?php
namespace Book\Model\Entity;

class Casheer 
{
	private $id;
	private $usernname;
	private $password;
	private $name;	
	private $status;

	public function setID($id) {
		$this->id = $id;
	}

	public function setUsername($username) {
		$this->username = $username;
	}

	public function setPassowrd($password) {
		$this->password = $password;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function setStatus($status) {
		$this->status = $status;
	}

	public function getID() {
		return $this->id;
	}

	public function getUsername() {
		return $this->username;	
	}

	public function getPassword() {
		return $this->password;
	}

	public function getName() {
		return $this->name;	
	}

	public function getStatus() {
		return $this->status;
	}
}