<?php
namespace HwAttributeExample\Entity\Attribute\Value;

use Concrete\Core\Entity\Attribute\Value\AbstractValue;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="HWAttributeExampleEventAttributeValues"
 * )
 */
class EventsValue extends AbstractValue
{

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="\HwAttributeExample\Entity\Events")
     * @ORM\JoinColumn(name="eventID", referencedColumnName="eventID")
     */
    protected $event;

    /**
     * @return mixed
     */
    public function getEvents()
    {
        return $this->event;
    }

    /**
     * @param mixed $event
     */
    public function setEvents($event)
    {
        $this->event = $event;
    }
}