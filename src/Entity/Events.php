<?php

namespace HwAttributeExample\Entity;

use Doctrine\ORM\Mapping as ORM;
use Database;
use Core;
use HwAttributeExample\Entity\Attribute\Key\EventsKey;
use HwAttributeExample\Entity\Attribute\Value\EventsValue;
use \Concrete\Core\Attribute\ObjectTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="HWAttributeExampleEvent")
 */
class Events
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $eventID;

    /**
     * @ORM\Column(type="string")
     */
    protected $eventName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $eventDesc;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $eventdatefrom;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $eventdateto;


    /**
     * @return mixed
     */
    public function getEventID()
    {
        return $this->eventID;
    }

    /**
     * @param mixed $eventID
     */
    public function setEventID($eventID)
    {
        $this->eventID = $eventID;
    }

    /**
     * @return mixed
     */
    public function getEventName()
    {
        return $this->eventName;
    }

    /**
     * @param mixed $eventName
     */
    public function setEventName($eventName)
    {
        $this->eventName = $eventName;
    }

    /**
     * @return mixed
     */
    public function getEventDesc()
    {
        return $this->eventDesc;
    }

    /**
     * @param mixed $eventDesc
     */
    public function setEventDesc($eventDesc)
    {
        $this->eventDesc = $eventDesc;
    }

    /**
     * @return mixed
     */
    public function getEventdatefrom()
    {
        return $this->eventdatefrom;
    }

    /**
     * @param mixed $eventdatefrom
     */
    public function setEventdatefrom($eventdatefrom)
    {
        $this->eventdatefrom = $eventdatefrom;
    }

    /**
     * @return mixed
     */
    public function getEventdateto()
    {
        return $this->eventdateto;
    }

    /**
     * @param mixed $eventdateto
     */
    public function setEventdateto($eventdateto)
    {
        $this->eventdateto = $eventdateto;
    }
    public static function getByID($eventID)
    {
        $em = \ORM::entityManager();
        return $em->getRepository('\HwAttributeExample\Entity\Events')
            ->find($eventID);
    }

    public function save()
    {
        $em = \ORM::entityManager();
        $em->persist($this);
        $em->flush();
    }

    public function delete()
    {
        $em = \ORM::entityManager();
        $em->remove($this);
        $em->flush();
    }

    public function getAtttribute($ak) {
        return ObjectTrait::getAttribute($ak);
    }

    public function setAttribute($ak, $data) {
        return ObjectTrait::setAttribute($ak, $data);
    }
    public function clearAttribute($ak){
        return ObjectTrait::clearAttribute($ak);
    }
    public function getObjectAttributeCategory()
    {
        return \Core::make('\HwAttributeExample\Entity\Attribute\Category\EventsCategory');
    }

    public function getAttributeValueObject($ak, $createIfNotExists = false)
    {
        $category = $this->getObjectAttributeCategory();

        if (!is_object($ak)) {
            $ak = $category->getByHandle($ak);
        }

        $value = false;
        if (is_object($ak)) {
            $value = $category->getAttributeValue($ak, $this);
        }

        if ($value) {
            return $value;
        } elseif ($createIfNotExists) {
            $attributeValue = new EventsValue();
            $attributeValue->setEvents($this);
            $attributeValue->setAttributeKey($ak);
            return $attributeValue;
        }
    }


}
