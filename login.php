<?php
require PROJECT_PATH . 'src/Session.php';

$sessUser = new \Src\Session();
$sessUser->logIn((isset($_GET['fb_id'])) ? $_GET['fb_id'] : '');

// redirect to questions
if ($sessUser->getIsLoggedIn()) {
	header('location: quiz');
	exit(0);
}
