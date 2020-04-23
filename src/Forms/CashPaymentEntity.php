<?php 

	namespace App\Forms;

	use Doctrine\ORM\EntityManagerInterface;
	use App\Helpers\Traits\EntityFieldMapperTrait;
	use App\Helpers\Traits\FormObjectLexer;

	/**
	 * CashPaymentEntity
	 **/
	class CashPaymentEntity {
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
		 * ##FormLabel Heute einbezahlter Betrag CHF
		 * ##FormFieldHint <span class='pz-hint'>Heute einbezahlter Betrag CHF</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormInputMin 0
		 * ##FormInputMax 200000
		 * ##FormInputStep 1
		 * ##FormPlaceholder 950.00
		 * ##FormValidationStrategy NUM
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $amount;
		
		
		/**
		 * @var \App\Forms\CashPaymentEntity
		 */
		protected static $instance;
		
		public function __construct(){
			$this->initializeEntityBank();
			static::$instance = $this;
		}
		
		/**
		 * @return string
		 */
		public function getAmount() {
			return $this->amount;
		}
		/**
		 * @param string $amount
		 *
		 * @return CashPaymentEntity
		 */
		public function setAmount( $amount ): CashPaymentEntity {
			$this->amount = $amount;
			
			return $this;
		}
		
		
		
	}
	