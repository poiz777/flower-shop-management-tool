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
	 * BHHauptgruppe
	 * @Table(name="BH_Hauptgruppe")
	 * @Entity(repositoryClass="App\Entity\Repo\BHHauptgruppeRepo")
	 **/
	class BHHauptgruppe { 

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
		 * @Id BHHauptgruppe
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  B H Hauptgruppe I D 
		 * ##FormFieldHint <span class='pz-hint'>BH_Hauptgruppe_ID</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Hauptgruppe_ID; 

		/**
		 * @var int
		 * @Column(name="BH_Hauptgruppe_Nummer", type="smallint", length=4, nullable=false) 
		 * 
		 * ##FormLabel  B H Hauptgruppe Nummer 
		 * ##FormFieldHint <span class='pz-hint'>BH_Hauptgruppe_Nummer</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Hauptgruppe_Nummer; 

		/**
		 * @var int
		 * @Column(name="BH_Hauptgruppe_KlasseID", type="smallint", length=2, nullable=false) 
		 * 
		 * ##FormLabel  B H Hauptgruppe Klasse I D 
		 * ##FormFieldHint <span class='pz-hint'>BH_Hauptgruppe_KlasseID</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Hauptgruppe_KlasseID; 

		/**
		 * @var string
		 * @Column(name="BH_Hauptgruppe_name", type="string", length=60, nullable=false) 
		 * 
		 * ##FormLabel  B H Hauptgruppe Name 
		 * ##FormFieldHint <span class='pz-hint'>BH_Hauptgruppe_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $BH_Hauptgruppe_name; 

		/**
		 * @var double
		 * @Column(name="BH_Hauptgruppe_Saldo", type="text", length=10, nullable=false) 
		 * 
		 * ##FormLabel  B H Hauptgruppe Saldo 
		 * ##FormFieldHint <span class='pz-hint'>BH_Hauptgruppe_Saldo</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Hauptgruppe_Saldo; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getBHHauptgruppeID() {
			return $this->BH_Hauptgruppe_ID;
		}

		public function getBHHauptgruppeNummer() {
			return $this->BH_Hauptgruppe_Nummer;
		}

		public function getBHHauptgruppeKlasseID() {
			return $this->BH_Hauptgruppe_KlasseID;
		}

		public function getBHHauptgruppeName() {
			return $this->BH_Hauptgruppe_name;
		}

		public function getBHHauptgruppeSaldo() {
			return $this->BH_Hauptgruppe_Saldo;
		}


		public function setBHHauptgruppeID($BH_Hauptgruppe_ID) {
			$this->BH_Hauptgruppe_ID = $BH_Hauptgruppe_ID;
			return $this;
		}

		public function setBHHauptgruppeNummer($BH_Hauptgruppe_Nummer) {
			$this->BH_Hauptgruppe_Nummer = $BH_Hauptgruppe_Nummer;
			return $this;
		}

		public function setBHHauptgruppeKlasseID($BH_Hauptgruppe_KlasseID) {
			$this->BH_Hauptgruppe_KlasseID = $BH_Hauptgruppe_KlasseID;
			return $this;
		}

		public function setBHHauptgruppeName($BH_Hauptgruppe_name) {
			$this->BH_Hauptgruppe_name = $BH_Hauptgruppe_name;
			return $this;
		}

		public function setBHHauptgruppeSaldo($BH_Hauptgruppe_Saldo) {
			$this->BH_Hauptgruppe_Saldo = $BH_Hauptgruppe_Saldo;
			return $this;
		}




	} 
