<?php
namespace Database;
use \PDO;

abstract class Database {
	protected $db;
    protected $config;
    protected $statement;

    public function __construct(array $config){
        $this->config = $config;
        $dbconfig = $config['database'];
        $dsn = 'mysql:host=' . $dbconfig['host'] . ';dbname=' . $dbconfig['name'];
        try{
            $this->db = new PDO($dsn, $dbconfig['user'], $dbconfig['pass']);
        }
        catch (\PDOException $e){
            throw new Exception\DatabaseException('Could not establish connection with the database.');
            die();
        }
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    abstract protected function prepare($sql);

    abstract protected function execute(array $arguments);

	abstract protected function insert($sql, array $arguments);

	abstract protected function update($sql, array $arguments);

	abstract protected function query($sql, array $arguments);

}