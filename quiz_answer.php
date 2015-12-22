<?php
// json header
header('Content-Type: application/json; charset=UTF8');

// start session
session_start();

// require files
require 'configs/configs.ini.php';
require 'configs/questions.php';
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
		$userAnswerModel->update(array('answer_id' => $answerId), $userAnswer['id']);		
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

		if ($questionId > 1) {
			// get all answers
			$userAnswers = $userAnswerModel->findAllBy('user_id', $sessUser->getId());

			// profile data
			$profiles = array();

			// iterate user answers
			foreach ($userAnswers as $userAnswer) {
				$profile = $questions['answers'][$userAnswer['question_id']['profile']][$userAnswer['answer_id'] - 1]['profile'];
				if (!isset($profiles[$profile])) {
					$profiles[$profile] = 0;
				}
				$profiles[$profile]++;
			}

			// max count
			$maxCount = 0;
			// user profile
			$userProfile = '';

			// get profile with max count
			foreach ($profiles as $profile => $count) {
				if ($maxCount < $count) {
					$userProfile = strtolower($profile);
					$maxCount = $count;

					// update profile in response and session
					$result->profile = $userProfile;
					$_SESSION['profile'] = $result->profile;
				}
			}

			// update user profile
			$userModel = new \Model\User();
			$userModel->update(array('profile' => $result->profile), $sessUser->getId());
		}
	}
}

// print result
echo json_encode($result);