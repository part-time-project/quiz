<?php
// json header
header('Content-Type: application/json; charset=UTF8');

// require files
require 'configs/configs.ini.php';
require 'configs/questions.php';

// question id
$questionId = (!empty($_GET['question_id'])) ? (int) $_GET['question_id'] : 0;

// response
$result = new \stdClass();
$result->status = 'ERROR';
$result->error = 'AweSomething went wrong!';

// user must be logged in and question id is mandatory
if ($questionId && isset($questions['questions'][$questionId])) {
	$result->status = 'OK';
	$result->error = '';

	$result->data = new \stdClass();
	$result->data->question = $questions['questions'][$questionId];
	$result->data->answers = array();

	foreach ($questions['answers'][$questionId] as $answer) {
		$result->data->answers[] = $answer['answer'];
	}
}

// print result
echo json_encode($result);