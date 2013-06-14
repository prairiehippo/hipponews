<?php
namespace Model;

class Story extends Model {

    public function getLatestStories(){
        $results = $this->db->query('SELECT * FROM story ORDER BY created_on DESC');
        return $results->fetchAll();
    }

    public function getStory($story_id){
        $results = $this->db->query('SELECT * FROM story WHERE id = ?', array($story_id));
        return $results->fetch();
    }

    public function create($arguments){
        $sql = 'INSERT INTO story (headline, url, created_by, created_on) VALUES (?, ?, ?, NOW())';
        $story_id = $this->db->insert($sql, $arguments);
        return $story_id;
    }
}