<?php
// json header
header('Content-Type: application/json; charset=UTF8');

// start session
session_start();

// require files
require 'configs/configs.ini.php';
require PROJECT_PATH . 'src/User.php';
require PROJECT_PATH . 'src/UserAnswer.php';
require PROJECT_PATH . 'src/Session.php';

// user session
$sessUser = new \Src\Session();

// question id
$questionId = (!empty($_GET['question_id'])) ? (int) $_GET['question_id'] : 0;
$answerId = (!empty($_GET['answer_id'])) ? (int) $_GET['answer_id'] : 0;

// response
$result = new stdClass();
$result->status = 'ERROR';
$result->error = 'AweSomething went wrong!';
$result->profile = '';

// user must be logged in and question id is mandatory
if ($sessUser->getIsLoggedIn() && $questionId && $answerId) {
	// user answer model
	$userAnswerModel = new \Model\UserAnswer();
	$userAnswer = $userAnswerModel->findByUserAndQuestion($sessUser->getId(), $questionId);

	// user already exists
	if ($userAnswer !== false) {
		$userAnswer->update(array('answer' => $answerId), $userAnswer->getPrimaryKey());		
	} else {
		$userAnswer = $userAnswerModel->save(array(
			'user_id' => $sessUser->getId(),
			'question_id' => $questionId,
			'answer_id' => $answerId
		)); 
	}

	// all good?
	if ($userAnswer) {
		$result->status = 'OK';
		$result->error = '';

		if ($questionId > 9) {
			// get user profile
			$userModel = new \Model\User();
			$result->profile = $userModel->find($sessUser->getId());
		}
	}
}

// print result
echo json_encode($result);