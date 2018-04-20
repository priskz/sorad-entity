<?php namespace Priskz\SORAD\Entity\Domain\Identifier\Data\MySQL\Eloquent;

use Priskz\Paylorm\Data\MySQL\Eloquent\SoftDeleteableModel as DataModel;

class Model extends DataModel
{
	/**
	 * @var Laravel Model Variables
	 */
	protected $table      = 'entity_identifier';
	protected $guarded    = [];

	// ----------------------------------------------------------------

	/**
	 * Get the Identifier's entity type.
	 *
	 * @return string
	 */
	public function getEntityType()
	{
		return $this->entity_type;
	}

	/**
	 * Get the Identifier's entity key.
	 *
	 * @return int
	 */
	public function getEntityKey()
	{
		return $this->entity_id;
	}

	/**
	 * Get the Identifier's UUID.
	 *
	 * @return int
	 */
	public function getUuid()
	{
		return $this->uuid;
	}

	/**
	 * Get the Identifier's Entity.
	 *
	 * @return Domain\{Entity}
	 */
	public function getEntity()
	{
		return $this->entity;
	}

	/**
	 * Get the Identifier's Entity's class.
	 *
	 * @return string
	 */
	public function getEntityClass()
	{
		return str_replace(' ', '', ucwords( strtolower( str_replace( '_', ' ', $this->getEntityType() ) ) ));
	}

	/* =====================================================
	 * Eloquent relationships.
	 * ================================================== */

	/**
	 * An Identifier can has one Domain\{Entity}.
	 *
	 * @return Illuminate\Database\Eloquent\Relations\belongsTo
	 */
    public function entity()
    {
    	// Get this content's type and format it to our needs.
    	$formattedName =  str_replace(' ', '', ucwords( strtolower( str_replace( '_', ' ', $this->getEntityType() ) ) ));

    	// Create the related entity class dynamically.
		$entityClass = 'Domain\\' . $formattedName . '\Laravel\Model';

		return $this->hasOne($entityClass, 'id', 'entity_id');
    }
}