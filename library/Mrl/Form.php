<?php

class Mrl_Form extends Zend_Form
{
    public function __construct($options = null)
    {
        parent::__construct($options);

        $this->addElementPrefixPath('Mrl_Validate', 'Mrl/Validate/', 'validate');

    }

    /**
     * @return array|string|bool
     */
    public function getElementsErrorMessages()
    {
        $elements = $this->getElements();
        $errors = array();

        foreach ($elements as $elem) {
            $localErrors = $elem->getMessages();
            if (count($localErrors) == 0) {
                continue;
            }
            foreach ($localErrors as $key => $value) {
                $errors[$elem->getName()] = $value;
                break;
            }
        }
        return $errors;
    }
}