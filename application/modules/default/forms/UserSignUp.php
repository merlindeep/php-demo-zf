<?php

class Form_UserSignUp extends Mrl_Form
{
    public function init()
    {
        $this->addElement('text', 'email', array(
            'required' => true,
            'validators' => array(
                array('NotEmpty', true, array('messages' => 'Email cannot be empty')),
                array('EmailAddress', true, array('messages' => 'Email address is invalid')),
                array('Unique', true, array(Mrl_Model_User::getMapper(), 'email', null,
                    array(new Zend_Filter_StringToLower(array('encoding' => 'utf-8'))), false,
                    "%value% is already used"
                ))
            )
        ));

        $this->addElement('text', 'name', array(
            'required' => true,
            'validators' => array(
                array('NotEmpty', true, array('messages' => _('Name cannot be empty'))),
                array('StringLength', true, array(
                    'min' => 1, 'max' => 255,
                    'messages' => 'Name length should be between 1 and 255 characters',
                    'encoding' => 'utf-8'
                )),
            )
        ));

        $this->addElement('password', 'password', array(
            'required'   => true,
            'validators' => array(
                array('NotEmpty', true, array('messages' => 'Password cannot be empty')),
                array('StringLength', true, array(
                    'min' => 6, 'max' => 39,
                    'messages' => 'Password length should be between 6 and 39 characters',
                    'encoding' => 'utf-8'
                )),
            )
        ));

        $this->addElement('password', 'password_repeat', array(
            'required'   => true,
            'validators' => array(
                array('NotEmpty', true, array('messages' => 'Password cannot be empty')),
                array('EqualInputs', true, array('password', 'Passwords do not match')),
            )
        ));

        parent::init();
    }

}
