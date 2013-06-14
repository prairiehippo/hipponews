<?php
namespace Model\Story;

class Gateway {

    protected $data_layer;

    public function __construct(\Model\Model $data_layer){
        $this->data_layer = $data_layer;
    }

    public function getlatestStories(){
        $stories_to_return = array();
        $stories = $this->data_layer->getLatestStories();
        foreach($stories as $story){
            $comments = $this->data_layer->getCommentsForStory($story['id']);
            $storyObj = new Object();
            $storyObj->initData($story['id'], $story['headline'], $story['created_by'], $story['created_on'], $story['url'], $comments);
            $stories_to_return[] = $storyObj;
        }
        return $stories_to_return;
    }

    public function getStory($story_id){
        $story_id = (int) $story_id;
        if(empty($story_id)){
            throw new StoryException('invalid ID');
        }

        $story = $this->data_layer->getStory($story_id);
        if(empty($story)){
            return false;
        }
        $storyObj = new Object();
        $storyObj->initData($story['id'], $story['headline'], $story['created_by'], $story['created_on'], $story['url']);
        return $storyObj;
    }

    public function getCommentsForStory($story_id){
        return $this->data_layer->getCommentsForStory($story_id);
    }

    public function save(array $params = array()){
        $expected_keys = array('username', 'headline', 'url');

        foreach($expected_keys as $key){
            if(!isset($params[$key])){
                throw new StoryException('Parameters are invalid');
            }
        }

        if(!filter_var($params['url'], FILTER_VALIDATE_URL)){
            throw new StoryException('The URL provided is not valid');
        }

        return $this->data_layer->create($params);
    }
}
