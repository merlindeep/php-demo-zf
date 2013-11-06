<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    public function getResourceLoader()
    {
        if ((null === $this->_resourceLoader)
            && (false !== ($namespace = $this->getAppNamespace()))
        ) {
            $this->setResourceLoader(new Zend_Application_Module_Autoloader(array(
                'namespace' => '',
                'basePath' => APPLICATION_PATH . '/modules/default'
            )));
        }
        return $this->_resourceLoader;
    }

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