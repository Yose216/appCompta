<?php

// Get all users
$app->get('/api/users', "appCompta\Controller\UserController::getAllUsers")->bind('users_api');

// Get one users
$app->get('/api/user/{id}', "appCompta\Controller\UserController::getOneUser")->bind('user_api');

// Create user
$app->post('/api/users/create', "appCompta\Controller\UserController::createUser")->bind('user_create');

// Edit user
$app->post('/api/users/edit/{id}', "appCompta\Controller\UserController::editUser")->bind('user_edit');

// Delete user
$app->delete('/api/user/delete/{id}', "appCompta\Controller\UserController::deleteUser")->bind('user_delete');

// Get all groups
$app->get('/api/usersgroup', "appCompta\Controller\User_groupController::getAllGroup")->bind('usersgroup_api');

// Get one group
$app->get('/api/usergroup/{id}', "appCompta\Controller\User_groupController::getOneUserGroup")->bind('usergroup_api');

// Create group
$app->post('/api/usersgroup/create', "appCompta\Controller\User_groupController::createUserGroup")->bind('usersgroup_create');

// Edit group
$app->put('/api/usersgroup/edit/{id}', "appCompta\Controller\User_groupController::editUserGroup")->bind('usersgroup_edit');

// Delete group
$app->delete('/api/usersgroup/delete/{id}', "appCompta\Controller\User_groupController::deleteUserGroup")->bind('usersgroup_delete');

// Get all depense
$app->get('/api/depense', "appCompta\Controller\DepensesController::getAllDepenses")->bind('depense_api');

// Get one depense
$app->get('/api/depenses/{id}', "appCompta\Controller\DepensesController::getOneDepenses")->bind('depenses_api');

// Create depense
$app->post('/api/depense/create', "appCompta\Controller\DepensesController::createDepenses")->bind('depenses_create');

// Edit depense
//$app->put('/api/usersgroup/edit/{id}', "appCompta\Controller\User_groupController::editUserGroup")->bind('usersgroup_edit');

// Delete depense
//$app->delete('/api/usersgroup/delete/{id}', "appCompta\Controller\User_groupController::deleteUserGroup")->bind('usersgroup_delete');
