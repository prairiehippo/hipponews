<?php
namespace Database\Exception;
use \Exception;

class DatabaseException extends Exception{
	public function __construct($message){
		$this->message = $message;
	}
}