<?php 

	namespace App\Forms;

	use Doctrine\ORM\EntityManagerInterface;
	use App\Helpers\Traits\EntityFieldMapperTrait;
	use App\Helpers\Traits\FormObjectLexer;

	/**
	 * BillPostEntity
	 **/
	class BillPostEntity {
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
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\EditorEnhanced
		 */
		protected $message;
		
		/**
		 * @var \App\Forms\BillPostEntity
		 */
		protected static $instance;
		
		public function __construct(){
			$this->initializeEntityBank();
			static::$instance = $this;
		}
		
		/**
		 * @return int
		 */
		public function getProductCategory() {
			return $this->productCategory;
		}
		
		/**
		 * @return int
		 */
		public function getAmount() {
			return $this->amount;
		}
		
		/**
		 * @return string
		 */
		public function getMessage() {
			return $this->message;
		}
		
		
		
		
		/**
		 * @param int $productCategory
		 *
		 * @return BillPostEntity
		 */
		public function setProductCategory( $productCategory ): BillPostEntity {
			$this->productCategory = $productCategory;
			
			return $this;
		}
		
		/**
		 * @param int $amount
		 *
		 * @return BillPostEntity
		 */
		public function setAmount( $amount ): BillPostEntity {
			$this->amount = $amount;
			
			return $this;
		}
		
		/**
		 * @param string $message
		 *
		 * @return BillPostEntity
		 */
		public function setMessage( $message ): BillPostEntity {
			$this->message = $message;
			
			return $this;
		}
		
	}
	