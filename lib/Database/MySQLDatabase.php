<?php
namespace Database;

class MySQLDatabase extends Database{

    public function prepare($sql) {
        $this->statement = new MySQLStatement($this->db->prepare($sql));
        return $this;
    }

    public function execute(array $arguments = array()) {
        $this->statement->execute($arguments);
        return $this->statement;
    }

	public function insert($sql, array $arguments = array()) {
        $this->prepare($sql);
    	$this->statement->execute($arguments);
        return $this->db->lastInsertId();
    }

    public function update($sql, array $arguments = array()) {
        return $this->query($sql, $arguments);
    }

    public function query($sql, array $arguments = array()) {
    	$this->prepare($sql);
    	$this->statement->execute($arguments);
    	return $this->statement;
    }

}