<?php

class Mrl_Validate_EqualInputs extends Zend_Validate_Abstract
{
    const NOT_EQUAL = 'stringsNotEqual';

    protected $_messageTemplates = array(
        self::NOT_EQUAL => 'Strings are not equal'
    );

    protected $_contextKey;

    public function __construct($key, $message = null)
    {
        $this->_contextKey = $key;
        if ($message) {
            $this->_messageTemplates[self::NOT_EQUAL] = $message;
        }
    }

    public function isValid($value, $context = null)
    {
        $value = (string) $value;

        if (is_array($context)) {
            if (isset($context[$this->_contextKey]) && ($value === $context[$this->_contextKey])) {
                return true;
            }
        } else if (is_string($context) && ($value === $context))  {
            return true;
        }

        $this->_error(self::NOT_EQUAL);

        return false;
    }
}