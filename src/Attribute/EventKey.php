<?php
namespace HwAttributeExample\Attribute;

use Concrete\Core\Support\Facade\Facade;

class EventKey extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'HwAttributeExample\Entity\Attribute\Category\EventsCategory';
    }

    public static function getByHandle($handle)
    {
        return static::getFacadeRoot()->getAttributeKeyByHandle($handle);
    }

    public static function getByID($akID)
    {
        return static::getFacadeRoot()->getAttributeKeyByID($akID);
    }




}