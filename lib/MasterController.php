<?php

use Request\HTTPRequest;

class MasterController {

    protected $config;
    protected $database;
    protected $session;
    protected $router;

    private function __construct($config){
        spl_autoload_register(array($this, 'autoloader'));
        $this->_setupConfig($config);
    }

    public static function get_instance($config = array()){
        static $instance;
        if(!($instance instanceof MasterController)){
            $instance = new MasterController($config);
        }
        return $instance;
    }

    public function get_database(){
        return $this->database;
    }

    public function execute() {
        $call = $this->router->get_route();
        $call_class = $call['call'];
        $class = 'Controller\\' . array_shift($call_class);
        $method = array_shift($call_class);
        $o = new $class($this->config, $this->session, new HTTPRequest());
        echo($o->$method());
    }

    public function autoloader($className)
    {
        $className = ltrim($className, '\\');
        $fileName  = '';
        $namespace = '';
        if ($lastNsPos = strripos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
        require $fileName;
    }

    public function load_dependancy($prefix, $driver, array $config = array()){
        if(empty($config)){
            $config = $this->config;
        }
        $classname = '\\' . $prefix . '\\' . $driver;
        return new $classname($this->config);
    }

    protected function _setupConfig($config) {

        $this->config = $config;

        //No point continuing if the Database isn't setup.
        if (empty($this->config['database']['driver'])) {
            echo 'No database driver selected.';
            exit();
        }

        //Ensure defaults
        if(empty($this->config['router_driver'])) {
            echo "blah"; exit();
            $this->config['router_driver'] = 'BasicRouter';
        }

        if (empty($this->config['session_driver'])) {
            echo "blah"; exit();
            $this->config['session_driver'] = 'BasicSession';
        }

        $this->router = $this->load_dependancy('Router', $this->config['router_driver']);
        $this->database = $this->load_dependancy('Database', $config['database']['driver'], $config);
        $this->session = $this->load_dependancy('Session', $config['session_driver']);
    }

}
