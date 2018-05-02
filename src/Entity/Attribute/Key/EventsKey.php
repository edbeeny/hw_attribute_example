<?php

namespace HwAttributeExample\Entity\Attribute\Key;

use Concrete\Core\Entity\Attribute\Key\Key as Key;
use HwAttributeExample\Attribute\EventKey;
use Doctrine\ORM\Mapping as ORM;
use HwAttributeExample\Entity\Events;

/**
 * @ORM\Entity
 * @ORM\Table(name="HWAttributeExampleEventAttributeKeys")
 */
class EventsKey extends Key
{

    public function getAttributeKeyCategoryHandle()
    {
        return 'events';
    }

    public function getList()
    {
        return EventKey::getList();
    }


}




