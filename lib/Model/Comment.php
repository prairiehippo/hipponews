<?php
namespace Model;

class Comment extends Model {

    public function getCommentCountForStory($story_id){
        $results = $this->db->query('SELECT COUNT(*) as `count` FROM comment WHERE story_id = ?', array($story_id));
        $count = $results->fetch();
        return $count['count'];
    }

    public function getCommentsForStory($story_id){
        $results = $this->db->query('SELECT * FROM comment WHERE story_id = ?', array($story_id));
        return $results->fetchAll();
    }

    public function create($arguments){
        $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
        $comment_id = $this->db->insert($sql, $arguments);
        return $comment_id;
    }
}