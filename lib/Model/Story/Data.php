<?php
namespace Model\Story;

class Data extends \Model\Model {
    public function getLatestStories(){
        $results = $this->db->query('SELECT * FROM story ORDER BY created_on DESC');
        return $results->fetchAll();
    }

    public function getCommentsForStory($story_id){
        $results = $this->db->query('SELECT * FROM comment WHERE story_id = ?', array($story_id));
        return $results->fetchAll();
    }

    public function getStory($story_id){
        $results = $this->db->query('SELECT * FROM story WHERE id = ?', array($story_id));
        return $results->fetch();
    }

    public function create($arguments){
        $sql = 'INSERT INTO story (headline, url, created_by, created_on) VALUES (?, ?, ?, NOW())';
        $story_id = $this->db->insert($sql, array_values($arguments));
        return $story_id;
    }
}
