<?php
namespace Controller;

abstract class Controller{

	protected $config;
	protected $session;
    protected $request;

	public function __construct(array $config = array(), \Session\SessionInterface $session, \Request\RequestInterface $request){
		$this->config = $config;
		$this->session = $session;
        $this->request = $request;
		$this->_loadModels();
	}

	abstract protected function _loadModels();

    public function redirect($path){
        $path = substr($path, 0, 1) == '/' ? $path : '/' . $path;
        $response = new \Response\HTTPRedirectResponse($path);
        $response->render();
    }
}
