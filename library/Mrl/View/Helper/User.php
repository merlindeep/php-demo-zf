<?php

class Mrl_View_Helper_User
{
    public static function get()
    {
        return Mrl_User::getCurrent();
    }

    public static function getId()
    {
        return Mrl_User::getId();
    }

    public static function isGuest()
    {
        return Mrl_User::isGuest();
    }
}