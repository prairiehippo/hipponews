<?php
namespace Response;

class HTTPResponse implements ResponseInterface {

    protected $config;
    protected $_data = array();
    protected $_viewPath;
    protected $_layoutPath;

    public function __construct(array $config = array()){
        $this->config = $config;
        $this->setLayout('layout.phtml'); //default layout

    }

    public function set($key, $value) {
        $this->_data[$key] = $value;
    }

    public function setArgs(array $args) {
        $this->_data = array_merge($this->_data, $args);
    }

    public function setView($viewPath) {
        $this->_viewPath = $this->config['views']['view_path'] . '/' . $viewPath;
    }

    public function setLayout($layoutPath) {
        $this->_layoutPath = $this->config['views']['layout_path'] . '/' . $layoutPath;
    }

    public function showView(array $args, $viewPath, $layoutPath) {
        $this->setArgs($args);
        $this->setView($viewPath);
        $this->setLayout($layoutPath);
        return $this->renderResponse();
    }

    public function render() {
        $data = $this->_data;
        foreach($data as $key => $value){
            ${$key} = $value;
        }
        ob_start();
        require_once $this->_viewPath;
        $content = ob_get_clean();

        ob_start();
        require_once $this->_layoutPath;
        return ob_get_clean();
    }

}
