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
	 * Rechnung
	 * @Table(name="Rechnung")
	 * @Entity(repositoryClass="App\Entity\Repo\RechnungRepo")
	 **/
	class Rechnung {
		
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
		 * @Id Rechnung
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Rechnung Id 
		 * ##FormFieldHint <span class='pz-hint'>Rechnung_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Rechnung_id; 

		/**
		 * @var int
		 * @Column(name="Rechnung_nummer", type="integer", length=11, nullable=false)
		 * 
		 * ##FormLabel  Rechnung Nummer 
		 * ##FormFieldHint <span class='pz-hint'>Rechnung_nummer</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Rechnung_nummer; 

		/**
		 * @var int
		 * @Column(name="Rechnung_status", type="smallint", length=3, nullable=false) 
		 * 
		 * ##FormLabel  Rechnung Status 
		 * ##FormFieldHint <span class='pz-hint'>Rechnung_status</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Rechnung_status; 

		/**
		 * @var \DateTime
		 * @Column(name="Rechnung_Datum_open", type="datetime", nullable=false, options={"default":"0000-00-00"})
		 * 
		 * ##FormLabel  Rechnung Datum Open 
		 * ##FormFieldHint <span class='pz-hint'>Rechnung_Datum_open</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy DATETIME 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $Rechnung_Datum_open; 

		/**
		 * @var \DateTime
		 * @Column(name="Rechnung_Datum_bill", type="datetime", nullable=false, options={"default":"0000-00-00"})
		 * 
		 * ##FormLabel  Rechnung Datum Bill 
		 * ##FormFieldHint <span class='pz-hint'>Rechnung_Datum_bill</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy DATETIME 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $Rechnung_Datum_bill; 

		/**
		 * @var \DateTime
		 * @Column(name="Rechnung_Datum_bez", type="datetime", nullable=false, options={"default":"0000-00-00"})
		 * 
		 * ##FormLabel  Rechnung Datum Bez 
		 * ##FormFieldHint <span class='pz-hint'>Rechnung_Datum_bez</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy DATETIME 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $Rechnung_Datum_bez; 

		/**
		 * @var int
		 * @Column(name="Rechnung_BHNr_bez", type="integer", length=11, nullable=false)
		 * 
		 * ##FormLabel  Rechnung B H Nr Bez 
		 * ##FormFieldHint <span class='pz-hint'>Rechnung_BHNr_bez</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Rechnung_BHNr_bez; 

		/**
		 * @var int
		 * @Column(name="Rechnung_kunde", type="integer", length=11, nullable=false)
		 * 
		 * ##FormLabel  Rechnung Kunde 
		 * ##FormFieldHint <span class='pz-hint'>Rechnung_kunde</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Rechnung_kunde; 

		/**
		 * @var int
		 * @Column(name="Rechnung_betrag_bill", type="integer", length=10, nullable=false) 
		 * 
		 * ##FormLabel  Rechnung Betrag Bill 
		 * ##FormFieldHint <span class='pz-hint'>Rechnung_betrag_bill</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Rechnung_betrag_bill; 

		/**
		 * @var int
		 * @Column(name="Rechnung_betrag_bez", type="integer", length=10, nullable=false) 
		 * 
		 * ##FormLabel  Rechnung Betrag Bez 
		 * ##FormFieldHint <span class='pz-hint'>Rechnung_betrag_bez</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Rechnung_betrag_bez; 

		/**
		 * @var string
		 * @Column(name="Rechnung_konditionen", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Rechnung Konditionen 
		 * ##FormFieldHint <span class='pz-hint'>Rechnung_konditionen</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Rechnung_konditionen; 

		/**
		 * @var string
		 * @Column(name="Rechnung_dank", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Rechnung Dank 
		 * ##FormFieldHint <span class='pz-hint'>Rechnung_dank</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Rechnung_dank; 

		/**
		 * @var string
		 * @Column(name="Rechnung_bemerkungen", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Rechnung Bemerkungen 
		 * ##FormFieldHint <span class='pz-hint'>Rechnung_bemerkungen</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Rechnung_bemerkungen; 

		/**
		 * @var int
		 * @Column(name="Rechnung_ps_id", type="smallint", length=3, nullable=false) 
		 * 
		 * ##FormLabel  Rechnung Ps Id 
		 * ##FormFieldHint <span class='pz-hint'>Rechnung_ps_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Rechnung_ps_id; 

		/**
		 * @var string
		 * @Column(name="Rechnung_listing", type="text", nullable=false) 
		 * 
		 * ##FormLabel  Rechnung Listing 
		 * ##FormFieldHint <span class='pz-hint'>Rechnung_listing</span>
		 * ##FormInputType textarea
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy HTML 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\EditorEnhanced
		 */
		protected $Rechnung_listing;
		
		
		
		/**
		 * @var array
		 */
		protected ?array $billPosts       = [];
		
		/**
		 * @var array
		 */
		protected ?array $billBHJournals  = [];
		
		/**
		 * @var \App\Entity\Rechnung
		 */
		protected static $instance;
		
		
		public function __construct(){
			$this->Rechnung_Datum_open  = new \DateTime();
			$this->Rechnung_Datum_bill  = new \DateTime();
			$this->Rechnung_Datum_bez   = new \DateTime();
			$this->Rechnung_nummer      = 0;
			$this->Rechnung_BHNr_bez    = 0;
			$this->Rechnung_betrag_bill = 0;
			$this->Rechnung_betrag_bez  = 0;
			$this->Rechnung_ps_id       = 0;
			$this->Rechnung_status      = 1;
			$this->Rechnung_konditionen = "Bitte vermerken Sie bei der online Zahlung die Rechnungsnummer, welche auf der Rechnung bzw. im Feld Zahlungszweck des Einzahlungsscheins steht<br><br>Betrag inkl. 2.5% Mehrwertsteuer. Zahlbar rein netto innert 14 Tagen";
			$this->Rechnung_dank        = "Mit bestem Dank für den Auftrag!";
			$this->Rechnung_bemerkungen = "Besten Dank!";
			$this->Rechnung_listing     = " ";
			$this->initializeEntityBank();
			static::$instance = $this;
		}


		public function getRechnungId() {
			return $this->Rechnung_id;
		}

		public function getRechnungNummer() {
			return $this->Rechnung_nummer;
		}

		public function getRechnungStatus() {
			return $this->Rechnung_status;
		}

		public function getRechnungDatumOpen() {
			return $this->Rechnung_Datum_open;
		}

		public function getRechnungDatumBill() {
			return $this->Rechnung_Datum_bill;
		}

		public function getRechnungDatumBez() {
			return $this->Rechnung_Datum_bez;
		}

		public function getRechnungBHNrBez() {
			return $this->Rechnung_BHNr_bez;
		}

		public function getRechnungKunde() {
			return $this->Rechnung_kunde;
		}

		public function getRechnungBetragBill() {
			return $this->Rechnung_betrag_bill;
		}

		public function getRechnungBetragBez() {
			return $this->Rechnung_betrag_bez;
		}

		public function getRechnungKonditionen() {
			return $this->Rechnung_konditionen;
		}

		public function getRechnungDank() {
			return $this->Rechnung_dank;
		}

		public function getRechnungBemerkungen() {
			return $this->Rechnung_bemerkungen;
		}

		public function getRechnungPsId() {
			return $this->Rechnung_ps_id;
		}

		public function getRechnungListing() {
			return $this->Rechnung_listing;
		}
		
		/**
		 * @return array
		 */
		public function getBillPosts(): ?array {
			return $this->billPosts;
		}
		
		/**
		 * @return array
		 */
		public function getBillBHJournals(): ?array {
			return $this->billBHJournals;
		}
		


		public function setRechnungId($Rechnung_id) {
			$this->Rechnung_id = $Rechnung_id;
			return $this;
		}

		public function setRechnungNummer($Rechnung_nummer) {
			$this->Rechnung_nummer = $Rechnung_nummer;
			return $this;
		}

		public function setRechnungStatus($Rechnung_status) {
			$this->Rechnung_status = $Rechnung_status;
			return $this;
		}

		public function setRechnungDatumOpen($Rechnung_Datum_open) {
			$this->Rechnung_Datum_open = $Rechnung_Datum_open;
			return $this;
		}

		public function setRechnungDatumBill($Rechnung_Datum_bill) {
			$this->Rechnung_Datum_bill = $Rechnung_Datum_bill;
			return $this;
		}

		public function setRechnungDatumBez($Rechnung_Datum_bez) {
			$this->Rechnung_Datum_bez = $Rechnung_Datum_bez;
			return $this;
		}

		public function setRechnungBHNrBez($Rechnung_BHNr_bez) {
			$this->Rechnung_BHNr_bez = $Rechnung_BHNr_bez;
			return $this;
		}

		public function setRechnungKunde($Rechnung_kunde) {
			$this->Rechnung_kunde = $Rechnung_kunde;
			return $this;
		}

		public function setRechnungBetragBill($Rechnung_betrag_bill) {
			$this->Rechnung_betrag_bill = $Rechnung_betrag_bill;
			return $this;
		}

		public function setRechnungBetragBez($Rechnung_betrag_bez) {
			$this->Rechnung_betrag_bez = $Rechnung_betrag_bez;
			return $this;
		}

		public function setRechnungKonditionen($Rechnung_konditionen) {
			$this->Rechnung_konditionen = $Rechnung_konditionen;
			return $this;
		}

		public function setRechnungDank($Rechnung_dank) {
			$this->Rechnung_dank = $Rechnung_dank;
			return $this;
		}

		public function setRechnungBemerkungen($Rechnung_bemerkungen) {
			$this->Rechnung_bemerkungen = $Rechnung_bemerkungen;
			return $this;
		}

		public function setRechnungPsId($Rechnung_ps_id) {
			$this->Rechnung_ps_id = $Rechnung_ps_id;
			return $this;
		}

		public function setRechnungListing($Rechnung_listing) {
			$this->Rechnung_listing = $Rechnung_listing;
			return $this;
		}
		
		/**
		 * @param array $billPosts
		 *
		 * @return Rechnung
		 */
		public function setBillPosts( ?array $billPosts ): Rechnung {
			$this->billPosts = $billPosts;
			
			return $this;
		}
		
		/**
		 * @param array $billBHJournals
		 *
		 * @return Rechnung
		 */
		public function setBillBHJournals( ?array $billBHJournals ): Rechnung {
			$this->billBHJournals = $billBHJournals;
			
			return $this;
		}




	} 
