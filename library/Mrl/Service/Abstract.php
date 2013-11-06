<?php

abstract class Mrl_Service_Abstract
{
    protected static function session($name = null, $value = null)
    {
        return Mrl_Instance::session($name, $value);
    }
}