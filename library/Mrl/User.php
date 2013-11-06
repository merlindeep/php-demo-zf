<?php

class Mrl_User
{
    /**
     * @var Mrl_Model_User
     */
    protected static $_instance = null;
    protected static $_id       = null;

    public static function getId()
    {
        if (null === self::$_id) {
            self::$_id = Mrl_Instance::session(Mrl_Constants::REG_KEY_USER_ID);
        }
        return self::$_id;
    }

    public static function getCurrent()
    {
        if (null === self::$_instance) {
            $id = self::getId();
            if (null !== $id) {
                self::$_instance = Mrl_Model_User::fetch($id);
            }
        }
        return self::$_instance;
    }

    public static function isGuest()
    {
        return null === self::getCurrent();
    }

}