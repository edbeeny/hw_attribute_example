<?php
namespace Concrete\Package\HwAttributeExample\Controller\SinglePage\Dashboard;

class event extends \Concrete\Core\Page\Controller\DashboardPageController
{
    public function view()
    {
        $this->redirect('/dashboard/event/events');
    }
}