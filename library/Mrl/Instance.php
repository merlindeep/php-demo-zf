<?php

class Mrl_Instance
{
    /**
     * Get Db from MultiDb by name (config id)
     * @param string $name - database id in conf
     * @return Zend_Db_Adapter_Abstract
     */
    public static function db($name = 'db')
    {
        return Zend_Registry::get(Mrl_Constants::REG_KEY_MULTI_DB)->getDb($name);
    }

    /**
     * Get|Set session | Get|Set session values
     * @param string $name
     * @param mixed $value
     * @return mixed|null
     */
    public static function session($name = null, $value = null)
    {
        if (!Zend_Registry::isRegistered(Mrl_Constants::REG_KEY_SESSION)) {
            Zend_Registry::set(Mrl_Constants::REG_KEY_SESSION, new Zend_Session_Namespace());
        }

        $session = &Zend_Registry::get(Mrl_Constants::REG_KEY_SESSION);
        if ($name && $value) {
            $session->$name = $value;
        }
        return $name ? $session->$name : $session;
    }

    /**
     * unset session value
     * @param string $name
     * @return boolean
     */
    public static function sessionUnset($name)
    {
        if (!Zend_Registry::isRegistered(Mrl_Constants::REG_KEY_SESSION)) {
            Zend_Registry::set(Mrl_Constants::REG_KEY_SESSION, new Zend_Session_Namespace());
        }
        $session = &Zend_Registry::get(Mrl_Constants::REG_KEY_SESSION);
        if (isset($session->$name)) {
            unset($session->$name);
        }
    }

}