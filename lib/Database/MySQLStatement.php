<?php
namespace Database;
use \PDO;

class MySQLStatement extends DatabaseStatement {

	public function __get($property_name) {
		if($property_name == 'row_count') {
			return $this->statement->rowCount();
		}

		return parent::__get($property_name);
	}

	public function execute($arguments) {
		try{
			$this->statement->execute($arguments);	
		}
		catch (\PDOException $e){
			throw new Exception\DatabaseException('Could not complete query.  Database returned: ' . $e->getMessage());
		}
	}

	public function fetchAll() {
		$result = $this->statement->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	public function fetch() {
		$result = $this->statement->fetch(PDO::FETCH_ASSOC);
		return $result;
	}
}