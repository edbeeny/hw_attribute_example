<?php
namespace HwAttributeExample\Entity;

use Concrete\Core\Search\ItemList\Database\ItemList;
use Concrete\Core\Search\Pagination\Pagination;
use Pagerfanta\Adapter\DoctrineDbalAdapter;

class EventList extends ItemList
{

    /**
     * Create base query
     */
    public function createQuery()
    {
        $this->query->select('e.eventID')
            ->from('HWAttributeExampleEvent', 'e');
    }

    /**
     * Returns the total results in this list.
     * @return int
     */
    public function getTotalResults()
    {
        $query = $this->deliverQueryObject();
        return $query->select('count(e.eventID)')
            ->setMaxResults(1)
            ->execute()
            ->fetchColumn();
    }

    /**
     * Gets the pagination object for the query.
     * @return Pagination
     */
    protected function createPaginationObject()
    {
        $adapter = new DoctrineDbalAdapter($this->deliverQueryObject(), function ($query) {
            $query->select('count(e.eventID)')->setMaxResults(1);
        });
        $pagination = new Pagination($this, $adapter);
        return $pagination;
    }

    /**
     * Object mapping
     *
     * @param $queryRow
     * @return \HWAttributeExampleEvent\Entity\Events
     */
    public function getResult($queryRow)
    {
        $ai = Events::getByID($queryRow['eventID']);
        return $ai;
    }

}