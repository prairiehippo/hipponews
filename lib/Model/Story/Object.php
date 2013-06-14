<?php
namespace Model\Story;

class Object {
    public $id;
    public $headline;
    public $created_by;
    public $created_on;
    public $url;

    protected $comments = array();

    public function initData($id, $headline, $created_by, $created_on, $url, array $comments = array()){
        $this->id = $id;
        $this->headline = $headline;
        $this->created_by = $created_by;
        $this->created_on = $created_on;
        $this->url = $url;
        $this->comments = $comments;
        return $this;
    }

    public function getComments(){
        return $this->comments;
    }

    public function getCommentCount(){
        return count($this->getComments());
    }

    public function setComments(array $comments){
        $this->comments = $comments;
    }

}
