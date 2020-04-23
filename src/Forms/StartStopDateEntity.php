<?php
	
	
	namespace App\Forms;
	
	use App\Entity\Personen;
	use Carbon\Carbon;
	use Doctrine\ORM\EntityManagerInterface;
	use App\Helpers\Traits\EntityFieldMapperTrait;
	use App\Helpers\Traits\FormObjectLexer;
	
	/**
	 * StartStopDateEntity
	 **/
	class StartStopDateEntity {
		
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
			$this->initializeEntityBank();
			$cDate            = Carbon::today( 'Europe/Zurich' );
			$start_date       = clone $cDate;
			$end_date         = clone $cDate;
			$this->start_date = $start_date->addDays(-1)->toDate();
			$this->end_date   = $end_date->toDate();
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
		 * @param \DateTime $start_date
		 *
		 * @return StartStopDateEntity
		 */
		public function setStartDate( $start_date ): StartStopDateEntity {
			$this->start_date = $start_date;
			
			return $this;
		}
		
		/**
		 * @param \DateTime $end_date
		 *
		 * @return StartStopDateEntity
		 */
		public function setEndDate( $end_date ): StartStopDateEntity {
			$this->end_date = $end_date;
			
			return $this;
		}
		
		
	}
	