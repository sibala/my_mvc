<?php

namespace Core;

class Request
{
	private $previousHash;
	public $hash;

	public function __construct()
	{
		if (isset($_SESSION['request_token'])) {
			$this->previousHash = $_SESSION['request_token'];
		}
		$this->hash = $_SESSION['request_token'] = bin2hex(random_bytes(32));
	}

	public function is_valid()
	{
		return isset($_POST['csrf_token']) && ($_POST['csrf_token'] === $this->previousHash);
	}

	public function meta_tag()
	{
		return '<meta name="csrf_token" value="' . $this->hash . '" />';
	}

	public function csrf_field()
	{
		return '<input type="hidden" name="csrf_token" value="' . $this->hash . '" />';
	}
}