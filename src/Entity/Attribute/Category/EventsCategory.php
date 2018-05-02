<?php
namespace HwAttributeExample\Entity\Attribute\Category;

use Concrete\Core\Entity\Attribute\Key\Key;
use HwAttributeExample\Entity\Attribute\Key\EventsKey;
use HwAttributeExample\Entity\Attribute\Value\EventsValue;
use Concrete\Core\Attribute\Category\AbstractStandardCategory as AbstractStandardCategory;
use Concrete\Core\Attribute\Category\CategoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Concrete\Core\Entity\Attribute\Type;

class EventsCategory extends AbstractStandardCategory
{

    public function createAttributeKey()
    {
        return new EventsKey();
    }

    public function getIndexedSearchTable()
    {
        return 'HWAttributeExampleEventSearchIndexAttributes';
    }

    public function getIndexedSearchPrimaryKeyValue($events)
    {
        return $events->getEventID();
    }

    public function getSearchIndexFieldDefinition()
    {
        return array(
            'columns' => array(
                array(
                    'name' => 'eID',
                    'type' => 'integer',
                    'options' => array('unsigned' => true, 'default' => 0, 'notnull' => true),
                ),
            ),
            'primary' => array('eID'),
        );
    }

    public function getAttributeKeyRepository()
    {
        return $this->entityManager->getRepository(EventsKey::class);
    }

    public function getAttributeValueRepository()
    {
        return $this->entityManager->getRepository(EventsValue::class);
    }

    public function getAttributeValues($events)
    {
        $values = $this->getAttributeValueRepository()->findBy(array(
            'event' => $events,
        ));
        return $values;
    }

    public function getAttributeValue(Key $key, $events)
    {
        $r = $this->entityManager->getRepository(EventsValue::class);
        $value = $r->findOneBy(array(
            'event' => $events,
            'attribute_key' => $key,
        ));

        return $value;
    }

}