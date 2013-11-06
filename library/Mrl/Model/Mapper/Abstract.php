<?php

abstract class Mrl_Model_Mapper_Abstract extends Zend_Db_Table
{
    protected $_db = 'db';

    /**
     * Initialize database adapter.
     * @return void
     * @throws Zend_Db_Table_Exception
     */
    protected function _setupDatabaseAdapter()
    {
        if (!$this->_db) {
            $this->_db = self::getDefaultAdapter();
        } elseif (is_string($this->_db)) {
            $this->_db = Mrl_Instance::db($this->_db);
        }

        if (!$this->_db instanceof Zend_Db_Adapter_Abstract) {
            throw new Zend_Db_Table_Exception('No adapter found for ' . get_class($this));
        }
    }

    /**
     * @param $id
     * @return Zend_Db_Table_Select
     * @throws Zend_Db_Table_Exception
     */
    protected function _getSelectForId($id)
    {
        $id = (array) $id;
        $primary = (array) $this->_primary;

        if (count($id) != count($primary)) {
            throw new Zend_Db_Table_Exception("Number columns for the primary key not same as args");
        }

        $values = array_values($id);
        $select = $this->select(true);
        foreach (array_values($primary) as $key => $column) {
            $select->where($column . ' = ?', $values[$key]);
        }
        return $select;
    }

    /**
     * Fetch object by primary key
     * @param int|array $id      same order as in $this->_primary
     * @return Ais_Model
     */
    public function fetch($id)
    {
        return $this->fetchRow($this->_getSelectForId($id));
    }
}