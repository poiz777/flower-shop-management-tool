<?php 

	namespace App\Entity;

	use Doctrine\ORM\Mapping as ORM;
	use Doctrine\ORM\Mapping\Id;
	use Doctrine\ORM\Mapping\Table;
	use Doctrine\ORM\Mapping\Column;
	use Doctrine\ORM\Mapping\Entity;
	use Doctrine\ORM\Mapping\OneToOne;
	use Doctrine\ORM\Mapping\JoinColumn;
	use Doctrine\ORM\Mapping\GeneratedValue;
	use Doctrine\ORM\Mapping\JoinColumns;
	use Doctrine\ORM\Mapping\OneToMany;
	use Doctrine\ORM\Mapping\ManyToOne;
	use Doctrine\Common\Collections\ArrayCollection;
	use Doctrine\ORM\EntityManagerInterface;
	use Doctrine\ORM\Mapping\ManyToMany;
	use App\Helpers\Traits\EntityFieldMapperTrait;
	use App\Helpers\Traits\FormObjectLexer;

	/**
	 * Layout
	 * @Table(name="Layout")
	 * @Entity(repositoryClass="App\Entity\Repo\LayoutRepo")
	 **/
	class Layout { 

		use EntityFieldMapperTrait; 

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
		 * @Id Layout
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Layout Id 
		 * ##FormFieldHint <span class='pz-hint'>Layout_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Layout_id; 

		/**
		 * @var int
		 * @Column(name="Layout_Navigationen_id", type="smallint", length=2, nullable=false) 
		 * 
		 * ##FormLabel  Layout Navigationen Id 
		 * ##FormFieldHint <span class='pz-hint'>Layout_Navigationen_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Layout_Navigationen_id; 

		/**
		 * @var int
		 * @Column(name="Layout_nav_nummer", type="smallint", length=5, nullable=false) 
		 * 
		 * ##FormLabel  Layout Nav Nummer 
		 * ##FormFieldHint <span class='pz-hint'>Layout_nav_nummer</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Layout_nav_nummer; 

		/**
		 * @var int
		 * @Column(name="Layout_Frames_id", type="smallint", length=2, nullable=false) 
		 * 
		 * ##FormLabel  Layout Frames Id 
		 * ##FormFieldHint <span class='pz-hint'>Layout_Frames_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Layout_Frames_id; 

		/**
		 * @var int
		 * @Column(name="Layout_Inhalt_container_id", type="smallint", length=6, nullable=false) 
		 * 
		 * ##FormLabel  Layout Inhalt Container Id 
		 * ##FormFieldHint <span class='pz-hint'>Layout_Inhalt_container_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Layout_Inhalt_container_id; 

		/**
		 * @var int
		 * @Column(name="Layout_order", type="smallint", length=3, nullable=false) 
		 * 
		 * ##FormLabel  Layout Order 
		 * ##FormFieldHint <span class='pz-hint'>Layout_order</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Layout_order; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getLayoutId() {
			return $this->Layout_id;
		}

		public function getLayoutNavigationenId() {
			return $this->Layout_Navigationen_id;
		}

		public function getLayoutNavNummer() {
			return $this->Layout_nav_nummer;
		}

		public function getLayoutFramesId() {
			return $this->Layout_Frames_id;
		}

		public function getLayoutInhaltContainerId() {
			return $this->Layout_Inhalt_container_id;
		}

		public function getLayoutOrder() {
			return $this->Layout_order;
		}


		public function setLayoutId($Layout_id) {
			$this->Layout_id = $Layout_id;
			return $this;
		}

		public function setLayoutNavigationenId($Layout_Navigationen_id) {
			$this->Layout_Navigationen_id = $Layout_Navigationen_id;
			return $this;
		}

		public function setLayoutNavNummer($Layout_nav_nummer) {
			$this->Layout_nav_nummer = $Layout_nav_nummer;
			return $this;
		}

		public function setLayoutFramesId($Layout_Frames_id) {
			$this->Layout_Frames_id = $Layout_Frames_id;
			return $this;
		}

		public function setLayoutInhaltContainerId($Layout_Inhalt_container_id) {
			$this->Layout_Inhalt_container_id = $Layout_Inhalt_container_id;
			return $this;
		}

		public function setLayoutOrder($Layout_order) {
			$this->Layout_order = $Layout_order;
			return $this;
		}




	} 
