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
	 * Geschlecht
	 * @Table(name="Geschlecht")
	 * @Entity(repositoryClass="App\Entity\Repo\GeschlechtRepo")
	 **/
	class Geschlecht {
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
		 * @Id Geschlecht
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Geschlecht Id 
		 * ##FormFieldHint <span class='pz-hint'>Geschlecht_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Geschlecht_id; 

		/**
		 * @var string
		 * @Column(name="Geschlecht_name", type="string", length=20, nullable=false) 
		 * 
		 * ##FormLabel  Geschlecht Name 
		 * ##FormFieldHint <span class='pz-hint'>Geschlecht_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Geschlecht_name; 

		/**
		 * @var string
		 * @Column(name="Geschlecht_praefix", type="string", length=20, nullable=false) 
		 * 
		 * ##FormLabel  Geschlecht Praefix 
		 * ##FormFieldHint <span class='pz-hint'>Geschlecht_praefix</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Geschlecht_praefix;
		
		
		/**
		 * @var \App\Entity\Geschlecht
		 */
		protected static $instance;

		public function __construct(){
			static::$instance = $this;
			$this->initializeEntityBank(); 
		}


		public function getGeschlechtId() {
			return $this->Geschlecht_id;
		}

		public function getGeschlechtName() {
			return $this->Geschlecht_name;
		}

		public function getGeschlechtPraefix() {
			return $this->Geschlecht_praefix;
		}


		public function setGeschlechtId($Geschlecht_id) {
			$this->Geschlecht_id = $Geschlecht_id;
			return $this;
		}

		public function setGeschlechtName($Geschlecht_name) {
			$this->Geschlecht_name = $Geschlecht_name;
			return $this;
		}

		public function setGeschlechtPraefix($Geschlecht_praefix) {
			$this->Geschlecht_praefix = $Geschlecht_praefix;
			return $this;
		}




	} 
