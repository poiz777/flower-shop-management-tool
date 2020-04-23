<?php 

	namespace App\Forms;

	use Doctrine\ORM\EntityManagerInterface;
	use App\Helpers\Traits\EntityFieldMapperTrait;
	use App\Helpers\Traits\FormObjectLexer;

	/**
	 * CashExpenditureEntity
	 **/
	class CashExpenditureEntity {
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
		 * ##FormLabel Konto
		 * ##FormFieldHint <span class='pz-hint'>Konto</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormPlaceholder Konto auswählen
		 * ##FormInputOptions App\Forms\TicketArchiveEntity::fetchAccountsAsOptions
		 * ##FormValidationStrategy NUM
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $account;
		
		/**
		 * @var string
		 *
		 * ##FormLabel Betrag CHF
		 * ##FormFieldHint <span class='pz-hint'>Betrag CHF</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormInputMin 0
		 * ##FormInputMax 200000
		 * ##FormInputStep 1
		 * ##FormPlaceholder 122.00
		 * ##FormValidationStrategy NUM
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $amount;
		
		/**
		 * @var string
		 *
		 * ##FormLabel Bemerkungen
		 * ##FormFieldHint <span class='pz-hint'>Bemerkungen</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormPlaceholder Bemerkungen
		 * ##FormValidationStrategy HTML
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\TextArea
		 */
		protected $message;
		
		/**
		 * @var \App\Forms\CashExpenditureEntity
		 */
		protected static $instance;
		
		public function __construct(){
			$this->initializeEntityBank();
			static::$instance = $this;
		}
		
		/**
		 * @return int
		 */
		public function getAccount() {
			return $this->account;
		}
		
		/**
		 * @return string
		 */
		public function getAmount() {
			return $this->amount;
		}
		
		/**
		 * @return int
		 */
		public function getMessage() {
			return $this->message;
		}
		
		/**
		 * @param int $account
		 *
		 * @return CashExpenditureEntity
		 */
		public function setAccount( $account ): CashExpenditureEntity {
			$this->account = $account;
			
			return $this;
		}
		
		/**
		 * @param string $amount
		 *
		 * @return CashExpenditureEntity
		 */
		public function setAmount( $amount ): CashExpenditureEntity {
			$this->amount = $amount;
			
			return $this;
		}
		
		/**
		 * @param int $message
		 *
		 * @return CashExpenditureEntity
		 */
		public function setMessage( $message ): CashExpenditureEntity {
			$this->message = $message;
			
			return $this;
		}
		
		
		
	}
	