<?php 

	namespace App\Forms;

	use Doctrine\ORM\EntityManagerInterface;
	use App\Helpers\Traits\EntityFieldMapperTrait;
	use App\Helpers\Traits\FormObjectLexer;

	/**
	 * BillFinalizerEntity1
	 **/
	class BillFinalizerEntity1 {
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
		 * ##FormLabel Rechnungsnummer eingeben
		 * ##FormFieldHint <span class='pz-hint'>Rechnungsnummer eingeben</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * --FormInputKey form1
		 * --FormInputReadOnly 0
		 * ##FormPlaceholder 6702
		 * ##FormValidationStrategy NUM
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $billNumber;
		
		
		/**
		 * @var string
		 *
		 * ##FormLabel Rechnung ID
		 * ##FormFieldHint <span class='pz-hint'>Rechnung ID</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormAddLabel 0
		 * ##FormUseLabel 0
		 * --FormInputKey form1
		 * --FormInputReadOnly 1
		 * ##FormPlaceholder 6702
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Hidden
		 */
		protected $billID;
		
		/**
		 * @var string
		 *
		 * --FormLabel BankReferenzennummeer eingeben
		 * --FormFieldHint <span class='pz-hint'>BankReferenzennummeer eingeben</span>
		 * --FormInputType number
		 * --FormInputRequired 0
		 * --FormAddLabel 1
		 * --FormUseLabel 1
		 * --FormInputKey form1
		 * --FormInputReadOnly o
		 * --FormPlaceholder 0000 9908 777 0002 12300 7
		 * --FormValidationStrategy MISC
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $bankReferenceNumber;
		
		/**
		 * @var int
		 *
		 * --FormLabel Rechnungstatus
		 * --FormFieldHint <span class='pz-hint'>Rechnungstatus auswählen</span>
		 * --FormInputType number
		 * --FormInputRequired 0
		 * --FormAddLabel 1
		 * --FormUseLabel 1
		 * --FormPlaceholder Rechnungstatus
		 * --FormInputOptions App\Forms\BillStatusEntity::fetchBillStatusesAsOptions
		 * --FormValidationStrategy NUM
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $billStatus = 2;
		
		/**
		 * @var string
		 *
		 * ##FormLabel Konditionen
		 * ##FormFieldHint <span class='pz-hint'>Konditionen</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * --FormInputKey form1
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormPlaceholder Please, pay within 14 Days
		 * ##FormValidationStrategy HTML
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\EditorEnhanced
		 */
		protected $paymentConditons = "Bitte vermerken Sie bei der online Zahlung die Rechnungsnummer, welche auf der Rechnung bzw. im Feld Zahlungszweck des Einzahlungsscheins steht<br><br>Betrag inkl. 2.5% Mehrwertsteuer. Zahlbar rein netto innert 14 Tagen";
		
		/**
		 * @var string
		 *
		 * ##FormLabel Danke
		 * ##FormFieldHint <span class='pz-hint'>Danke</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * --FormInputKey form1
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormPlaceholder Please, pay within 14 Days
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\EditorEnhanced
		 */
		protected $thankYou = "Mit bestem Dank für den Auftrag!";
		
		/**
		 * @var int
		 *
		 * --FormLabel PS:
		 * --FormFieldHint <span class='pz-hint'>PS wählen</span>
		 * --FormInputType number
		 * --FormInputRequired 0
		 * --FormInputKey form1
		 * --FormAddLabel 1
		 * --FormUseLabel 1
		 * --FormInputStep 0.05
		 * --FormPlaceholder Bitte PS wählen
		 * --FormValidationStrategy NUM
		 * --FormInputOptions App\Forms\BillFinalizerEntity1::fetchBillPSAsOptions
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $ps = 65;
		
		/**
		 * @var string
		 *
		 * ##FormLabel Bemerkungen
		 * ##FormFieldHint <span class='pz-hint'>Bemerkungen</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0
		 * --FormInputKey form1
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormPlaceholder Bemerkungen...
		 * ##FormValidationStrategy HTML
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\EditorEnhanced
		 */
		protected $message;
		
		/**
		 * @var \App\Forms\BillFinalizerEntity1
		 */
		protected static $instance;
		
		public function __construct(){
			$this->initializeEntityBank();
			static::$instance = $this;
		}
		
		/**
		 * @return string
		 */
		public function getBillNumber() {
			return $this->billNumber;
		}
		
		/**
		 * @return string
		 */
		public function getBankReferenceNumber() {
			return $this->bankReferenceNumber;
		}
		
		/**
		 * @return string
		 */
		public function getPaymentConditons() {
			return $this->paymentConditons;
		}
		
		/**
		 * @return string
		 */
		public function getThankYou() {
			return $this->thankYou;
		}
		
		/**
		 * @return int
		 */
		public function getPs() {
			return $this->ps;
		}
		
		/**
		 * @return string
		 */
		public function getMessage() {
			return $this->message;
		}
		
		/**
		 * @return int
		 */
		public function getBillStatus() {
			return $this->billStatus;
		}
		
		
		
		/**
		 * @param string $billNumber
		 *
		 * @return BillFinalizerEntity1
		 */
		public function setBillNumber( $billNumber ): BillFinalizerEntity1 {
			$this->billNumber = $billNumber;
			
			return $this;
		}
		
		/**
		 * @param string $bankReferenceNumber
		 *
		 * @return BillFinalizerEntity1
		 */
		public function setBankReferenceNumber( $bankReferenceNumber ): BillFinalizerEntity1 {
			$this->bankReferenceNumber = $bankReferenceNumber;
			
			return $this;
		}
		
		/**
		 * @param string $paymentConditons
		 *
		 * @return BillFinalizerEntity1
		 */
		public function setPaymentConditons( $paymentConditons ): BillFinalizerEntity1 {
			$this->paymentConditons = $paymentConditons;
			
			return $this;
		}
		
		/**
		 * @param string $thankYou
		 *
		 * @return BillFinalizerEntity1
		 */
		public function setThankYou( $thankYou ): BillFinalizerEntity1 {
			$this->thankYou = $thankYou;
			
			return $this;
		}
		
		/**
		 * @param int $ps
		 *
		 * @return BillFinalizerEntity1
		 */
		public function setPs( $ps ): BillFinalizerEntity1 {
			$this->ps = $ps;
			
			return $this;
		}
		
		/**
		 * @param string $message
		 *
		 * @return BillFinalizerEntity1
		 */
		public function setMessage( $message ): BillFinalizerEntity1 {
			$this->message = $message;
			
			return $this;
		}
		
		/**
		 * @return string
		 */
		public function getBillID() {
			return $this->billID;
		}
		
		/**
		 * @param string $billID
		 *
		 * @return BillFinalizerEntity1
		 */
		public function setBillID( $billID ): BillFinalizerEntity1 {
			$this->billID = $billID;
			
			return $this;
		}
		
		/**
		 * @param int $billStatus
		 *
		 * @return BillFinalizerEntity1
		 */
		public function setBillStatus( $billStatus ): BillFinalizerEntity1 {
			$this->billStatus = $billStatus;
			
			return $this;
		}
		
		
		
		
	}
	