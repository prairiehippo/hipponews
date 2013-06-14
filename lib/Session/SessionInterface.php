<?php
namespace Session;

interface SessionInterface{
	public function authenticate();

    public function unauthenticate();

    public function isAuthenticated();

    public function regenerate();

    public function destroy();
}