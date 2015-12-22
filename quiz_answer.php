<?php
// json header
header('Content-Type: application/json; charset=UTF8');

// start session
session_start();

// require files
require 'configs/configs.ini.php';
require PROJECT_PATH . 'src/UserAnswer.php';
require PROJECT_PATH . 'src/Session.php';

// user session
$sessUser = new \Src\Session();

// question id
$questionId = (!empty($_GET['question_id'])) ? $_GET['question_id'] : 0;
$answerId = (!empty($_GET['answer_id'])) ? $_GET['answer_id'] : 0;

// user must be logged in and question id is mandatory
if ($sessUser->getIsLoggedIn() && $questionId && $answer) {
	// user answer model
	$userAnswerModel = new \Model\UserAnswer();
	$userAnswer = $userAnswerModel->findByUserAndQuestion($sessUser->getPrimaryKey(), $questionId);

	// response
	$result = new stdClass();
	$result->status = 'ERROR';
	$result->error = 'AweSomething went wrong!';

	// user already exists
	if ($userAnswer !== false) {
		$userAnswer->update(array('answer' => $answerId), $userAnswer->);
		$result->status = 'OK';
		$result->error = '';
	}
}

// print result
echo json_encode($result);