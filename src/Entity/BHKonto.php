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
	 * BHKonto
	 * @Table(name="BH_Konto")
	 * @Entity(repositoryClass="App\Entity\Repo\BHKontoRepo")
	 **/
	class BHKonto { 

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
		 * @Id BHKonto
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  B H Konto I D 
		 * ##FormFieldHint <span class='pz-hint'>BH_Konto_ID</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Konto_ID; 

		/**
		 * @var int
		 * @Column(name="BH_Konto_Nummer", type="smallint", length=4, nullable=false) 
		 * 
		 * ##FormLabel  B H Konto Nummer 
		 * ##FormFieldHint <span class='pz-hint'>BH_Konto_Nummer</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Konto_Nummer; 

		/**
		 * @var int
		 * @Column(name="BH_Konto_GruppeID", type="smallint", length=3, nullable=false) 
		 * 
		 * ##FormLabel  B H Konto Gruppe I D 
		 * ##FormFieldHint <span class='pz-hint'>BH_Konto_GruppeID</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Konto_GruppeID; 

		/**
		 * @var int
		 * @Column(name="BH_Konto_HauptgruppeID", type="smallint", length=4, nullable=false) 
		 * 
		 * ##FormLabel  B H Konto Hauptgruppe I D 
		 * ##FormFieldHint <span class='pz-hint'>BH_Konto_HauptgruppeID</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Konto_HauptgruppeID; 

		/**
		 * @var int
		 * @Column(name="BH_Konto_KlasseID", type="smallint", length=4, nullable=false) 
		 * 
		 * ##FormLabel  B H Konto Klasse I D 
		 * ##FormFieldHint <span class='pz-hint'>BH_Konto_KlasseID</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Konto_KlasseID; 

		/**
		 * @var string
		 * @Column(name="BH_Konto_name", type="string", length=40, nullable=false) 
		 * 
		 * ##FormLabel  B H Konto Name 
		 * ##FormFieldHint <span class='pz-hint'>BH_Konto_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $BH_Konto_name; 

		/**
		 * @var double
		 * @Column(name="BH_Konto_2009_open", type="text", length=10, nullable=false) 
		 * 
		 * ##FormLabel  B H Konto 2009 Open 
		 * ##FormFieldHint <span class='pz-hint'>BH_Konto_2009_open</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Konto_2009_open; 

		/**
		 * @var double
		 * @Column(name="BH_Konto_2010_open", type="text", length=10, nullable=false, options={"default":"0.00"}) 
		 * 
		 * ##FormLabel  B H Konto 2010 Open 
		 * ##FormFieldHint <span class='pz-hint'>BH_Konto_2010_open</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Konto_2010_open; 

		/**
		 * @var double
		 * @Column(name="BH_Konto_2011_open", type="text", length=10, nullable=false, options={"default":"0.00"}) 
		 * 
		 * ##FormLabel  B H Konto 2011 Open 
		 * ##FormFieldHint <span class='pz-hint'>BH_Konto_2011_open</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Konto_2011_open; 

		/**
		 * @var double
		 * @Column(name="BH_Konto_2012_open", type="text", length=10, nullable=false, options={"default":"0.00"}) 
		 * 
		 * ##FormLabel  B H Konto 2012 Open 
		 * ##FormFieldHint <span class='pz-hint'>BH_Konto_2012_open</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Konto_2012_open; 

		/**
		 * @var double
		 * @Column(name="BH_Konto_2013_open", type="text", length=10, nullable=false, options={"default":"0.00"}) 
		 * 
		 * ##FormLabel  B H Konto 2013 Open 
		 * ##FormFieldHint <span class='pz-hint'>BH_Konto_2013_open</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Konto_2013_open; 

		/**
		 * @var double
		 * @Column(name="BH_Konto_2014_open", type="text", length=10, nullable=false, options={"default":"0.00"}) 
		 * 
		 * ##FormLabel  B H Konto 2014 Open 
		 * ##FormFieldHint <span class='pz-hint'>BH_Konto_2014_open</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Konto_2014_open; 

		/**
		 * @var double
		 * @Column(name="BH_Konto_2015_open", type="text", length=10, nullable=false, options={"default":"0.00"}) 
		 * 
		 * ##FormLabel  B H Konto 2015 Open 
		 * ##FormFieldHint <span class='pz-hint'>BH_Konto_2015_open</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Konto_2015_open; 

		/**
		 * @var double
		 * @Column(name="BH_Konto_2016_open", type="text", length=10, nullable=false, options={"default":"0.00"}) 
		 * 
		 * ##FormLabel  B H Konto 2016 Open 
		 * ##FormFieldHint <span class='pz-hint'>BH_Konto_2016_open</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Konto_2016_open; 

		/**
		 * @var double
		 * @Column(name="BH_Konto_2017_open", type="text", length=10, nullable=false, options={"default":"0.00"}) 
		 * 
		 * ##FormLabel  B H Konto 2017 Open 
		 * ##FormFieldHint <span class='pz-hint'>BH_Konto_2017_open</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Konto_2017_open; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getBHKontoID() {
			return $this->BH_Konto_ID;
		}

		public function getBHKontoNummer() {
			return $this->BH_Konto_Nummer;
		}

		public function getBHKontoGruppeID() {
			return $this->BH_Konto_GruppeID;
		}

		public function getBHKontoHauptgruppeID() {
			return $this->BH_Konto_HauptgruppeID;
		}

		public function getBHKontoKlasseID() {
			return $this->BH_Konto_KlasseID;
		}

		public function getBHKontoName() {
			return $this->BH_Konto_name;
		}

		public function getBHKonto2009Open() {
			return $this->BH_Konto_2009_open;
		}

		public function getBHKonto2010Open() {
			return $this->BH_Konto_2010_open;
		}

		public function getBHKonto2011Open() {
			return $this->BH_Konto_2011_open;
		}

		public function getBHKonto2012Open() {
			return $this->BH_Konto_2012_open;
		}

		public function getBHKonto2013Open() {
			return $this->BH_Konto_2013_open;
		}

		public function getBHKonto2014Open() {
			return $this->BH_Konto_2014_open;
		}

		public function getBHKonto2015Open() {
			return $this->BH_Konto_2015_open;
		}

		public function getBHKonto2016Open() {
			return $this->BH_Konto_2016_open;
		}

		public function getBHKonto2017Open() {
			return $this->BH_Konto_2017_open;
		}


		public function setBHKontoID($BH_Konto_ID) {
			$this->BH_Konto_ID = $BH_Konto_ID;
			return $this;
		}

		public function setBHKontoNummer($BH_Konto_Nummer) {
			$this->BH_Konto_Nummer = $BH_Konto_Nummer;
			return $this;
		}

		public function setBHKontoGruppeID($BH_Konto_GruppeID) {
			$this->BH_Konto_GruppeID = $BH_Konto_GruppeID;
			return $this;
		}

		public function setBHKontoHauptgruppeID($BH_Konto_HauptgruppeID) {
			$this->BH_Konto_HauptgruppeID = $BH_Konto_HauptgruppeID;
			return $this;
		}

		public function setBHKontoKlasseID($BH_Konto_KlasseID) {
			$this->BH_Konto_KlasseID = $BH_Konto_KlasseID;
			return $this;
		}

		public function setBHKontoName($BH_Konto_name) {
			$this->BH_Konto_name = $BH_Konto_name;
			return $this;
		}

		public function setBHKonto2009Open($BH_Konto_2009_open) {
			$this->BH_Konto_2009_open = $BH_Konto_2009_open;
			return $this;
		}

		public function setBHKonto2010Open($BH_Konto_2010_open) {
			$this->BH_Konto_2010_open = $BH_Konto_2010_open;
			return $this;
		}

		public function setBHKonto2011Open($BH_Konto_2011_open) {
			$this->BH_Konto_2011_open = $BH_Konto_2011_open;
			return $this;
		}

		public function setBHKonto2012Open($BH_Konto_2012_open) {
			$this->BH_Konto_2012_open = $BH_Konto_2012_open;
			return $this;
		}

		public function setBHKonto2013Open($BH_Konto_2013_open) {
			$this->BH_Konto_2013_open = $BH_Konto_2013_open;
			return $this;
		}

		public function setBHKonto2014Open($BH_Konto_2014_open) {
			$this->BH_Konto_2014_open = $BH_Konto_2014_open;
			return $this;
		}

		public function setBHKonto2015Open($BH_Konto_2015_open) {
			$this->BH_Konto_2015_open = $BH_Konto_2015_open;
			return $this;
		}

		public function setBHKonto2016Open($BH_Konto_2016_open) {
			$this->BH_Konto_2016_open = $BH_Konto_2016_open;
			return $this;
		}

		public function setBHKonto2017Open($BH_Konto_2017_open) {
			$this->BH_Konto_2017_open = $BH_Konto_2017_open;
			return $this;
		}




	} 
