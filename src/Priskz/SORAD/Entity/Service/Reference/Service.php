<?php namespace Priskz\SORAD\Entity\Service\Reference;

use Priskz\SORAD\Entity\Domain\Reference\Laravel\CrudRepository as DataSource;
use Priskz\SORAD\Service\Laravel\GenericCrudService;

class Service extends GenericCrudService
{
    /**
     * @property array $configuration
     */
	protected $configuration = [
		'CREATE' => [
			'keys'     => [
				'entity_uuid', 'entity_type', 'entity_id', 'reference_uuid', 'reference_type', 'reference_id',
			],
			'rules'    => [
				'entity_uuid'     =>  '',
				'entity_type'     =>  '',
				'entity_id'       =>  '',
				'reference_uuid'  =>  '',
				'reference_type'  =>  '',
				'reference_id'    =>  '',
				'order'           =>  '',
			],
			'defaults' => [],
		],
		'UPDATE' => [
			'keys'     => [
				'entity_uuid', 'entity_type', 'entity_id', 'reference_uuid', 'reference_type', 'reference_id',
			],
			'rules'    => [
				'entity_uuid'     =>  '',
				'entity_type'     =>  '',
				'entity_id'       =>  '',
				'reference_uuid'  =>  '',
				'reference_type'  =>  '',
				'reference_id'    =>  '',
				'order'           =>  '',
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
	 * Update many given Models with the given data.
	 *
	 * @param  array $data An array containing arrays that look like ['model' => $data, 'data' => $input]
	 * @return Payload
	 */
	public function updateMany($data)
	{
		return $this->dataSource->updateMany($data);
	}

	/**
	 * Get multiple models by a given compound key.
	 *
	 * @param  string  $entityType An Entity's Type
	 * @param  integer $entityKey  An Entity's Key
	 * @return payload
	 */
	public function getManyByCompoundKey($entityType, $entityKey)
	{
		return $this->dataSource->getManyByCompoundKey($entityType, $entityKey);
	}
}