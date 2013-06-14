<?php
namespace Request;

interface RequestInterface {
    public function get($key, $default = ‘’);
}
