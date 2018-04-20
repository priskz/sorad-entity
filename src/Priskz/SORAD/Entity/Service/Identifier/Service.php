<?php namespace Priskz\SORAD\Entity\Service\Identifier;

use Log;
use Illuminate\Database\QueryException;
use Priskz\SORAD\Entity\Domain\Identifier\Laravel\CrudRepository as DataSource;
use Priskz\SORAD\Service\Laravel\GenericCrudService;
use Priskz\Payload\Payload;

class Service extends GenericCrudService
{
    /**
     * @property array $configuration
     */
	protected $configuration = [
		'CREATE' => [
			'keys'     => [
				'entity_type', 'entity_id', 'uuid',
			],
			'rules'    => [
				'entity_type'  =>  '',
				'entity_id'    =>  '',
				'uuid'         =>  '',
			],
			'defaults' => [],
		],
		'UPDATE' => [
			'keys'     => [
				'entity_type', 'entity_id', 'uuid',
			],
			'rules'    => [
				'entity_type'  =>  '',
				'entity_id'    =>  '',
				'uuid'         =>  '',
			],
			'defaults' => [],
		],
		'DELETE' => [
			'keys'     => [],
			'rules'    => [],
			'defaults' => [],
		],
	];

	/**
	 *	Constructor
	 */
	public function __construct($alias, $dataSource)
	{
		parent::__construct($alias);
		$this->dataSource = $dataSource;
	}

	/**
	 * Create a new Model with the given data.
	 *
	 * @param  array $data
	 * @return Payload
	 */
	public function create($data)
	{
		// Generate a UUID.
		$data['uuid'] = $this->generateIdentifier();

		// Initialize the payload variable.
		$payload = null;

		while(empty($payload))
		{
			try
			{
				// Attempt to create the model.
				$payload = $this->dataSource->create($data);
			}
			// Catch a nonunique UUID exception.
			catch(QueryException $e)
			{
				// Grab the exception's information.
				$errorInfo = $e->errorInfo;

				// If the error violates MySql's duplicate entry that means
				// the unique uuid constraint already existed.
				// Note: $errorInfo[1] == 1062 is MySql specific.
				if($errorInfo[1] == 1062)
				{
					Log::error('You won the lottery and a duplicate UUID was generated!');

					// Try a new UUID.
					$data['uuid'] = $this->generateIdentifier();

					// Reinitialize the return payload.
					$payload = null;
				}
				// If a query exception was thrown and caught it wasn't a duplicate entry,
				// it was something else, so we will procede by breaking out of the
				// creation and return a not_created payload.
				else
				{
					return new Payload(null, 'not_created');
				}
			}
		}

		return $payload;
	}

	/**
	 * Generate a UUID.
	 *
	 * @return string
	 */
	protected function generateIdentifier()
	{
		// If the mongo extension is loaded, utilize it to generate a UUID.
		if(extension_loaded('mongodb'))
		{
			$newObjectId = new \MongoDB\BSON\ObjectID();

			$uuid = $newObjectId->__toString();
		}
		else
		{
			$uuid = bin2hex(openssl_random_pseudo_bytes(12));
		}

		return $uuid;
	}
}