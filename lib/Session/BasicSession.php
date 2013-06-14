<?php
namespace Session;

class BasicSession implements SessionInterface {

    public function __construct() {
        session_start();
    }

    public function __get($name) {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
    }

    public function __set($name, $value) {
        $_SESSION[$name] = $value;
    }

    public function authenticate() {
        $_SESSION['AUTHENTICATED'] = true;
    }

    public function unauthenticate() {
        unset($_SESSION['AUTHENTICATED']);
    }

    public function isAuthenticated() {
        return $this->AUTHENTICATED;
    }

    public function regenerate() {
        session_regenerate_id();
    }

    public function destroy() {
        unset($_SESSION);
        session_destroy();
    }

}
