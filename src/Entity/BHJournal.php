<?php 

	namespace App\Entity;

	use App\Helpers\Date\RequestBridge;
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
	 * BHJournal
	 * @Table(name="BH_Journal")
	 * @Entity(repositoryClass="App\Entity\Repo\BHJournalRepo")
	 **/
	class BHJournal {
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
		 * @Id BHJournal
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 *--FormLabel  BH Journal Id
		 *--FormFieldHint <span class='pz-hint'>BH_Journal_id</span>
		 *--FormInputType number
		 *--FormInputRequired 0
		 *--FormPlaceholder 0
		 *--FormInputOptions NULL
		 *--FormValidationStrategy NUM
		 *--FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Journal_id; 

		/**
		 * @var \DateTime
		 * @Column(name="BH_Journal_datum", type="datetime", nullable=false)
		 * 
		 * ##FormLabel  B H Journal Datum 
		 * ##FormFieldHint <span class='pz-hint'>BH_Journal_datum</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy DATETIME 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $BH_Journal_datum; 

		/**
		 * @var string
		 * @Column(name="BH_Journal_kommentar", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  B H Journal Kommentar 
		 * ##FormFieldHint <span class='pz-hint'>BH_Journal_kommentar</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $BH_Journal_kommentar; 

		/**
		 * @var int
		 * @Column(name="BH_Journal_konto_soll", type="integer", length=4, nullable=false) 
		 * 
		 * ##FormLabel  B H Journal Konto Soll 
		 * ##FormFieldHint <span class='pz-hint'>BH_Journal_konto_soll</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Journal_konto_soll; 

		/**
		 * @var int
		 * @Column(name="BH_Journal_konto_haben", type="integer", length=4, nullable=false) 
		 * 
		 * ##FormLabel  BH Journal Konto Haben
		 * ##FormFieldHint <span class='pz-hint'>BH_Journal_konto_haben</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Journal_konto_haben; 

		/**
		 * @var double
		 * @Column(name="BH_Journal_betrag", type="text", length=10, nullable=false) 
		 * 
		 * ##FormLabel  B H Journal Betrag 
		 * ##FormFieldHint <span class='pz-hint'>BH_Journal_betrag</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Journal_betrag; 

		/**
		 * @var int
		 * @Column(name="BH_Journal_verkauf_id", type="integer", length=6, nullable=false) 
		 * 
		 * ##FormLabel  B H Journal Verkauf Id 
		 * ##FormFieldHint <span class='pz-hint'>BH_Journal_verkauf_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Journal_verkauf_id; 

		/**
		 * @var int
		 * @Column(name="BH_Journal_kreditor_id", type="integer", length=5, nullable=false) 
		 * 
		 * ##FormLabel  B H Journal Kreditor Id 
		 * ##FormFieldHint <span class='pz-hint'>BH_Journal_kreditor_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BH_Journal_kreditor_id; 

		/**
		 * @var int
		 * @Column(name="BH_Journal_ma", type="integer", length=5, nullable=false) 
		 * 
		 * ##FormLabel Mitarbeiter
		 * ##FormFieldHint <span class='pz-hint'>Mitarbeiter</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder Mitarbeiter
		 * ##FormInputOptions App\Entity\BHJournal::fetchCoWorkers
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $BH_Journal_ma;
		
		/**
		 * @var array
		 */
		private array $bill       = [];
		
		/**
		 * @var array
		 */
		private array $billPosts  = [];
		
		/**
		 * @var array
		 */
		private array $productCat = [];
		
		/**
		 * @var \App\Entity\BHJournal
		 */
		protected static $instance;
		
		public function __construct(){
			global $kernel; # $entityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');
			$this->BH_Journal_datum = new \DateTime();
			$melSession             = $kernel->getContainer()->get('session')->get(RequestBridge::SessionNameSpace);
			if(isset($melSession['department'])){
				$this->BH_Journal_ma    = $melSession['department'];
			}
			$this->initializeEntityBank();
			static::$instance = $this;
		}


		public function getBHJournalId() {
			return $this->BH_Journal_id;
		}

		public function getBHJournalDatum() {
			return $this->BH_Journal_datum;
		}

		public function getBHJournalKommentar() {
			return $this->BH_Journal_kommentar;
		}

		public function getBHJournalKontoSoll() {
			return $this->BH_Journal_konto_soll;
		}

		public function getBHJournalKontoHaben() {
			return $this->BH_Journal_konto_haben;
		}

		public function getBHJournalBetrag() {
			return $this->BH_Journal_betrag;
		}
		
		public function getBHJournalVerkaufId() {
			return $this->BH_Journal_verkauf_id;
		}

		public function getBHJournalKreditorId() {
			return $this->BH_Journal_kreditor_id;
		}

		public function getBHJournalMa() {
			return $this->BH_Journal_ma;
		}
		
		public function getProductCat() {
			return $this->productCat;
		}
		
		public function getBill() {
			return $this->bill;
		}
		
		public function getBillPosts(){
			return $this->billPosts;
		}
		

		
		
		
		
		public function setBHJournalId($BH_Journal_id) {
			$this->BH_Journal_id = $BH_Journal_id;
			return $this;
		}

		public function setBHJournalDatum($BH_Journal_datum) {
			$this->BH_Journal_datum = $BH_Journal_datum;
			return $this;
		}

		public function setBHJournalKommentar($BH_Journal_kommentar) {
			$this->BH_Journal_kommentar = $BH_Journal_kommentar;
			return $this;
		}

		public function setBHJournalKontoSoll($BH_Journal_konto_soll) {
			$this->BH_Journal_konto_soll = $BH_Journal_konto_soll;
			return $this;
		}

		public function setBHJournalKontoHaben($BH_Journal_konto_haben) {
			$this->BH_Journal_konto_haben = $BH_Journal_konto_haben;
			return $this;
		}

		public function setBHJournalBetrag($BH_Journal_betrag) {
			$this->BH_Journal_betrag = $BH_Journal_betrag;
			return $this;
		}

		public function setBHJournalVerkaufId($BH_Journal_verkauf_id) {
			$this->BH_Journal_verkauf_id = $BH_Journal_verkauf_id;
			return $this;
		}

		public function setBHJournalKreditorId($BH_Journal_kreditor_id) {
			$this->BH_Journal_kreditor_id = $BH_Journal_kreditor_id;
			return $this;
		}

		public function setBHJournalMa($BH_Journal_ma) {
			$this->BH_Journal_ma = $BH_Journal_ma;
			return $this;
		}
		
		public function setProductCat($productCat) {
			$this->productCat = $productCat;
			return $this;
		}
		
		public function setBill( array $bill ): BHJournal {
			$this->bill = $bill;
			
			return $this;
		}
		
		public function setBillPosts($billPosts) {
			$this->billPosts = $billPosts;
			return $this;
		}
		
	} 
