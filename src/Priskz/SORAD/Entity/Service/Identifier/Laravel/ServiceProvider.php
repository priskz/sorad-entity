<?php

namespace Priskz\SORAD\Entity\Service\Identifier\Laravel;

use Priskz\SORAD\ServiceProvider\Laravel\AbstractServiceProvider as SORADServiceProvider;
use Priskz\SORAD\Entity\Domain\Identifier\Repository\CRUD as DataSource;
use Priskz\SORAD\Entity\Domain\Identifier\Data\MySQL\Eloquent\Model;
use Priskz\SORAD\Entity\Service\Identifier\Service;

class ServiceProvider extends SORADServiceProvider
{
    /**
     * @property string $providerKey
     */
	protected static $providerKey = 'entity-identifier';

	/**
	 * Register Services.
	 *
	 * @return void
	 */  
	protected function registerService()
	{
	    $this->app->singleton($this->getProviderKey(), function($app)
	    {
	    	return new Service($this->getProviderKey(), new DataSource(new Model()));
	    });
	}
}