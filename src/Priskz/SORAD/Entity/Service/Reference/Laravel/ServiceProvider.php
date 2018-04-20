<?php namespace Priskz\SORAD\Entity\Service\Reference\Laravel;

use Priskz\SORAD\ServiceProvider\Laravel\AbstractServiceProvider as SORADServiceProvider;
use Priskz\SORAD\Entity\Domain\Reference\Repository\CRUD as DataSource;
use Priskz\SORAD\Entity\Domain\Reference\Data\MySQL\Eloquent\Model;
use Priskz\SORAD\Entity\Service\Reference\Service;

class ServiceProvider extends SORADServiceProvider
{
    /**
     * @property string $providerKey
     */
	protected static $providerKey = 'entity-reference';

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