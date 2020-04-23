<?php
/**
 * Created by PhpStorm.
 * User: Poiz
 * Date: 26/11/14
 * Time: 08:55
 */

	namespace  App\Poiz\HTML\Widgets\FormHelpers;


class ErrorLogger {
	/**
	 * @var array  $errors An Array of Loggable Errors
	 */
	protected $errors   = array();

	public function __construct(){
		// Todo
	}

	/**
	 * @return array
	 * THIS METHOD RETURNS THE INTERNAL ERRORS ARRAY
	 */
	public function getErrors () {
		return $this->errors;
	}

	/**
	 * @param array $errors
	 * @return null
	 * GIVEN AN ARRAY OF ERRORS, THIS METHODS SETS THE INTERNAL ERRORS ARRAY TO THE GIVEN $errors PARAMETER.
	 */
	public function setErrors ($errors) {
		$this->errors = $errors;
	}

	/**
	 * @param string $error_tag         The Name/Tag used to identify a Specific Error
	 * @param string $error_message     The Message associated with the Specific Error in question.
	 * THIS METHOD APPENDS A SPECIFIC ERROR & THE RELATED MESSAGE TO THE ERRORS ARRAY.
	 */
	public function append_to_log($error_tag, $error_message){
		$this->errors[$error_tag] = $error_message;
	}



}
