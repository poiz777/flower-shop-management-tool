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
	 * BHGruppe
	 * @Table(name="BH_Gruppe")
	 * @Entity(repositoryClass="App\Entity\Repo\BHGruppeRepo")
	 **/
	class BHGruppe { 

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
		 * @Id BHGruppe
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  B H Gruppe I D 
		 * ##FormFieldHint <span class='pz-hint'>BH_Gruppe_ID</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Gruppe_ID; 

		/**
		 * @var int
		 * @Column(name="BH_Gruppe_Nummer", type="smallint", length=4, nullable=false) 
		 * 
		 * ##FormLabel  B H Gruppe Nummer 
		 * ##FormFieldHint <span class='pz-hint'>BH_Gruppe_Nummer</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Gruppe_Nummer; 

		/**
		 * @var int
		 * @Column(name="BH_Gruppe_HauptgruppeID", type="smallint", length=2, nullable=false) 
		 * 
		 * ##FormLabel  B H Gruppe Hauptgruppe I D 
		 * ##FormFieldHint <span class='pz-hint'>BH_Gruppe_HauptgruppeID</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Gruppe_HauptgruppeID; 

		/**
		 * @var string
		 * @Column(name="BH_Gruppe_name", type="string", length=70, nullable=false) 
		 * 
		 * ##FormLabel  B H Gruppe Name 
		 * ##FormFieldHint <span class='pz-hint'>BH_Gruppe_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $BH_Gruppe_name; 

		/**
		 * @var double
		 * @Column(name="BH_Gruppe_Saldo", type="text", length=10, nullable=false) 
		 * 
		 * ##FormLabel  B H Gruppe Saldo 
		 * ##FormFieldHint <span class='pz-hint'>BH_Gruppe_Saldo</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Gruppe_Saldo; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getBHGruppeID() {
			return $this->BH_Gruppe_ID;
		}

		public function getBHGruppeNummer() {
			return $this->BH_Gruppe_Nummer;
		}

		public function getBHGruppeHauptgruppeID() {
			return $this->BH_Gruppe_HauptgruppeID;
		}

		public function getBHGruppeName() {
			return $this->BH_Gruppe_name;
		}

		public function getBHGruppeSaldo() {
			return $this->BH_Gruppe_Saldo;
		}


		public function setBHGruppeID($BH_Gruppe_ID) {
			$this->BH_Gruppe_ID = $BH_Gruppe_ID;
			return $this;
		}

		public function setBHGruppeNummer($BH_Gruppe_Nummer) {
			$this->BH_Gruppe_Nummer = $BH_Gruppe_Nummer;
			return $this;
		}

		public function setBHGruppeHauptgruppeID($BH_Gruppe_HauptgruppeID) {
			$this->BH_Gruppe_HauptgruppeID = $BH_Gruppe_HauptgruppeID;
			return $this;
		}

		public function setBHGruppeName($BH_Gruppe_name) {
			$this->BH_Gruppe_name = $BH_Gruppe_name;
			return $this;
		}

		public function setBHGruppeSaldo($BH_Gruppe_Saldo) {
			$this->BH_Gruppe_Saldo = $BH_Gruppe_Saldo;
			return $this;
		}




	} 
