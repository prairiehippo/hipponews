<?php
namespace Controller;

class Comment extends Controller{

    protected function _loadModels(){
        $this->comment_model = new \Model\Comment();
    }

    public function create() {
        if(!$this->session->isAuthenticated()) {
            $this->redirect('/');
        }
        $story_id = $this->request->get('story_id');
        $comment = $this->request->get('comment');
        $this->comment_model->create(array(
            $this->session->username,
            $this->request->get('story_id'),
            filter_var($comment, FILTER_SANITIZE_FULL_SPECIAL_CHARS)
        ));

        $this->redirect('story/?id=' . $story_id);
    }

}
