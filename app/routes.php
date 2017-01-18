<?php

/*********************************************************************************************************
************************** Get, create, edit and delete for user *****************************************
**************************                                       *****************************************
*********************************************************************************************************/

// Get all users
$app->get('/api/users', "appCompta\Controller\UserController::getAllUsers")->bind('users_api');

// Get one users
$app->get('/api/user/{id}', "appCompta\Controller\UserController::getOneUser")->bind('user_api');

// Create user
$app->post('/admin/api/users/create', "appCompta\Controller\UserController::createUser")->bind('user_create');

// Edit user
$app->post('/admin/api/users/edit/{id}', "appCompta\Controller\UserController::editUser")->bind('user_edit');

// Delete user
$app->delete('/admin/api/user/delete/{id}', "appCompta\Controller\UserController::deleteUser")->bind('user_delete');

/*********************************************************************************************************
************************** Get, create, edit and delete for group ****************************************
**************************                                        ****************************************
*********************************************************************************************************/

// Get all groups
$app->get('/api/usersgroup', "appCompta\Controller\User_groupController::getAllGroup")->bind('usersgroup_api');

// Get one group
$app->get('/api/usergroup/{id}', "appCompta\Controller\User_groupController::getOneUserGroup")->bind('usergroup_api');

// Create group
$app->post('/admin/api/usersgroup/create', "appCompta\Controller\User_groupController::createUserGroup")->bind('usersgroup_create');

// Edit group
$app->put('/admin/api/usersgroup/edit/{id}', "appCompta\Controller\User_groupController::editUserGroup")->bind('usersgroup_edit');

// Delete group
$app->delete('/admin/api/usersgroup/delete/{id}', "appCompta\Controller\User_groupController::deleteUserGroup")->bind('usersgroup_delete');

// Delete user of group
$app->delete('/admin/api/user/group/delete/{id}', "appCompta\Controller\User_groupController::deleteUserOfGroup")->bind('userOfgroup_delete');

/*********************************************************************************************************
************************** Get, create, edit and delete for depense **************************************
**************************                                          **************************************
*********************************************************************************************************/

// Get all depense
$app->get('/api/depense', "appCompta\Controller\DepensesController::getAllDepenses")->bind('depense_api');

// Get one depense
$app->get('/api/depenses/{id}', "appCompta\Controller\DepensesController::getOneDepenses")->bind('depenses_api');

// Create depense
$app->post('/admin/api/depense/create', "appCompta\Controller\DepensesController::createDepenses")->bind('depenses_create');

// Edit depense
$app->put('/admin/api/depense/edit/{id}', "appCompta\Controller\DepensesController::editDepenses")->bind('depense_edit');

// Delete depense
$app->delete('/admin/api/depense/delete/{id}', "appCompta\Controller\DepensesController::deleteDepenses")->bind('depense_delete');

// Delete concernes
$app->delete('/admin/api/depense/concernes/delete/{id}', "appCompta\Controller\DepensesController::deleteConcernes")->bind('concernes_delete');

//login
$app->post('/login', "appCompta\Controller\AdminController::login")->bind('login');
