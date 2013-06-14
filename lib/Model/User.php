<?php
namespace Model;

class User extends Model {

	public function checkUserNameExists($username){
        $results = $this->db->query( 'SELECT * FROM user WHERE username = ?', array($username));
        return $results->row_count > 0 ? true : false;
	}

	public function create($arguments){
		$sql = 'INSERT INTO user (username, email, password) VALUES (?, ?, ?)';
        $user_id = $this->db->insert($sql, $arguments);
        return $user_id;
	}

	public function getUser($username){
		$results = $this->db->query( 'SELECT * FROM user WHERE username = ?' , array($username));
		$user = $results->fetch();
		return $user;
	}

	public function login($username, $password){
		$password = md5($username . $password); // THIS IS NOT SECURE. DO NOT USE IN PRODUCTION.
		$sql = 'SELECT * FROM user WHERE username = ? AND password = ? LIMIT 1';
		$results = $this->db->query( 'SELECT * FROM user WHERE username = ?', array($username));
        $user = $results->fetch();
        return $user;
	}

	public function updateUserPassword($username, $password){
        $sql = 'UPDATE user SET password = ? WHERE username = ?';
        $this->db->update($sql, array($username, md5($this->session->username . $password)));
	}
}