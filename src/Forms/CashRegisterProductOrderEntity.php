<?php 

	namespace App\Forms;

	use Doctrine\ORM\EntityManagerInterface;
	use App\Helpers\Traits\EntityFieldMapperTrait;
	use App\Helpers\Traits\FormObjectLexer;

	/**
	 * CashRegisterProductOrderEntity
	 **/
	class CashRegisterProductOrderEntity {
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
		 * ##FormLabel Produktkategorie
		 * ##FormFieldHint <span class='pz-hint'>Produktkategorie auswählen</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * --FormInputKey form1
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormPlaceholder Produktkategorie
		 * ##FormInputOptions App\Forms\TicketArchiveEntity::fetchProductCategoriesAsOptions
		 * ##FormValidationStrategy NUM
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $productCategory;
		
		
		/**
		 * @var int
		 *
		 * ##FormLabel Betrag
		 * ##FormFieldHint <span class='pz-hint'>Betrag</span>
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
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\TextArea
		 */
		protected $message;
		
		/**
		 * @var \App\Forms\CashRegisterProductOrderEntity
		 */
		protected static $instance;
		
		public function __construct(){
			$this->initializeEntityBank();
			static::$instance = $this;
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
		public function getProductCategory() {
			return $this->productCategory;
		}
		
		/**
		 * @return string
		 */
		public function getMessage() {
			return $this->message;
		}
		
		
		/**
		 * @param int $amount
		 *
		 * @return CashRegisterProductOrderEntity
		 */
		public function setAmount( $amount ): CashRegisterProductOrderEntity {
			$this->amount = $amount;
			
			return $this;
		}
		
		/**
		 * @param int $productCategory
		 *
		 * @return CashRegisterProductOrderEntity
		 */
		public function setProductCategory( $productCategory ): CashRegisterProductOrderEntity {
			$this->productCategory = $productCategory;
			
			return $this;
		}
		
		/**
		 * @param string $message
		 *
		 * @return CashRegisterProductOrderEntity
		 */
		public function setMessage( $message ): CashRegisterProductOrderEntity {
			$this->message = $message;
			
			return $this;
		}
		
	}
	