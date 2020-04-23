<?php 

	namespace App\Forms;

	use Doctrine\ORM\EntityManagerInterface;
	use App\Helpers\Traits\EntityFieldMapperTrait;
	use App\Helpers\Traits\FormObjectLexer;

	/**
	 * OptionalSalesSearchEntity
	 **/
	class OptionalSalesSearchEntity {
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
		 * ##FormInputKey optional_sales_search
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormPlaceholder Produktkategorie
		 * ##FormInputOptions App\Forms\TicketArchiveEntity::fetchProductCategoriesAsOptions
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $productCategory;
		
		/**
		 * @var string
		 *
		 * ##FormLabel Betrag CHF min
		 * ##FormFieldHint <span class='pz-hint'>Betrag CHF min</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormInputKey optional_sales_search
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormInputMin 0
		 * ##FormInputMax 200000
		 * ##FormInputIsNullable 1
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
		 * ##FormInputKey optional_sales_search
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormInputMin 1
		 * ##FormInputMax 200000
		 * ##FormInputIsNullable 1
		 * ##FormInputStep 1
		 * ##FormPlaceholder 555.00
		 * ##FormValidationStrategy NUM
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $maxAmount;
		
		/**
		 * @var string
		 *
		 * ##FormLabel Enthaltener Text
		 * ##FormFieldHint <span class='pz-hint'>Enthaltener Text</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormInputIsNullable 1
		 * ##FormInputKey optional_sales_search
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormPlaceholder Enthaltener Text
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $information;
		
		/**
		 * @var \App\Forms\OptionalSalesSearchEntity
		 */
		protected static $instance;
		
		public function __construct(){
			static::$instance = $this;
			$this->initializeEntityBank();
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
		public function getProductCategory() {
			return $this->productCategory;
		}
		
		/**
		 * @return string
		 */
		public function getInformation() {
			return $this->information;
		}
		
		
		
		/**
		 * @param string $minAmount
		 *
		 * @return OptionalSalesSearchEntity
		 */
		public function setMinAmount( $minAmount ): OptionalSalesSearchEntity {
			$this->minAmount = $minAmount;
			
			return $this;
		}
		
		/**
		 * @param string $maxAmount
		 *
		 * @return OptionalSalesSearchEntity
		 */
		public function setMaxAmount( $maxAmount ): OptionalSalesSearchEntity {
			$this->maxAmount = $maxAmount;
			
			return $this;
		}
		
		/**
		 * @param int $productCategory
		 *
		 * @return OptionalSalesSearchEntity
		 */
		public function setProductCategory( $productCategory ): OptionalSalesSearchEntity {
			$this->productCategory = $productCategory;
			
			return $this;
		}
		
		/**
		 * @param string $information
		 *
		 * @return OptionalSalesSearchEntity
		 */
		public function setInformation( $information ): OptionalSalesSearchEntity {
			$this->information = $information;
			
			return $this;
		}
		
		
		
		
		
		
	}
	