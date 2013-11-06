<?php

class Form_UserSignIn extends Mrl_Form
{
    public function init()
    {
        $this->addElement('text', 'email', array(
            'required' => true,
            'validators' => array(
                array('NotEmpty', true, array('messages' => 'Email cannot be empty')),
                array('EmailAddress', true, array('messages' => 'Email address is invalid')),
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

        parent::init();
    }

}
