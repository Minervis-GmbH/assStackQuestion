<?php

// fim: [debug] optionally set error before initialisation
error_reporting(E_ALL);
ini_set("display_errors", "on");
// fim.

chdir("../../../../../../../../../");

// Avoid redirection to start screen
// (see ilInitialisation::InitILIAS for details)

require_once "./include/inc.header.php";
require_once './Customizing/global/plugins/Modules/TestQuestionPool/Questions/assStackQuestion/classes/utils/class.assStackQuestionUtils.php';
//Initialization (load of stack wrapper classes)
require_once './Customizing/global/plugins/Modules/TestQuestionPool/Questions/assStackQuestion/classes/utils/class.assStackQuestionInitialization.php';

header('Content-type: application/json; charset=utf-8');
echo json_encode(checkUserResponse($_REQUEST['question_id'], $_REQUEST['inputs'], $_REQUEST['prt_name']));
exit;

/**
 * Gets the students answer and send it to maxima in order to get the validation.
 * @param string $student_answer
 * @return string the Validation message.
 */
function checkUserResponse($question_id, $inputs, $prt_name)
{
	require_once './Customizing/global/plugins/Modules/TestQuestionPool/Questions/assStackQuestion/classes/class.assStackQuestion.php';
	require_once './Customizing/global/plugins/Modules/TestQuestionPool/Questions/assStackQuestion/classes/model/class.assStackQuestionStackQuestion.php';

	$ilias_question = new assStackQuestion();
	$ilias_question->loadFromDb($question_id);
	//v1.6+ Randomisation improvements
	$active_id = $_GET['active_id'];
	require_once "./Modules/Test/classes/class.ilObjTest.php";
	$pass = ilObjTest::_getPass($active_id);
	if (is_int($active_id) AND is_int($pass))
	{
		$stack_question = new assStackQuestionStackQuestion($active_id, $pass);
		$stack_question->init($ilias_question, "");
	} else
	{
		$stack_question = new assStackQuestionStackQuestion();
		$seed = $_SESSION['q_seed_for_preview_' . $_GET['q_id'] . ''];
		$stack_question->init($ilias_question, "", $seed);
	}

	//Get user responses
	$user_responses = array();
	foreach ($inputs as $input)
	{
		$pos = strpos($input, '_');
		$input_name = substr($input, 0, $pos);
		$input_value = substr($input, $pos + 1);

		$user_responses[$input_name] = $input_value;
	}

	//
	//PRT to be evaluated
	$potentialresponse_tree = $stack_question->getPRTs($prt_name);

	//Array with all imputs evaluated by this PRT
	$prt_inputs = array();

	//Checking of inputs
	foreach ($potentialresponse_tree->get_required_variables(array_keys($stack_question->getInputs())) as $input_name)
	{
		$input = $stack_question->getInputs($input_name);
		if (is_a($input, "stack_equiv_input") OR is_a($input, "stack_textarea_input"))
		{
			$stack_response = $input->maxima_to_response_array("[" . $user_responses[$input_name] . "]");
		} elseif (is_a($input, "stack_matrix_input"))
		{
			//
		} else
		{
			$stack_response = $input->maxima_to_response_array($user_responses[$input_name]);
		}

		$input_state = $input->validate_student_response($stack_response, $stack_question->getOptions(), $stack_question->getSession()->get_value_key($input_name), "");

		if (stack_input::SCORE == $input_state->status || (stack_input::VALID == $input_state->status))
		{
			$prt_inputs[$input_name] = $input_state->__get("contentsmodified");
		}else{
			$message = '<div class="xqcas_feedback_class_3"><p>' . $input_state->__get("errors");
			$message .= '</p></div>';
			return $message;
		}
	}

	//Evaluate PRT
	$prt_state = $potentialresponse_tree->evaluate_response($stack_question->getSession(), $stack_question->getOptions(), $prt_inputs, $seed);

	//Get feedback
	//For each feedback obj add a line the the message with the feedback.
	$feedback = "";
	if ($prt_state->__get('feedback'))
	{
		foreach ($prt_state->__get('feedback') as $feedback_obj)
		{
			if (strlen($prt_state->substitue_variables_in_feedback($feedback_obj->feedback)))
			{
				switch ($feedback_obj->format)
				{
					case NULL:
						//$feedback .= '<div class="xqcas_feedback_class_4"><p>' . $prt_state->substitue_variables_in_feedback($feedback_obj->feedback);
						//$feedback .= '</p></div>';
						break;
					case "2":
						$feedback .= '<div class="xqcas_feedback_class_2"><p>' . $prt_state->substitue_variables_in_feedback($feedback_obj->feedback);
						$feedback .= '</p></div>';
						break;
					case "3":
						$feedback .= '<div class="xqcas_feedback_class_3"><p>' . $prt_state->substitue_variables_in_feedback($feedback_obj->feedback);
						$feedback .= '</p></div>';
						break;
					case "4":
						$feedback .= '<div class="xqcas_feedback_class_4"><p>' . $prt_state->substitue_variables_in_feedback($feedback_obj->feedback);
						$feedback .= '</p></div>';
						break;
					case "5":
						$feedback .= '<div class="xqcas_feedback_class_5"><p>' . $prt_state->substitue_variables_in_feedback($feedback_obj->feedback);
						$feedback .= '</p></div>';
						break;
					case "6":
						$feedback .= '<div class="xqcas_feedback_class_6"><p>' . $prt_state->substitue_variables_in_feedback($feedback_obj->feedback);
						$feedback .= '</p></div>';
						break;
					case "7":
						$feedback .= '<div class="xqcas_feedback_class_7"><p>' . $prt_state->substitue_variables_in_feedback($feedback_obj->feedback);
						$feedback .= '</p></div>';
						break;
				}
			}
		}
		if (strlen($prt_state->__get("errors")))
		{
			$feedback .= '<div class="xqcas_feedback_class_3"><p>' . $prt_state->__get("errors");
			$feedback .= '</p></div>';
		}

	}

	return $feedback;

	//Calculate results for user_solution before save it
	//Create evaluation object
	$this->plugin->includeClass("model/question_evaluation/class.assStackQuestionEvaluation.php");
	$evaluation_object = new assStackQuestionEvaluation($this, $this->getStackQuestion(), $user_responses);
	//Evaluate question
	$question_evaluation = $evaluation_object->evaluateQuestion();

	$stack_input = $stack_question->getInputs($input_name);
	$stack_options = $stack_question->getOptions();
	$teacher_answer = $stack_input->get_teacher_answer();

	if (is_a($stack_input, "stack_equiv_input") OR is_a($stack_input, "stack_textarea_input"))
	{
		$stack_response = $stack_input->maxima_to_response_array("[" . $user_response . "]");
	} elseif (is_a($stack_input, "stack_matrix_input"))
	{

		$input = $stack_question->getInputs($input_name);
		$forbiddenwords = $input->get_parameter('forbidWords', '');
		$array = $input->maxima_to_response_array($user_response);

		$state = $stack_question->getInputState($input_name, $array, $forbiddenwords);

		$result = array('input' => $user_response, 'status' => $state->status, 'message' => $input->render_validation($state, $input_name),);

		return $result['message'];
	} else
	{
		$stack_response = $stack_input->maxima_to_response_array($user_response);
	}

	$status = $stack_input->validate_student_response($stack_response, $stack_options, $teacher_answer, null);

	$result = array('input' => $user_response, 'status' => $status->status, 'message' => $stack_input->render_validation($status, $input_name));

	return $result['message'];
}