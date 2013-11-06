<?php

class Mrl_Validate_Unique extends Zend_Validate_Abstract
{
    /**
     * @var const
     */
    const EXISTS = 'exists';
    
    const NOT_EXISTS = 'notexists';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::EXISTS => '%value% is already used',
        self::NOT_EXISTS => '%value% not found',
    );

    /**
     * @var string
     */
    protected $_table;

    /**
     * @var string
     */
    protected $_field;

    /**
     * @var string
     */
    protected $_condition;
    
    /**
     * Filters to apply before validating
     * @var array()
     */
    protected $_filters = array();
    
    /**
     * Set unique or not unque compasition
     * @var type 
     */
    protected $_exist;


    protected $_filteredValue;
    
    protected $_exceptField = null;
    protected $_exceptValue = null;

        public function __construct($table, $field, $condition = null, $filters = array(), $exist = false, $message = null)
    {
        $this->_table = $table;
        $this->_field = $field;
        $this->_filters = $filters;
        $this->setCondition($condition);

        // Add not equal param
        $this->_exist = $exist;
        if ($this->_exist) {
            unset($this->_messageTemplates[self::EXISTS]);
        }

        if ($message) {
            $this->_messageTemplates[self::EXISTS] = $message;
        }

    }

    public function setCondition($condition)
    {
        $this->_condition = $condition;

        return $this;
    }

    public function setExcept($field, $value)
    {
        $this->_exceptField = $field;
        $this->_exceptValue = $value;

        return $this;
    }
    
    protected function _applyFilters()
    {
    	$this->_filteredValue = $this->_value;
        if (!empty($this->_filters)) {
            foreach ($this->_filters as $filter) {
                $this->_filteredValue = $filter->filter($this->_filteredValue);
            }
        }
    }

    public function isValid($value)
    {
        $this->_setValue($value);
        $this->_applyFilters();

        if ($this->_table instanceof Zend_Db_Table) {
            return $this->_validateDb($this->_table);
        }

        throw new Zend_Validate_Exception('Unknown object passed');
    }

    /**
     * @param Zend_Db_Table $table
     * @return boolean
     */
    protected function _validateDb($table)
    {
        //print_r($table);die();
        $cond = array('lower(' . $table->getAdapter()->quoteIdentifier($this->_field) . ') = ?' => $this->_filteredValue);

        if (!is_null($this->_condition)) {
            $cond[] = $this->_condition;
        }

        $result = $table->fetchRow($cond);
        
        if (($result && !$this->_exist) || (!$result && $this->_exist)) {
            $this->_error(null);
            return false;
        }
        return true;
    }
}