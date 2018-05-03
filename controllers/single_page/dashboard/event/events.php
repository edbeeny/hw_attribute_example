<?php

namespace Concrete\Package\HwAttributeExample\Controller\SinglePage\Dashboard\Event;

use HwAttributeExample\Entity\Attribute\Key\EventsKey;
use HwAttributeExample\Entity\Events as HWEvents;
use HwAttributeExample\Entity\EventList;
use HwAttributeExample\Attribute\EventKey;
use Request;
use Core;
use URL;


class Events extends \Concrete\Core\Page\Controller\DashboardPageController
{


    public function view()
    {
        $list = new EventList();

        $pagination = $list->getPagination();
        $entries = $pagination->getCurrentPageResults();

        $this->set('list', $list);
        $this->set('pagination', $pagination);
        $this->set('entries', $entries);
    }

    public function add()
    {

        $this->eventAttributes = EventKey::getList();


        $this->set('pageTitle', t('Add Event'));
        $events = new HWEvents();

        $this->set('events', $events);
        
        $attrList = EventKey::getList();
        $this->set('attribs',$attrList);


    }

    public function edit($id = 0)
    {
        $this->set('pageTitle', t('Edit Event'));

        $attrList = EventKey::getList();
        $this->set('attribs',$attrList);


        $event = HWEvents::getByID($id);

        $this->set('event', $event);
        $this->set('eID', $event->getEventID());
        $this->set('eName', $event->getEventName());
        $this->set('eDesc', $event->getEventDesc());
        $this->set('eDateFrom', $event->getEventdatefrom());
        $this->set('eDateTo', $event->getEventdateto());
    }

    public function submit()
    {
        $data = $this->post();
        if (!$this->token->validate('submit')) {
            $this->error->add($this->token->getErrorMessage());
        }

        if (!$this->error->has() && $this->isPost()) {
            if ($this->post('eID')) {
                $events = HWEvents::getByID($this->post('eID'));
            } else {
                $events = new HWEvents();
            }

            $events->setEventname($this->post('eName'));
            $events->setEventDesc($this->post('eDesc'));
            $events->setEventdatefrom(new \DateTime($this->post('eDateFrom')));
            $events->setEventdateto(new \DateTime($this->post('eDateTo')));

            $events->save();

            $attributes = EventsKey::getList();
            foreach ($attributes as $ak) {
                $controller = $ak->getController();
                $value = $controller->createAttributeValueFromRequest();
                $events->setAttribute($ak, $value);
            }


            $this->redirect('/dashboard/event/events', 'saved');

        }
    }
    public function saved()
    {
        $this->set('message', t('Event saved successfully.'));
        $this->view();
    }

    public function deleted()
    {
        $this->set('message', t('Event deleted successfully.'));
        $this->view();
    }

    public function delete()
    {
        if (!$this->token->validate('delete')) {
            $this->error->add($this->token->getErrorMessage());
        }

        if (!$this->error->has() && $this->isPost()) {
            $e = Events::getByID($this->post('eID'));
            if (is_object($e)) {
                $e->delete();
            }


            $this->redirect('/dashboard/event/events', 'deleted');
        }
        $this->view();
    }


}
