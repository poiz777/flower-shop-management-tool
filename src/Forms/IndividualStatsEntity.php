<?php
	
	
	namespace App\Forms;
	
	use Carbon\Carbon;
	use Doctrine\ORM\EntityManagerInterface;
	use App\Helpers\Traits\EntityFieldMapperTrait;
	use App\Helpers\Traits\FormObjectLexer;
	
	/**
	 * IndividualStatsEntity
	 **/
	class IndividualStatsEntity {
		
		use EntityFieldMapperTrait;
		use FormObjectLexer;
		
		/**
		 * @var array
		 */
		protected $entityBank = [];
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
		 * @var \DateTime
		 *
		 * ##FormLabel Startdatum
		 * ##FormFieldHint <span class='pz-hint'>Startdatum</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0
		 * ##FormPlaceholder 0
		 * ##FormInputReadOnly 0
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy DATE
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $start_date;
		
		/**
		 * @var \DateTime
		 *
		 * ##FormLabel Enddatum
		 * ##FormFieldHint <span class='pz-hint'>Enddatum</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0
		 * ##FormPlaceholder 0
		 * ##FormInputReadOnly 0
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy DATE
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $end_date;
		
		
		protected static $instance;
		
		public function __construct() {
			$cDate            = Carbon::today( 'Europe/Zurich' );
			$start_date       = clone $cDate;
			$end_date         = clone $cDate;
			$this->start_date = $start_date->addDays(-1)->toDate();
			$this->end_date   = $end_date->toDate();
			$this->client     = 43;
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
		 * @return \DateTime
		 */
		public function getStartDate() {
			return $this->start_date;
		}
		
		/**
		 * @return \DateTime
		 */
		public function getEndDate() {
			return $this->end_date;
		}
		
		
		/**
		 * @param int $client
		 *
		 * @return IndividualStatsEntity
		 */
		public function setClient( $client ): IndividualStatsEntity {
			$this->client = $client;
			
			return $this;
		}
		
		/**
		 * @param \DateTime $start_date
		 *
		 * @return IndividualStatsEntity
		 */
		public function setStartDate( $start_date ): IndividualStatsEntity {
			$this->start_date = $start_date;
			
			return $this;
		}
		
		/**
		 * @param \DateTime $end_date
		 *
		 * @return IndividualStatsEntity
		 */
		public function setEndDate( $end_date ): IndividualStatsEntity {
			$this->end_date = $end_date;
			
			return $this;
		}
		
		
		
		
	}
	