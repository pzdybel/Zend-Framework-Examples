<?php

class LS_Validate_Model_User_Password extends Zend_Validate_Abstract
{

	const LENGTH_MIN = 'lengthMin';

	const LENGTH_MAX = 'lengthMax';

	const UPPER = 'upper';

	const LOWER = 'lower';

	const DIGIT = 'digit';

	protected $_messageTemplates = array(
		self::LENGTH_MIN => "'%value%' must be at least 12 characters long",
		self::LENGTH_MAX => "'%value%' must be less than 32 characters long",
		self::UPPER => "'%value%' must contain at least one uppercase letter",
		self::LOWER => "'%value%' must contain at least one lowercase letter",
		self::DIGIT => "'%value%' must contain at least one digit character"
	);

	public function isValid($value)
	{
		$this->_setValue($value);

		$isValid = true;

		if(strlen($value) < 12) {
			$this->_error(self::LENGTH_MIN);
			$isValid = false;
		}
		if(strlen($value) > 32) {
			$this->_error(self::LENGTH_MAX);
			$isValid = false;
		}
		if(!preg_match('/[A-Z]/', $value)) {
			$this->_error(self::UPPER);
			$isValid = false;
		}
		if(!preg_match('/[a-z]/', $value)) {
			$this->_error(self::LOWER);
			$isValid = false;
		}
		if(!preg_match('/\d/', $value)) {
			$this->_error(self::DIGIT);
			$isValid = false;
		}

		return $isValid;
	}

}
