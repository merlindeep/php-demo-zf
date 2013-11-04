<?php

class Mrl_Resource_Phpmig extends Zend_Application_Resource_ResourceAbstract
{

    protected $_options = array(
        'tableName'       => "migrations",
        'createStatement' => "CREATE TABLE migrations ( version VARCHAR(255) NOT NULL );"
    );

    public function init()
    {
        Zend_Registry::set(Mrl_Constants::REG_KEY_PHP_MIG, new Zend_Config(array(
            'phpmig' => $this->getOptions()
        )));
    }

}