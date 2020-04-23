<?php 

	namespace App\Forms;

	use App\Helpers\Date\RequestBridge;
	use Doctrine\ORM\EntityManagerInterface;
	use App\Helpers\Traits\EntityFieldMapperTrait;
	use App\Helpers\Traits\FormObjectLexer;

	/**
	 * SalesSearchEntity
	 **/
	class SalesSearchEntity {
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
		 * ##FormLabel Geschäftskunde
		 * ##FormFieldHint <span class='pz-hint'>Geschäftskunde</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormInputKey sales_search
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormPlaceholder Geschäftskunde
		 * ##FormInputOptions App\Forms\TicketArchiveEntity::fetchCompanyClientsAsOptions
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $businessClient;
		
		/**
		 * @var int
		 *
		 * ##FormLabel Privatkundin
		 * ##FormFieldHint <span class='pz-hint'>Privatkundin</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormInputKey sales_search
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormPlaceholder Privatkundin
		 * ##FormInputOptions App\Forms\TicketArchiveEntity::fetchPrivateClientsAsOptions
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $privateClient;
		
		/**
		 * @var \DateTime
		 * ##FormLabel Datum Start
		 * ##FormFieldHint <span class='pz-hint'>Datum Start</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0
		 * ##FormInputKey sales_search
		 * ##FormPlaceholder 01.01.1970
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy DATE
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $startDate;
		
		/**
		 * @var \DateTime
		 * ##FormLabel Datum Ende
		 * ##FormFieldHint <span class='pz-hint'>Datum Ende</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0
		 * ##FormInputKey sales_search
		 * ##FormPlaceholder 01.01.1970
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy DATE
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $endDate;
		
		/**
		 * @var string
		 *
		 * ##FormLabel Betrag CHF min
		 * ##FormFieldHint <span class='pz-hint'>Betrag CHF min</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormInputKey sales_search
		 * ##FormInputIsNullable 1
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormInputMin 0
		 * ##FormInputMax 200000
		 * ##FormInputStep 1
		 * ##FormPlaceholder 222.00
		 * ##FormValidationStrategy NUM
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $minAmount;
		
		/**
		 * @var string
		 *
		 * ##FormLabel Betrag CHF max
		 * ##FormFieldHint <span class='pz-hint'>Betrag CHF max</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormInputKey sales_search
		 * ##FormInputIsNullable 1
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormInputMin 0
		 * ##FormInputMax 200000
		 * ##FormInputStep 1
		 * ##FormPlaceholder 555.00
		 * ##FormValidationStrategy NUM
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $maxAmount;
		
		/**
		 * @var int
		 *
		 * ##FormLabel Zahlungsmittel
		 * ##FormFieldHint <span class='pz-hint'>Zahlungsmittel</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormInputKey sales_search
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormPlaceholder Zahlungsmittel
		 * ##FormInputOptions App\Forms\TicketArchiveEntity::fetchPaymentMethodsAsOptionsWithoutCash
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $paymentMethod;
		
		/**
		 * @var int
		 *
		 * ##FormLabel Filiale
		 * ##FormFieldHint <span class='pz-hint'>Filiale</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormInputKey sales_search
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormPlaceholder Filiale auswählen
		 * ##FormInputOptions App\Forms\TicketArchiveEntity::fetchDepartmentsAsOptions
		 * ##FormValidationStrategy NUM
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $department;
		
		/**
		 * @var \App\Forms\SalesSearchEntity
		 */
		protected static $instance;
		
		public function __construct(){
			global $kernel;
			# $entityManager      = $kernel->getContainer()->get('doctrine.orm.entity_manager');
			$firstDayOfDisMonth = date('Y-m') . "-01";
			$this->startDate    = new \DateTime($firstDayOfDisMonth);
			$this->endDate      = new \DateTime();
			$melSession         = $kernel->getContainer()->get('session')->get(RequestBridge::SessionNameSpace);
			
			if(isset($melSession['department'])){
				$this->department = $melSession['department'];
			}
			static::$instance = $this;
			$this->initializeEntityBank();
		}
		
		/**
		 * @return int
		 */
		public function getBusinessClient() {
			return $this->businessClient;
		}
		
		/**
		 * @return int
		 */
		public function getPrivateClient() {
			return $this->privateClient;
		}
		
		/**
		 * @return int
		 */
		public function getPaymentMethod() {
			return $this->paymentMethod;
		}
		
		/**
		 * @return \DateTime
		 */
		public function getStartDate() {
			return $this->startDate;
		}
		
		/**
		 * @return \DateTime
		 */
		public function getEndDate() {
			return $this->endDate;
		}
		
		/**
		 * @return string
		 */
		public function getMinAmount() {
			return $this->minAmount;
		}
		
		/**
		 * @return string
		 */
		public function getMaxAmount() {
			return $this->maxAmount;
		}
		
		/**
		 * @return int
		 */
		public function getDepartment() {
			return $this->department;
		}
		
		
		
		/**
		 * @param int $businessClient
		 *
		 * @return SalesSearchEntity
		 */
		public function setBusinessClient( $businessClient ): SalesSearchEntity {
			$this->businessClient = $businessClient;
			
			return $this;
		}
		
		/**
		 * @param int $privateClient
		 *
		 * @return SalesSearchEntity
		 */
		public function setPrivateClient( $privateClient ): SalesSearchEntity {
			$this->privateClient = $privateClient;
			
			return $this;
		}
		
		/**
		 * @param int $paymentMethod
		 *
		 * @return SalesSearchEntity
		 */
		public function setPaymentMethod( $paymentMethod ): SalesSearchEntity {
			$this->paymentMethod = $paymentMethod;
			
			return $this;
		}
		
		/**
		 * @param \DateTime $startDate
		 *
		 * @return SalesSearchEntity
		 */
		public function setStartDate( $startDate ): SalesSearchEntity {
			$this->startDate = $startDate;
			
			return $this;
		}
		
		/**
		 * @param \DateTime $endDate
		 *
		 * @return SalesSearchEntity
		 */
		public function setEndDate( $endDate ): SalesSearchEntity {
			$this->endDate = $endDate;
			
			return $this;
		}
		
		/**
		 * @param string $minAmount
		 *
		 * @return SalesSearchEntity
		 */
		public function setMinAmount( $minAmount ): SalesSearchEntity {
			$this->minAmount = $minAmount;
			
			return $this;
		}
		
		/**
		 * @param string $maxAmount
		 *
		 * @return SalesSearchEntity
		 */
		public function setMaxAmount( $maxAmount ): SalesSearchEntity {
			$this->maxAmount = $maxAmount;
			
			return $this;
		}
		
		/**
		 * @param int $department
		 *
		 * @return SalesSearchEntity
		 */
		public function setDepartment($department ): SalesSearchEntity {
			$this->department = $department;
			
			return $this;
		}
		
		
		
		
	}
	