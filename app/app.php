<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\Request;

ErrorHandler::register();
ExceptionHandler::register();

$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'secured' => array(
            'pattern' => '^/',
            'anonymous' => true,
            'logout' => true,
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'users' => $app->share(function () use ($app) {
                return new appCompta\DAO\UserDAO($app['db']);
            }),
        ),
    ),
	'security.role_hierarchy' => array(
    	'ROLE_ADMIN' => array('ROLE_USER'),
    ),
    'security.access_rules' => array(
        array('^/admin', 'ROLE_ADMIN'),
    ),
));

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../var/logs/appCompta.log',
    'monolog.name' => 'appCompta',
    'monolog.level' => $app['monolog.level']
));

$app['dao.user'] = $app->share(function ($app) {
	return new appCompta\DAO\UserDAO($app['db']);
});

$app['dao.user_group'] = $app->share(function ($app) {
	return new appCompta\DAO\User_groupDAO($app['db']);
});

$app['dao.user_has_user_group'] = $app->share(function ($app) {
	return new appCompta\DAO\Users_has_user_groupDAO($app['db']);
});

$app['dao.depenses'] = $app->share(function ($app) {
	return new appCompta\DAO\DepensesDAO($app['db']);
});

$app['dao.concernes'] = $app->share(function ($app) {
	return new appCompta\DAO\ConcernesDAO($app['db']);
});

// Register JSON data decoder for JSON requests
$app->before(function (Request $request) {
	if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
		$data = json_decode($request->getContent(), true);
		$request->request->replace(is_array($data) ? $data : array());
	}
});
