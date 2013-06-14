<?php
namespace Controller;

class Story extends Controller {

    protected $data_object;
    protected $story_model;
    protected $comment_model;

    protected function _loadModels(){

        $this->data_object = new \Model\Story\Data();
        $this->story_model = new \Model\Story\Gateway($this->data_object);

        $this->comment_model = new \Model\Comment();
    }

    public function index() {

        if(!$this->request->get('id', false)) {
            $this->redirect('/');
        }

        if(!($story = $this->story_model->getStory($this->request->get('id')))){
            $this->redirect('/');
        }

        $response = new \Response\HTTPResponse($this->config);
        $comments = $this->story_model->getCommentsForStory($story->id);
        $comment_count = count($comments);

        $response = new \Response\HTTPResponse($this->config);
        $response->setView('story_index.phtml');
        $response->set('story', $story);
        $response->set('comment_count', $comment_count);
        $response->set('comments', $comments);
        $response->set('is_authenticated', $this->session->isAuthenticated());

        echo $response->render();
    }

    public function create() {

        if(!$this->session->isAuthenticated()) {
            $this->redirect('user/login');
        }

        $error = '';

        if( ($this->request->get('create', false)) ) {
            try{
                $params = array(
                    'headline' => $this->request->get('headline'),
                    'url' => $this->request->get('url'),
                    'username' => $this->session->username,
                );
                $id = $this->story_model->save($params);
                $this->redirect("story?id=$id");
            }
            catch (\Model\Story\StoryException $e){
                $error = $e->getMessage();
            }
        }

        $response = new \Response\HTTPResponse($this->config);
        $response->setView('story_create.phtml');
        $response->set('error', $error);
        echo $response->render();
    }

}
