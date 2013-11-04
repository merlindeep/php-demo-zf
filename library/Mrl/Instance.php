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

}