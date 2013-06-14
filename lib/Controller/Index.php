<?php
namespace Controller;

class Index extends Controller {

    protected $story_model;

    protected function _loadModels(){
        $this->data_object = new \Model\Story\Data();
        $this->story_model = new \Model\Story\Gateway($this->data_object);
    }

    public function index() {

        //get a list of stories from the story model
        $stories = $this->story_model->getLatestStories();
        $response = new \Response\HTTPResponse($this->config);
        $response->setView('index.phtml');
        $response->set('stories', $stories);
        echo $response->render();
    }
}
