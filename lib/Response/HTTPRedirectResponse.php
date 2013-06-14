<?php
namespace Response;

class HTTPRedirectResponse implements ResponseInterface {

    protected $_url;

    public function __construct($url = ''){
        $this->setURL($url);
    }

    public function setURL($url) {
        $this->_url = $url;
    }

    public function render() {
        header('Location: ' . $this->_url);
    }
}
