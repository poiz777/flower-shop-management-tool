<?php 

	namespace App\Forms;

	use Doctrine\ORM\EntityManagerInterface;
	use App\Helpers\Traits\EntityFieldMapperTrait;
	use App\Helpers\Traits\FormObjectLexer;

	/**
	 * BillStatusEntity
	 **/
	class BillStatusEntity {
		use EntityFieldMapperTrait;
		use FormObjectLexer;

		/**
		 * @var array
		 */
		protected $entityBank	= [];
		/**
		 * @var EntityManagerInterface
		 */
		protected $eMan;
		
		/**
		 * @var int
		 *
		 * ##FormLabel Rechnungstatus
		 * ##FormFieldHint <span class='pz-hint'>Rechnungstatus auswählen</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormPlaceholder Rechnungstatus
		 * ##FormInputOptions App\Forms\BillStatusEntity::fetchBillStatusesAsOptions
		 * ##FormValidationStrategy NUM
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $status;
		
		
		/**
		 * @var \App\Forms\BillStatusEntity
		 */
		protected static $instance;
		
		public function __construct(){
			$this->initializeEntityBank();
			static::$instance = $this;
		}
		
		/**
		 * @return int
		 */
		public function getStatus() {
			return $this->status;
		}
		
		/**
		 * @param int $status
		 *
		 * @return BillStatusEntity
		 */
		public function setStatus( $status ): BillStatusEntity {
			$this->status = $status;
			
			return $this;
		}
		
		
		
		
	}
	