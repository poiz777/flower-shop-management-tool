<?php 

	namespace App\Forms;

	use Doctrine\ORM\EntityManagerInterface;
	use App\Helpers\Traits\EntityFieldMapperTrait;
	use App\Helpers\Traits\FormObjectLexer;

	/**
	 * BillRecapEntity
	 **/
	class BillRecapEntity {
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
		 * @var string
		 *
		 * ##FormLabel Datum
		 * ##FormFieldHint <span class='pz-hint'>Datum</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0
		 * --FormInputKey form1
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormPlaceholder 01.01.2099
		 * ##FormInputOptions App\Forms\TicketArchiveEntity::fetchProductCategoriesAsOptions
		 * ##FormValidationStrategy SWISS_DATE
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $billDate;
		
		
		/**
		 * @var int
		 *
		 * ##FormLabel Betrag CHF
		 * ##FormFieldHint <span class='pz-hint'>Betrag CHF</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * --FormInputKey form1
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormInputMin 0
		 * ##FormInputMax 200000
		 * ##FormInputStep 1
		 * ##FormPlaceholder 99.50
		 * ##FormValidationStrategy NUM
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $amount;
		
		
		/**
		 * @var int
		 *
		 * ##FormLabel Zahlungsart
		 * ##FormFieldHint <span class='pz-hint'>Zahlungsart auswählen</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * --FormInputKey form1
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormPlaceholder Zahlungsart
		 * ##FormInputOptions App\Forms\TicketArchiveEntity::fetchBillRecapPaymentMethodsAsOptions
		 * ##FormValidationStrategy NUM
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $paymentMethod;
		
		
		/**
		 * @var \App\Forms\BillRecapEntity
		 */
		protected static $instance;
		
		public function __construct(){
			$this->billDate   = (new \DateTime())->format('d.m.Y');
			static::$instance = $this;
			$this->initializeEntityBank();
		}
		
		/**
		 * @return string
		 */
		public function getBillDate() {
			return $this->billDate;
		}
		
		/**
		 * @return int
		 */
		public function getAmount() {
			return $this->amount;
		}
		
		/**
		 * @return int
		 */
		public function getPaymentMethod() {
			return $this->paymentMethod;
		}
		
		
		
		/**
		 * @param string $billDate
		 *
		 * @return BillRecapEntity
		 */
		public function setBillDate( $billDate ): BillRecapEntity {
			$this->billDate = $billDate;
			
			return $this;
		}
		
		/**
		 * @param int $amount
		 *
		 * @return BillRecapEntity
		 */
		public function setAmount( $amount ): BillRecapEntity {
			$this->amount = $amount;
			
			return $this;
		}
		
		/**
		 * @param int $paymentMethod
		 *
		 * @return BillRecapEntity
		 */
		public function setPaymentMethod( $paymentMethod ): BillRecapEntity {
			$this->paymentMethod = $paymentMethod;
			
			return $this;
		}
		
		
		
	}
	