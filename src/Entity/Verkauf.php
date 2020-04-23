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
	 * Verkauf
	 * @Table(name="verkauf")
	 * @Entity(repositoryClass="App\Entity\Repo\VerkaufRepo")
	 **/
	class Verkauf {
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
		 * @Id Verkauf
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel Verkaufid 
		 * ##FormFieldHint <span class='pz-hint'>verkaufid</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $verkaufid; 

		/**
		 * @var \DateTime
		 * @Column(name="verkaufdatum", type="datetime", nullable=false, options={"default":"0000-00-00"})
		 * 
		 * ##FormLabel Verkaufdatum 
		 * ##FormFieldHint <span class='pz-hint'>verkaufdatum</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy DATETIME 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $verkaufdatum; 

		/**
		 * @var int
		 * @Column(name="verkaufzeit", type="string", nullable=false, options={"default":"00:00:00"})
		 * 
		 * ##FormLabel Verkaufzeit 
		 * ##FormFieldHint <span class='pz-hint'>verkaufzeit</span>
		 * ##FormInputType time
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Time
		 */
		protected $verkaufzeit; 

		/**
		 * @var int
		 * @Column(name="verkaufmitarbeiter", type="integer", length=3, nullable=false, options={"default":1}) 
		 * 
		 * ##FormLabel Verkaufmitarbeiter 
		 * ##FormFieldHint <span class='pz-hint'>verkaufmitarbeiter</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $verkaufmitarbeiter; 

		/**
		 * @var int
		 * @Column(name="verkaufkunde", type="integer", length=5, nullable=false) 
		 * 
		 * ##FormLabel Verkaufkunde 
		 * ##FormFieldHint <span class='pz-hint'>verkaufkunde</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $verkaufkunde; 

		/**
		 * @var int
		 * @Column(name="verkaufbetrag", type="integer", length=6, nullable=false) 
		 * 
		 * ##FormLabel Verkaufbetrag 
		 * ##FormFieldHint <span class='pz-hint'>verkaufbetrag</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $verkaufbetrag; 

		/**
		 * @var int
		 * @Column(name="verkaufzahlungsmittel", type="smallint", length=3, nullable=false, options={"default":"1"}) 
		 * 
		 * ##FormLabel Verkaufzahlungsmittel 
		 * ##FormFieldHint <span class='pz-hint'>verkaufzahlungsmittel</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $verkaufzahlungsmittel;

		/**
		 * @var int
		 * @Column(name="verkauf_status_id", type="smallint", length=2, nullable=false, options={"default":"5"}) 
		 * 
		 * ##FormLabel Verkauf Status Id 
		 * ##FormFieldHint <span class='pz-hint'>verkauf_status_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $verkauf_status_id;
		
		
		
		/**
		 * @var array
		 */
		private $client         = [];
		
		/**
		 * #var array
		 */
		# private $bill          = [];
		
		/**
		 * #var array
		 */
		# private $billPosts     = [];
		
		/**
		 * @var array
		 */
		private $bhJournal      = [];
		
		/**
		 * @var array
		 */
		private $productCats    = [];
		
		/**
		 * @var array
		 */
		private $paymentMethod  = [];
		
		
		/**
		 * @var \App\Entity\Verkauf
		 */
		protected static $instance;
		
		public function __construct(){
			$this->initializeEntityBank();
			static::$instance = $this;
		}


		public function getVerkaufid() {
			return $this->verkaufid;
		}

		public function getVerkaufdatum() {
			return $this->verkaufdatum;
		}

		public function getVerkaufzeit() {
			if($this->verkaufzeit instanceof \DateTime){
				return $this->verkaufzeit->format('H:i:s');
			}
			return $this->verkaufzeit;
		}

		public function getVerkaufmitarbeiter() {
			return $this->verkaufmitarbeiter;
		}

		public function getVerkaufkunde() {
			return $this->verkaufkunde;
		}

		public function getVerkaufbetrag() {
			return $this->verkaufbetrag;
		}

		public function getVerkaufzahlungsmittel() {
			return $this->verkaufzahlungsmittel;
		}

		public function getVerkaufStatusId() {
			return $this->verkauf_status_id;
		}


		public function setVerkaufid($verkaufid) {
			$this->verkaufid = $verkaufid;
			return $this;
		}

		public function setVerkaufdatum($verkaufdatum) {
			$this->verkaufdatum = $verkaufdatum;
			return $this;
		}

		public function setVerkaufzeit($verkaufzeit) {
			$this->verkaufzeit = $verkaufzeit;
			return $this;
		}

		public function setVerkaufmitarbeiter($verkaufmitarbeiter) {
			$this->verkaufmitarbeiter = $verkaufmitarbeiter;
			return $this;
		}

		public function setVerkaufkunde($verkaufkunde) {
			$this->verkaufkunde = $verkaufkunde;
			return $this;
		}

		public function setVerkaufbetrag($verkaufbetrag) {
			$this->verkaufbetrag = $verkaufbetrag;
			return $this;
		}

		public function setVerkaufzahlungsmittel($verkaufzahlungsmittel) {
			$this->verkaufzahlungsmittel = $verkaufzahlungsmittel;
			return $this;
		}

		public function setVerkaufStatusId($verkauf_status_id) {
			$this->verkauf_status_id = $verkauf_status_id;
			return $this;
		}
		
		
		
		
		
		
		/**
		 * @return array
		 */
		public function getPaymentMethod(): array {
			return $this->paymentMethod;
		}
		
		/**
		 * @return array
		 */
		public function getClient(): array {
			return $this->client;
		}
		
		/**
		 * @return array
		 */
		public function getBill(): array {
			return $this->bill;
		}
		
		/**
		 * @return array
		 */
		public function getBillPosts(): array {
			return $this->billPosts;
		}
		
		/**
		 * @return array
		 */
		public function getBhJournal(): array {
			return $this->bhJournal;
		}
		
		/**
		 * @return array
		 */
		public function getProductCats(): array {
			return $this->productCats;
		}
		
		
		
		/**
		 * @param array $paymentMethod
		 *
		 * @return Verkauf
		 */
		public function setPaymentMethod( array $paymentMethod ): Verkauf {
			$this->paymentMethod = $paymentMethod;
			
			return $this;
		}
		
		/**
		 * @param array $client
		 *
		 * @return Verkauf
		 */
		public function setClient( array $client ): Verkauf {
			$this->client = $client;
			
			return $this;
		}
		
		/**
		 * @param array $bill
		 *
		 * @return Verkauf
		 */
		public function setBill( array $bill ): Verkauf {
			$this->bill = $bill;
			
			return $this;
		}
		
		/**
		 * @param array $billPosts
		 *
		 * @return Verkauf
		 */
		public function setBillPosts( array $billPosts ): Verkauf {
			$this->billPosts = $billPosts;
			
			return $this;
		}
		
		/**
		 * @param array $bhJournal
		 *
		 * @return Verkauf
		 */
		public function setBhJournal( array $bhJournal ): Verkauf {
			$this->bhJournal = $bhJournal;
			
			return $this;
		}
		
		/**
		 * @param array $productCats
		 *
		 * @return Verkauf
		 */
		public function setProductCats( array $productCats ): Verkauf {
			$this->productCats = $productCats;
			
			return $this;
		}

	} 
