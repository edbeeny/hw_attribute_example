<?php

namespace Concrete\Package\HwAttributeExample;

use \Concrete\Core\Backup\ContentImporter;
use Concrete\Core\Database\EntityManager\Provider\ProviderAggregateInterface;
use Concrete\Core\Database\EntityManager\Provider\StandardPackageProvider;
use Concrete\Core\Attribute\Key\Category;
use Package;
use Asset;
use AssetList;

class Controller extends Package implements ProviderAggregateInterface
{
    protected $pkgHandle = 'hw_attribute_example';
    protected $appVersionRequired = '8.0';
    protected $pkgVersion = '0.0.1';

    public function getPackageDescription()
    {
        return t('Attribute example');
    }

    public function getPackageName()
    {
        return t('Attribute example');
    }



    public function getEntityManagerProvider()
    {
        $provider = new StandardPackageProvider($this->app, $this, [
            'src/Entity/' => '\HwAttributeExample\Entity',
            'src/Attribute/' => '\HwAttributeExample\Attribute'
        ]);
        return $provider;
    }

    public function install()
    {
        $this->app['manager/attribute/category']->extend('events',
            function($app) {
                return $app->make('HwAttributeExample\Entity\Attribute\Category\EventsCategory');
            });

        $pkg = parent::install();

        $ci = new ContentImporter();
        $ci->importContentFile($pkg->getPackagePath() . '/config/install.xml');
    }

    public function on_start() {
            $this->app['manager/attribute/category']->extend('events',
                function($app) {
                    return $app->make('HwAttributeExample\Entity\Attribute\Category\EventsCategory');
                });



    }
}
