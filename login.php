<?php
require 'src/Session.php';

$sessUser = new \Src\Session();
$sessUser->logIn((isset($_GET['fb_id'])) ? $_GET['fb_id'] : '');

// TODO redirect to questions
