<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initDB()
    {
        /**
         * Add databases to registry
         */
        $multiDb = $this->getPluginResource('multidb');
        $multiDb->init();
        Zend_Registry::set(Mrl_Constants::REG_KEY_MULTI_DB, $multiDb);
    }
}