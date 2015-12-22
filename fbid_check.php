<?php
// json header
header('Content-Type: application/json; charset=UTF8');

// start session
session_start();

// require files
require 'configs/configs.ini.php';
require PROJECT_PATH . 'src/User.php';

// user model
$user = new \Model\User();
$userRow = $user->findBy('fb_id', (isset($_GET['fb_id'])) ? $_GET['fb_id'] : '');

// response
$result = new stdClass();
$result->status = 'ERROR';
$result->error = 'fb_id does not exist!';

// user already exists
if ($userRow !== false) {
	$result->status = 'OK';
	$result->error = '';
}

// print result
echo json_encode($result);
