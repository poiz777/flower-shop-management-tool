<?php 

	namespace App\Forms;

	use Doctrine\ORM\EntityManagerInterface;
	use App\Helpers\Traits\EntityFieldMapperTrait;
	use App\Helpers\Traits\FormObjectLexer;

	/**
	 * BKClientEntity
	 **/
	class BKClientEntity {
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
		 * ##FormLabel Privat / Geschäftskunde
		 * ##FormFieldHint <span class='pz-hint'>Privat / Geschäftskunde</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormPlaceholder Privat / Geschäftskunde
		 * ##FormInputOptions App\Forms\TicketArchiveEntity::fetchCompanyAndPrivateClientsAsOptions
		 * ##FormValidationStrategy NUM
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $client;
		
		
		/**
		 * @var \App\Forms\BKClientEntity
		 */
		protected static $instance;
		
		public function __construct(){
			$this->initializeEntityBank();
			static::$instance = $this;
		}
		
		/**
		 * @return int
		 */
		public function getClient() {
			return $this->client;
		}
		
		/**
		 * @param int $client
		 *
		 * @return BKClientEntity
		 */
		public function setClient( $client ): BKClientEntity {
			$this->client = $client;
			
			return $this;
		}
		
		
	}
	