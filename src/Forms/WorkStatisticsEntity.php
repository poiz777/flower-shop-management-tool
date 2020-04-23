<?php 

	namespace App\Forms;

	use App\Entity\Personen;
	use Carbon\Carbon;
	use Doctrine\ORM\EntityManagerInterface;
	use App\Helpers\Traits\EntityFieldMapperTrait;
	use App\Helpers\Traits\FormObjectLexer;

	/**
	 * ClientSearchEntity
	 **/
	class WorkStatisticsEntity {
		
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
		 * ##FormLabel Mitarbeiter
		 * ##FormFieldHint <span class='pz-hint'>Der aktuelle Mitarbeiter...</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormPlaceholder Mitarbeiter wählen
		 * ##FormInputOptions App\Entity\Arbeitszeit::fetchCoWorkers
		 * ##FormValidationStrategy NUM
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $coWorker;
		
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
		
		public function __construct(){
			$this->initializeEntityBank();
			$today              = date("d");
			if((int)$today <= 14){
				$dateString       = ($mn = (int)date("m")) == 1 ? ((int)date('Y')-1) . "-" : date("Y-");
				$dateString      .= ($dt = (int)date("m")) == 1 ? '12' : $dt;
				$dateString      .= "-01";
				$cDate            = Carbon::parse($dateString);
				$this->start_date   = $cDate->startOfMonth()->toDate();
				$this->end_date     = $cDate->endOfMonth()->toDate();
			}else{
				$this->start_date =  Carbon::today()->startOfMonth()->toDate();
				$this->end_date     = Carbon::today()->endOfMonth()->toDate();
			}
		}
		
		/**
		 * @return int
		 */
		public function getCoWorker(){
			return $this->coWorker;
		}
		
		/**
		 * @return \DateTime
		 */
		public function getStartDate(){
			return $this->start_date;
		}
		
		/**
		 * @return \DateTime
		 */
		public function getEndDate() {
			return $this->end_date;
		}
		
		/**
		 * @param int $coWorker
		 *
		 * @return WorkStatisticsEntity
		 */
		public function setCoWorker($coWorker ): WorkStatisticsEntity {
			$this->coWorker = $coWorker;
			
			return $this;
		}
		
		/**
		 * @param \DateTime $start_date
		 *
		 * @return WorkStatisticsEntity
		 */
		public function setStartDate($start_date ): WorkStatisticsEntity {
			$this->start_date = $start_date;
			
			return $this;
		}
		
		/**
		 * @param \DateTime $end_date
		 *
		 * @return WorkStatisticsEntity
		 */
		public function setEndDate($end_date ): WorkStatisticsEntity {
			$this->end_date = $end_date;
			
			return $this;
		}
		
		public function getCoWorkerByID($id) {
			/** @var \Doctrine\ORM\EntityManager $entityManager */
			/** @var \App\Entity\Personen $coWorker */
			global $kernel;
			$entityManager  = $kernel->getContainer()->get('doctrine.orm.entity_manager');
			$strCoWorker    = [];
			$coWorker       = $entityManager->getRepository(Personen::class)-> find($id);
			if($coWorker){
				$strCoWorker = $coWorker->getVorname() . " " . $coWorker->getName();
			}
			return $strCoWorker;
		}


	}
	
	
