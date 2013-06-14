<?php
namespace Database;

abstract class DatabaseStatement{

	protected $statement;

	public function __construct(\PDOStatement $statement){
		$this->statement = $statement;
	}

	abstract public function execute($arguments);
	
}