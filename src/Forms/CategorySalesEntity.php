<?php 

	namespace App\Forms;

	use App\Helpers\Date\RequestBridge;
	use Doctrine\ORM\EntityManagerInterface;
	use App\Helpers\Traits\EntityFieldMapperTrait;
	use App\Helpers\Traits\FormObjectLexer;

	/**
	 * CategorySalesEntity
	 **/
	class CategorySalesEntity {
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
		 * ##FormLabel Zuständig
		 * ##FormFieldHint <span class='pz-hint'>Zuständige Filiale fürs Ticket.</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormPlaceholder Zuständig Filiale auswählen
		 * ##FormInputOptions App\Forms\TicketArchiveEntity::fetchDepartmentsAsOptions
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $department;
		
		/**
		 * @var int
		 *
		 * ##FormLabel Produktekategorie
		 * ##FormFieldHint <span class='pz-hint'>Produktekategorie</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormPlaceholder Produktekategorie auswählen
		 * ##FormInputOptions App\Forms\TicketArchiveEntity::fetchProductCategoriesForEssenzaAsOptions
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $productCategory = 3270;
		
		/**
		 * @var \DateTime
		 * ##FormLabel Anfangstermin
		 * ##FormFieldHint <span class='pz-hint'>Anfangstermin</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0
		 * ##FormPlaceholder 01.01.1970
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy DATE
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $startDate;
		
		/**
		 * @var \DateTime
		 * ##FormLabel Endtermin
		 * ##FormFieldHint <span class='pz-hint'>Endtermin</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0
		 * ##FormPlaceholder 01.01.1970
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy DATE
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $endDate;
		
		
		/**
		 * @var \App\Forms\CategorySalesEntity
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
		public function getDepartment() {
			return $this->department;
		}
		
		/**
		 * @return int
		 */
		public function getProductCategory() {
			return $this->productCategory;
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
		 * @param int $department
		 *
		 * @return CategorySalesEntity
		 */
		public function setDepartment( $department ): CategorySalesEntity {
			$this->department = $department;
			
			return $this;
		}
		
		/**
		 * @param int $productCategory
		 *
		 * @return CategorySalesEntity
		 */
		public function setProductCategory( $productCategory ): CategorySalesEntity {
			$this->productCategory = $productCategory;
			
			return $this;
		}
		
		/**
		 * @param \DateTime $startDate
		 *
		 * @return CategorySalesEntity
		 */
		public function setStartDate( $startDate ): CategorySalesEntity {
			$this->startDate = $startDate;
			
			return $this;
		}
		
		/**
		 * @param \DateTime $endDate
		 *
		 * @return CategorySalesEntity
		 */
		public function setEndDate( $endDate ): CategorySalesEntity {
			$this->endDate = $endDate;
			
			return $this;
		}
		
		
	}
	