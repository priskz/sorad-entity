<?php namespace Priskz\SORAD\Entity\Service\Root\Laravel;

use Config;
use Priskz\SORAD\ServiceProvider\Laravel\AbstractRootServiceProvider as RootServiceProvider;
use Priskz\SORAD\Entity\Service\Root\Service;
use Priskz\SORAD\Entity\Domain\Identifier\Repository\CRUD as IdentifierDataSource;
use Priskz\SORAD\Entity\Domain\Identifier\Data\MySQL\Eloquent\Model as IdentifierModel;
use Priskz\SORAD\Entity\Service\Identifier\Laravel\ServiceProvider as IdentifierServiceProvider;
use Priskz\SORAD\Entity\Service\Identifier\Service as IdentifierService;
use Priskz\SORAD\Entity\Domain\Reference\Repository\CRUD as ReferenceDataSource;
use Priskz\SORAD\Entity\Domain\Reference\Data\MySQL\Eloquent\Model as ReferenceModel;
use Priskz\SORAD\Entity\Service\Reference\Laravel\ServiceProvider as ReferenceServiceProvider;
use Priskz\SORAD\Entity\Service\Reference\Service as ReferenceService;

class ServiceProvider extends RootServiceProvider
{
    /**
     * @property string $providerKey
     */
	protected static $providerKey = 'entity-root';

    /**
     * @property string $connection
     */
	protected $connection = null;

    /**
     * @property array $core
     */
	protected $core = [
		'provides' => [
			'entity-identifier',
			'entity-reference',
		],
		'aggregates' => [
			'entity-identifier',
			'entity-reference',
		]
	];

	/**
	 * @OVERRIDE
	 * 
	 * Get the services provided by this provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [$this->getProviderKey()] + $this->core['provides'];
	}

	/**
	 *	Boot
	 */
	public function boot()
	{
		// Publish Config File
	    $this->publishes([
	    	realpath(__DIR__ . '/../../..') . '/config/Laravel/entity.php' => config_path('sorad/entity.php')
	    ]);

		$this->loadMigrationsFrom(realpath(__DIR__ . '/../../..') . '/migrations/Laravel');
	}

	/**
	 * @OVERRIDE
	 * 
	 * Register.
	 *
	 * @return void
	 */
	public function register()
	{
		// Register this service's core.
		$this->registerCore();

		// Link this service's aggregate(s).
		$this->linkAggregates();

		// Register this service service.
		$this->registerService();
	}

	/**
	 * Register Service.
	 *
	 * @return void
	 */
	protected function registerService()
	{
	    $this->app->singleton($this->getProviderKey(), function($app)
	    {
	    	return new Service($this->getProviderKey(), null, $this->getAggregateService());
	    });
	}

	/**
	 * Register Core Services used by this Service.
	 *
	 * @return void
	 */
	protected function registerCore()
	{
		// Bind the Entity Identifier aggregate.
	    $this->app->singleton(IdentifierServiceProvider::getProviderKey(), function($app)
	    {
	    	return new IdentifierService(IdentifierServiceProvider::getProviderKey(), new IdentifierDataSource(new IdentifierModel([], $this->getConnection())));
	    });

		// Bind the Entity Reference aggregate.
	    $this->app->singleton(ReferenceServiceProvider::getProviderKey(), function($app)
	    {
	    	return new ReferenceService(ReferenceServiceProvider::getProviderKey(), new ReferenceDataSource(new ReferenceModel([], $this->getConnection())));
	    });
	}

	/**
	 * @OVERRIDE
	 * 
	 * Link Aggreagte Service(s) to be resolved when this service is resolved.
	 *
	 * @return void
	 */
	protected function linkAggregates()
	{
		// Init
		$configuredAggregates = [];

		// Look for configured entity services to tag.
		if(Config::get('sorad.entity.aggregates'))
		{
			$configuredAggregates = array_keys(Config::get('sorad.entity.aggregates'));
		}

		// Combine all of our configured aggregates.
		$aggregates = array_merge($this->aggregates, $configuredAggregates, $this->core['aggregates']);

		// Iterate configured aggregates and tag.
		foreach($aggregates as $aggregate)
		{
			$this->app->tag([$aggregate], $this->getProviderKey());
		}
	}

	/**
	 * Get aggregate(s).
	 *
	 * @return array
	 */
	protected function getAggregateService()
	{
		// Init
		$aggregate = [];

		foreach($this->app->tagged($this->getProviderKey()) as $service)
		{
			$aggregate[$service->getAlias()] = $service;
		}

		return $aggregate;
	}
}