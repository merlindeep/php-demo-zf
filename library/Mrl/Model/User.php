<?php
/**
 * Class Mrl_Model_User
 * @property int    id
 * @property string email
 * @property string password
 * @property string name
 * @property int status
 * @property int dateReg
 * @property int dateLastLogin
 */
class Mrl_Model_User extends Mrl_Model_Abstract
{
    protected static $_mapperClass = 'Mrl_Model_Mapper_User';

    /**
     * @param $email
     * @return null|Mrl_Model_User
     */
    public static function getByEmail($email)
    {
        return self::getMapper()->fetchRow(array('email = ?' => $email));
    }

}