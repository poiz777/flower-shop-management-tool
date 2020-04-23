<?php 

	namespace App\Forms;

	use Doctrine\ORM\EntityManagerInterface;
	use App\Helpers\Traits\EntityFieldMapperTrait;
	use App\Helpers\Traits\FormObjectLexer;

	/**
	 * BookKeepingEntity
	 **/
	class BookKeepingEntity {
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
		 * @var \App\Forms\BookKeepingEntity
		 */
		protected static $instance;
		
		public function __construct(){
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
		 * @param int $client
		 *
		 * @return BookKeepingEntity
		 */
		public function setClient( $client ): BookKeepingEntity {
			$this->client = $client;
			
			return $this;
		}
		
		/**
		 * @param int $productCategory
		 *
		 * @return BookKeepingEntity
		 */
		public function setProductCategory( $productCategory ): BookKeepingEntity {
			$this->productCategory = $productCategory;
			
			return $this;
		}
		
		/**
		 * @param int $amount
		 *
		 * @return BookKeepingEntity
		 */
		public function setAmount( $amount ): BookKeepingEntity {
			$this->amount = $amount;
			
			return $this;
		}
		
		/**
		 * @param string $message
		 *
		 * @return BookKeepingEntity
		 */
		public function setMessage( $message ): BookKeepingEntity {
			$this->message = $message;
			
			return $this;
		}
		
	}
	