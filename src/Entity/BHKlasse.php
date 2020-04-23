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
	 * BHKlasse
	 * @Table(name="BH_Klasse")
	 * @Entity(repositoryClass="App\Entity\Repo\BHKlasseRepo")
	 **/
	class BHKlasse { 

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
		 * @Id BHKlasse
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  B H Klasse I D 
		 * ##FormFieldHint <span class='pz-hint'>BH_Klasse_ID</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Klasse_ID; 

		/**
		 * @var string
		 * @Column(name="BH_Klasse_name", type="string", length=60, nullable=false) 
		 * 
		 * ##FormLabel  B H Klasse Name 
		 * ##FormFieldHint <span class='pz-hint'>BH_Klasse_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $BH_Klasse_name; 

		/**
		 * @var double
		 * @Column(name="BH_Klasse_saldo", type="text", length=10, nullable=false) 
		 * 
		 * ##FormLabel  B H Klasse Saldo 
		 * ##FormFieldHint <span class='pz-hint'>BH_Klasse_saldo</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Klasse_saldo; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getBHKlasseID() {
			return $this->BH_Klasse_ID;
		}

		public function getBHKlasseName() {
			return $this->BH_Klasse_name;
		}

		public function getBHKlasseSaldo() {
			return $this->BH_Klasse_saldo;
		}


		public function setBHKlasseID($BH_Klasse_ID) {
			$this->BH_Klasse_ID = $BH_Klasse_ID;
			return $this;
		}

		public function setBHKlasseName($BH_Klasse_name) {
			$this->BH_Klasse_name = $BH_Klasse_name;
			return $this;
		}

		public function setBHKlasseSaldo($BH_Klasse_saldo) {
			$this->BH_Klasse_saldo = $BH_Klasse_saldo;
			return $this;
		}




	} 
