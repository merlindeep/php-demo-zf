<?php

abstract class Mrl_Model_Abstract extends Zend_Db_Table_Row
{
    protected static $_mapperClass = 'Zend_Db_Table';
    protected static $_mapper = null;

    private static $_mappers = array();

    /**
     * Name of the class of the Zend_Db_Table_Abstract object.
     * @var string
     */
    protected $_tableClass = 'Mrl_Model_Mapper_Abstract';

    public function __construct(array $config = array())
    {
        $this->_tableClass = static::$_mapperClass;
        parent::__construct($config);
        static::setMapper($this->_table);
    }

    /**
     * Get mapper object
     * @return Zend_Db_Table
     */
    public static function getMapper()
    {
        $className = self::_getClassName();
        if (!array_key_exists($className, self::$_mappers)) {
            self::$_mappers[$className] = new static::$_mapperClass;
        }

        return self::$_mappers[$className];
    }

    protected static function _getClassName()
    {
        return get_called_class();
    }

    public static function setMapper($mapper)
    {
        self::$_mappers[self::_getClassName()] = $mapper;
    }

    public function populate(array $data)
    {
        if ($this->_data) {
            $data = array_intersect_key($data, $this->_data);
        } else {
            $this->_data = $data;
        }

        foreach ($data as $columnName => $value) {
            $this->__set($columnName, $value);
        }

        return $this;
    }

    protected function _prepareData(&$data)
    {
        foreach ($data as $key => &$value) {
            if (!($value instanceof Zend_Db_Expr) && is_object($value)) {
                unset($data[$key]);
            }
        }
    }

    public function save()
    {
        $this->_prepareData($this->_data);
        return parent::save();
    }

    public static function fetch($id)
    {
        return self::getMapper()->fetch($id);
    }

    protected function session($name = null, $value = null)
    {
        return Mrl_Instance::session($name, $value);
    }

}