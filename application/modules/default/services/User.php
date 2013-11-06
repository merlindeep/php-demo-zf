<?php

class Service_User extends Mrl_Service_Abstract
{
    const SALT_LEN = 9;

    public static function signUp($post)
    {
        $form = new Form_UserSignUp();
        if (!$form->isValid($post)) {
            return array('errors' => $form->getElementsErrorMessages(false));
        }
        $formData = $form->getValues();

        $encryptedPassword = self::_generateHash($formData['password']);

        $user = new Mrl_Model_User();

        $userId = $user->populate(array(
            'email'     => $formData['email'],
            'password'  => $encryptedPassword,
            'date_reg'  => time(),
        ))->save();

        self::_singInUser($user);
        return array('success' => true, 'user_id' => $userId);
    }

    public static function signIn($post)
    {
        $form = new Form_UserSignIn();
        if (!$form->isValid($post)) {
            return array('errors' => $form->getElementsErrorMessages(false));
        }
        $formData = $form->getValues();

        $user = Mrl_Model_User::getByEmail($formData['email']);

        if ($user) {
            if (self::checkHash($formData['password'], $user->password)) {
                self::_singInUser($user);
            } else {
                return array('errors' => array('email' => 'User or password incorrect'));
            }
        } else {
            return array('errors' => array('email' => 'User or password incorrect'));
        }
    }

    private static function _singInUser(Mrl_Model_User $user)
    {
        Zend_Session::rememberMe();
        self::session(Mrl_Constants::REG_KEY_USER_ID, $user->id);
        $user->populate(array(
            'date_last_login' => time()
        ))->save();
    }

    public static function signOut()
    {
        Zend_Session::destroy();
    }

    protected static function checkHash($password, $passwordHash)
    {
        return self::_generateHash($password, $passwordHash) == $passwordHash;
    }

    protected static function _generateHash($plainText, $salt = null)
    {
        if ($salt === null) {
            $salt = substr(md5(uniqid(rand(), true)), 0, self::SALT_LEN);
        } else {
            $salt = substr($salt, 0, self::SALT_LEN);
        }

        return $salt . sha1($salt . $plainText);
    }

}