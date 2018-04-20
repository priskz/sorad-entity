<?php namespace Priskz\SORAD\Entity\Domain\Reference\Data\MySQL\Eloquent;

use Priskz\Paylorm\Data\MySQL\Eloquent\SoftDeleteableModel as DataModel;

class Model extends DataModel
{
	/**
	 * @var Laravel Model Variables
	 */
	protected $table      = 'entity_reference';
	protected $guarded    = [];

	// ----------------------------------------------------------------

	/**
	 * Get this EntityReference's entity uuid.
	 *
	 * @return string
	 */
	public function getEntityUuid()
	{
		return $this->entity_uuid;
	}

	/**
	 * Get this EntityReference's entity type.
	 *
	 * @return string
	 */
	public function getEntityType()
	{
		return $this->entity_type;
	}

	/**
	 * Get this EntityReference's entity type.
	 *
	 * @return int
	 */
	public function getEntityKey()
	{
		return $this->entity_id;
	}

	/**
	 * Get this EntityReference's reference uuid.
	 *
	 * @return string
	 */
	public function getReferenceUuid()
	{
		return $this->reference_uuid;
	}

	/**
	 * Get this EntityReference's reference type.
	 *
	 * @return string
	 */
	public function getReferenceType()
	{
		return $this->reference_type;
	}

	/**
	 * Get this EntityReference's reference type.
	 *
	 * @return int
	 */
	public function getReferenceKey()
	{
		return $this->reference_id;
	}

	/**
	 * Get this EntityReference's sort order.
	 *
	 * @return integer
	 */
	public function getOrder()
	{
		return $this->order;
	}

	/**
	 * Get this EntityReference's Reference.
	 *
	 * @return Domain\{Entity}
	 */
	public function getEntity()
	{
		return $this->entity;
	}

	/**
	 * Get this EntityReference's Reference.
	 *
	 * @return Domain\{Reference}
	 */
	public function getReference()
	{
		return $this->reference;
	}

	/* =====================================================
	 * Eloquent relationships.
	 * ================================================== */

	/**
	 * This EntityReference can has one Domain\{Reference}.
	 *
	 * @return Illuminate\Database\Eloquent\Relations\hasOne
	 */
    public function reference()
    {
    	// Get this content's type and format it to our needs.
    	$formattedName =  str_replace(' ', '', ucwords( strtolower( str_replace( '_', ' ', $this->getReferenceType() ) ) ));

    	// Create the related entity class dynamically.
		$referenceClass = 'Domain\\' . $formattedName . '\Data\MySQL\Eloquent\Model';

		return $this->hasOne($referenceClass, 'id', 'reference_id');
    }

	/**
	 * This EntityReference can has one Domain\{Entity}.
	 *
	 * @return Illuminate\Database\Eloquent\Relations\hasOne
	 */
    public function entity()
    {
    	// Get this content's type and format it to our needs.
    	$formattedName =  str_replace(' ', '', ucwords( strtolower( str_replace( '_', ' ', $this->getEntityType() ) ) ));

    	// Create the related entity class dynamically.
		$entityClass = 'Domain\\' . $formattedName . '\Data\MySQL\Eloquent\Model';

		return $this->hasOne($entityClass, 'id', 'entity_id');
    }
}