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
	 * Express
	 * @Table(name="Express")
	 * @Entity(repositoryClass="App\Entity\Repo\ExpressRepo")
	 **/
	class Express { 

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
		 * @Id Express
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Express Id 
		 * ##FormFieldHint <span class='pz-hint'>Express_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Express_id; 

		/**
		 * @var int
		 * @Column(name="Express_PLZ_lang", type="integer", length=7, nullable=false) 
		 * 
		 * ##FormLabel  Express P L Z Lang 
		 * ##FormFieldHint <span class='pz-hint'>Express_PLZ_lang</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Express_PLZ_lang; 

		/**
		 * @var int
		 * @Column(name="Express_PLZ", type="smallint", length=5, nullable=false) 
		 * 
		 * ##FormLabel  Express P L Z 
		 * ##FormFieldHint <span class='pz-hint'>Express_PLZ</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Express_PLZ; 

		/**
		 * @var string
		 * @Column(name="Express_Ort", type="string", length=50, nullable=false) 
		 * 
		 * ##FormLabel  Express Ort 
		 * ##FormFieldHint <span class='pz-hint'>Express_Ort</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Express_Ort; 

		/**
		 * @var int
		 * @Column(name="Express_Kurier_flag", type="smallint", length=2, nullable=false) 
		 * 
		 * ##FormLabel  Express Kurier Flag 
		 * ##FormFieldHint <span class='pz-hint'>Express_Kurier_flag</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Express_Kurier_flag; 

		/**
		 * @var int
		 * @Column(name="Express_Kurier_kosten", type="smallint", length=4, nullable=false) 
		 * 
		 * ##FormLabel  Express Kurier Kosten 
		 * ##FormFieldHint <span class='pz-hint'>Express_Kurier_kosten</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Express_Kurier_kosten; 

		/**
		 * @var int
		 * @Column(name="Express_Intercity_flag", type="smallint", length=2, nullable=false) 
		 * 
		 * ##FormLabel  Express Intercity Flag 
		 * ##FormFieldHint <span class='pz-hint'>Express_Intercity_flag</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Express_Intercity_flag; 

		/**
		 * @var int
		 * @Column(name="Express_Intercity_zeit", type="time", nullable=false) 
		 * 
		 * ##FormLabel  Express Intercity Zeit 
		 * ##FormFieldHint <span class='pz-hint'>Express_Intercity_zeit</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy DATETIME 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $Express_Intercity_zeit; 

		/**
		 * @var int
		 * @Column(name="Express_Intercity_delta", type="smallint", length=2, nullable=false) 
		 * 
		 * ##FormLabel  Express Intercity Delta 
		 * ##FormFieldHint <span class='pz-hint'>Express_Intercity_delta</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Express_Intercity_delta; 

		/**
		 * @var int
		 * @Column(name="Express_Intercity_kosten", type="smallint", length=4, nullable=false) 
		 * 
		 * ##FormLabel  Express Intercity Kosten 
		 * ##FormFieldHint <span class='pz-hint'>Express_Intercity_kosten</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Express_Intercity_kosten; 

		/**
		 * @var int
		 * @Column(name="Express_Blitz_flag", type="smallint", length=2, nullable=false) 
		 * 
		 * ##FormLabel  Express Blitz Flag 
		 * ##FormFieldHint <span class='pz-hint'>Express_Blitz_flag</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Express_Blitz_flag; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getExpressId() {
			return $this->Express_id;
		}

		public function getExpressPLZLang() {
			return $this->Express_PLZ_lang;
		}

		public function getExpressPLZ() {
			return $this->Express_PLZ;
		}

		public function getExpressOrt() {
			return $this->Express_Ort;
		}

		public function getExpressKurierFlag() {
			return $this->Express_Kurier_flag;
		}

		public function getExpressKurierKosten() {
			return $this->Express_Kurier_kosten;
		}

		public function getExpressIntercityFlag() {
			return $this->Express_Intercity_flag;
		}

		public function getExpressIntercityZeit() {
			return $this->Express_Intercity_zeit;
		}

		public function getExpressIntercityDelta() {
			return $this->Express_Intercity_delta;
		}

		public function getExpressIntercityKosten() {
			return $this->Express_Intercity_kosten;
		}

		public function getExpressBlitzFlag() {
			return $this->Express_Blitz_flag;
		}


		public function setExpressId($Express_id) {
			$this->Express_id = $Express_id;
			return $this;
		}

		public function setExpressPLZLang($Express_PLZ_lang) {
			$this->Express_PLZ_lang = $Express_PLZ_lang;
			return $this;
		}

		public function setExpressPLZ($Express_PLZ) {
			$this->Express_PLZ = $Express_PLZ;
			return $this;
		}

		public function setExpressOrt($Express_Ort) {
			$this->Express_Ort = $Express_Ort;
			return $this;
		}

		public function setExpressKurierFlag($Express_Kurier_flag) {
			$this->Express_Kurier_flag = $Express_Kurier_flag;
			return $this;
		}

		public function setExpressKurierKosten($Express_Kurier_kosten) {
			$this->Express_Kurier_kosten = $Express_Kurier_kosten;
			return $this;
		}

		public function setExpressIntercityFlag($Express_Intercity_flag) {
			$this->Express_Intercity_flag = $Express_Intercity_flag;
			return $this;
		}

		public function setExpressIntercityZeit($Express_Intercity_zeit) {
			$this->Express_Intercity_zeit = $Express_Intercity_zeit;
			return $this;
		}

		public function setExpressIntercityDelta($Express_Intercity_delta) {
			$this->Express_Intercity_delta = $Express_Intercity_delta;
			return $this;
		}

		public function setExpressIntercityKosten($Express_Intercity_kosten) {
			$this->Express_Intercity_kosten = $Express_Intercity_kosten;
			return $this;
		}

		public function setExpressBlitzFlag($Express_Blitz_flag) {
			$this->Express_Blitz_flag = $Express_Blitz_flag;
			return $this;
		}




	} 
