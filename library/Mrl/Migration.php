<?php

use Phpmig\Migration\Migration;

abstract class Mrl_Migration extends \Phpmig\Migration\Migration
{
    /**
     * @return Zend_Db_Adapter_Abstract
     */
    protected function getDb()
    {
        $container = $this->getContainer();
        /** @var Zend_Db_Adapter_Abstract $db  */
        $db = $container['db'];
        return $db;
    }


    final public function up()
    {
        $db = $this->getDb();
        $db->beginTransaction();
        try{
            $this->upInTransaction();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
        $db->commit();
    }

    final public function down()
    {
        $db = $this->getDb();
        $db->beginTransaction();
        try{
            $this->downInTransaction();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
        $db->commit();
    }

    protected function upInTransaction()
    {}

    protected function downInTransaction()
    {}
}