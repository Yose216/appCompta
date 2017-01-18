<?php

namespace appCompta\Controller;
	
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use appCompta\Domain\User;

class AdminController {
	
	public function login(Request $request, Application $app) {
       $login = $app['dao.user']->login();
    }
}
