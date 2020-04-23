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
	 * Produkte
	 * @Table(name="produkte")
	 * @Entity(repositoryClass="App\Entity\Repo\ProdukteRepo")
	 **/
	class Produkte { 

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
		 * @Id Produkte
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel Produkteid 
		 * ##FormFieldHint <span class='pz-hint'>produkteid</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $produkteid; 

		/**
		 * @var string
		 * @Column(name="name", type="string", length=30, nullable=false) 
		 * 
		 * ##FormLabel Name 
		 * ##FormFieldHint <span class='pz-hint'>name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $name; 

		/**
		 * @var string
		 * @Column(name="name_lat", type="string", length=30, nullable=false) 
		 * 
		 * ##FormLabel Name Lat 
		 * ##FormFieldHint <span class='pz-hint'>name_lat</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $name_lat; 

		/**
		 * @var string
		 * @Column(name="name_it", type="string", length=50, nullable=false) 
		 * 
		 * ##FormLabel Name It 
		 * ##FormFieldHint <span class='pz-hint'>name_it</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $name_it; 

		/**
		 * @var int
		 * @Column(name="produktekategorie", type="smallint", length=2, nullable=false, options={"default":"1"}) 
		 * 
		 * ##FormLabel Produktekategorie 
		 * ##FormFieldHint <span class='pz-hint'>produktekategorie</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $produktekategorie; 

		/**
		 * @var int
		 * @Column(name="mediterran", type="smallint", length=2, nullable=false, options={"default":"1"}) 
		 * 
		 * ##FormLabel Mediterran 
		 * ##FormFieldHint <span class='pz-hint'>mediterran</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $mediterran; 

		/**
		 * @var int
		 * @Column(name="produkte_zeigen", type="smallint", length=2, nullable=false, options={"default":"1"}) 
		 * 
		 * ##FormLabel Produkte Zeigen 
		 * ##FormFieldHint <span class='pz-hint'>produkte_zeigen</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $produkte_zeigen; 

		/**
		 * @var string
		 * @Column(name="Verfuegbarkeit", type="string", length=12, nullable=false) 
		 * 
		 * ##FormLabel  Verfuegbarkeit 
		 * ##FormFieldHint <span class='pz-hint'>Verfuegbarkeit</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Verfuegbarkeit; 

		/**
		 * @var string
		 * @Column(name="URL", type="string", length=70, nullable=true) 
		 * 
		 * ##FormLabel  U R L 
		 * ##FormFieldHint <span class='pz-hint'>URL</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $URL; 

		/**
		 * @var string
		 * @Column(name="Bemerkungen", type="string", length=10000, nullable=false) 
		 * 
		 * ##FormLabel  Bemerkungen 
		 * ##FormFieldHint <span class='pz-hint'>Bemerkungen</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Bemerkungen; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getProdukteid() {
			return $this->produkteid;
		}

		public function getName() {
			return $this->name;
		}

		public function getNameLat() {
			return $this->name_lat;
		}

		public function getNameIt() {
			return $this->name_it;
		}

		public function getProduktekategorie() {
			return $this->produktekategorie;
		}

		public function getMediterran() {
			return $this->mediterran;
		}

		public function getProdukteZeigen() {
			return $this->produkte_zeigen;
		}

		public function getVerfuegbarkeit() {
			return $this->Verfuegbarkeit;
		}

		public function getURL() {
			return $this->URL;
		}

		public function getBemerkungen() {
			return $this->Bemerkungen;
		}


		public function setProdukteid($produkteid) {
			$this->produkteid = $produkteid;
			return $this;
		}

		public function setName($name) {
			$this->name = $name;
			return $this;
		}

		public function setNameLat($name_lat) {
			$this->name_lat = $name_lat;
			return $this;
		}

		public function setNameIt($name_it) {
			$this->name_it = $name_it;
			return $this;
		}

		public function setProduktekategorie($produktekategorie) {
			$this->produktekategorie = $produktekategorie;
			return $this;
		}

		public function setMediterran($mediterran) {
			$this->mediterran = $mediterran;
			return $this;
		}

		public function setProdukteZeigen($produkte_zeigen) {
			$this->produkte_zeigen = $produkte_zeigen;
			return $this;
		}

		public function setVerfuegbarkeit($Verfuegbarkeit) {
			$this->Verfuegbarkeit = $Verfuegbarkeit;
			return $this;
		}

		public function setURL($URL) {
			$this->URL = $URL;
			return $this;
		}

		public function setBemerkungen($Bemerkungen) {
			$this->Bemerkungen = $Bemerkungen;
			return $this;
		}




	} 
