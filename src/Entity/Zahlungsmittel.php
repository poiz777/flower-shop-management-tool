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
	 * Zahlungsmittel
	 * @Table(name="Zahlungsmittel")
	 * @Entity(repositoryClass="App\Entity\Repo\ZahlungsmittelRepo")
	 **/
	class Zahlungsmittel {
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
		 * @Id Zahlungsmittel
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Zahlungsmittel Id 
		 * ##FormFieldHint <span class='pz-hint'>Zahlungsmittel_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Zahlungsmittel_id; 

		/**
		 * @var string
		 * @Column(name="Zahlungsmittel_name", type="string", length=20, nullable=false) 
		 * 
		 * ##FormLabel  Zahlungsmittel Name 
		 * ##FormFieldHint <span class='pz-hint'>Zahlungsmittel_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Zahlungsmittel_name; 

		/**
		 * @var string
		 * @Column(name="Zahlungsmittel_kurz", type="string", length=3, nullable=false) 
		 * 
		 * ##FormLabel  Zahlungsmittel Kurz 
		 * ##FormFieldHint <span class='pz-hint'>Zahlungsmittel_kurz</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Zahlungsmittel_kurz; 

		/**
		 * @var int
		 * @Column(name="Zahlungsmittel_konto", type="integer", length=4, nullable=false) 
		 * 
		 * ##FormLabel  Zahlungsmittel Konto 
		 * ##FormFieldHint <span class='pz-hint'>Zahlungsmittel_konto</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Zahlungsmittel_konto; 

		/**
		 * @var int
		 * @Column(name="Zahlungsmittel_Reihenfolge", type="integer", length=4, nullable=false) 
		 * 
		 * ##FormLabel  Zahlungsmittel Reihenfolge 
		 * ##FormFieldHint <span class='pz-hint'>Zahlungsmittel_Reihenfolge</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Zahlungsmittel_Reihenfolge; 

		/**
		 * @var int
		 * @Column(name="Zahlungsmittel_Filiale", type="integer", length=5, nullable=false) 
		 * 
		 * ##FormLabel  Zahlungsmittel Filiale 
		 * ##FormFieldHint <span class='pz-hint'>Zahlungsmittel_Filiale</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Zahlungsmittel_Filiale;
		
		
		
		/**
		 * @var \App\Entity\Zahlungsmittel
		 */
		protected static $instance;
		
		public function __construct(){
			$this->initializeEntityBank();
			static::$instance = $this;
		}


		public function getZahlungsmittelId() {
			return $this->Zahlungsmittel_id;
		}

		public function getZahlungsmittelName() {
			return $this->Zahlungsmittel_name;
		}

		public function getZahlungsmittelKurz() {
			return $this->Zahlungsmittel_kurz;
		}

		public function getZahlungsmittelKonto() {
			return $this->Zahlungsmittel_konto;
		}

		public function getZahlungsmittelReihenfolge() {
			return $this->Zahlungsmittel_Reihenfolge;
		}

		public function getZahlungsmittelFiliale() {
			return $this->Zahlungsmittel_Filiale;
		}


		public function setZahlungsmittelId($Zahlungsmittel_id) {
			$this->Zahlungsmittel_id = $Zahlungsmittel_id;
			return $this;
		}

		public function setZahlungsmittelName($Zahlungsmittel_name) {
			$this->Zahlungsmittel_name = $Zahlungsmittel_name;
			return $this;
		}

		public function setZahlungsmittelKurz($Zahlungsmittel_kurz) {
			$this->Zahlungsmittel_kurz = $Zahlungsmittel_kurz;
			return $this;
		}

		public function setZahlungsmittelKonto($Zahlungsmittel_konto) {
			$this->Zahlungsmittel_konto = $Zahlungsmittel_konto;
			return $this;
		}

		public function setZahlungsmittelReihenfolge($Zahlungsmittel_Reihenfolge) {
			$this->Zahlungsmittel_Reihenfolge = $Zahlungsmittel_Reihenfolge;
			return $this;
		}

		public function setZahlungsmittelFiliale($Zahlungsmittel_Filiale) {
			$this->Zahlungsmittel_Filiale = $Zahlungsmittel_Filiale;
			return $this;
		}




	} 
