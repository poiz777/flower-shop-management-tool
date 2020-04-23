<?php 

	namespace App\Forms;

	use App\Entity\KnowledgeEintrag;
	use App\Entity\KnowledgeKategorie;
	use App\Entity\Personen;
	use App\Entity\TicketPrio;
	use App\Entity\TicketStatus;
	use App\Entity\TicketTyp;
	use Doctrine\ORM\Mapping\Column;
	use Doctrine\ORM\EntityManagerInterface;
	use App\Helpers\Traits\EntityFieldMapperTrait;
	use App\Helpers\Traits\FormObjectLexer;

	/**
	 * TicketArchiveEntity
	 **/
	class TicketArchiveEntity {
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
		 * --FormLabel Ticket Id 
		 * --FormFieldHint <span class='pz-hint'>ticket_id</span>
		 * --FormInputType number
		 * --FormInputRequired 0 
		 * --FormPlaceholder 0 
		 * --FormInputOptions NULL 
		 * --FormValidationStrategy NUM 
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $ticket_id;

		/**
		 * @var int
		 * ##FormLabel Kunde
		 * ##FormFieldHint <span class='pz-hint'>Kunde</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormPlaceholder Kunde(n) auswählen
		 * ##FormInputOptions App\Forms\TicketArchiveEntity::fetchCompanyAndPrivateClientsAsOptions
		 * ##FormValidationStrategy NUM
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $ticket_kunde;
		/**
		 * @var int
		 * 
		 * ##FormLabel Zuständig
		 * ##FormFieldHint <span class='pz-hint'>Die Filiale, zu dem dieses Ticket gehört.</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder Zuständige Filiale wählen
		 * ##FormInputOptions App\Forms\TicketArchiveEntity::fetchMelanieFlowerShops
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $ticket_MA_verantwortung; 

		/**
		 * @var string
		 * 
		 * ##FormLabel Betreff
		 * ##FormFieldHint <span class='pz-hint'>Kurztitel des Tickets.</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder Kurztitel des Tickets
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $ticket_header;

		/**
		 * @var string
		 *
		 * ##FormLabel Kundenvorname
		 * ##FormFieldHint <span class='pz-hint'>Kundenvorname</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0
		 * ##FormPlaceholderKundenvorname
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $firstName;
		
		/**
		 * @var string
		 *
		 * ##FormLabel Arbeitervorname
		 * ##FormFieldHint <span class='pz-hint'>Arbeitervorname</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0
		 * ##FormPlaceholder Arbeitervorname
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $workerFirstName;
		
		/**
		 * @var string
		 *
		 * ##FormLabel Kundenname
		 * ##FormFieldHint <span class='pz-hint'>Kundenname</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0
		 * ##FormPlaceholder Kundenname
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $lastName;
		
		/**
		 * @var string
		 *
		 * ##FormLabel Firma
		 * ##FormFieldHint <span class='pz-hint'>KundenFirma</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0
		 * ##FormPlaceholder Firma
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $company;

		/**
		 * @var \DateTime
		 * 
		 * --FormLabel Termin
		 * --FormFieldHint <span class='pz-hint'>Eroeffnungstermin</span>
		 * --FormInputType datetime
		 * --FormInputRequired 0 
		 * --FormPlaceholder 0 
		 * --FormInputOptions NULL 
		 * --FormValidationStrategy DATETIME 
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $ticket_eroeffnungstermin; 

		/**
		 * @var \DateTime
		 * 
		 * ##FormLabel Endtermin
		 * ##FormFieldHint <span class='pz-hint'>Ticket Endtermin</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy DATE
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $ticket_endtermin; 

		/**
		 * @var int
		 *
		 * ##FormLabel Ticket Zeit 
		 * ##FormFieldHint <span class='pz-hint'>Ticket Zeit</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder Ticket Zeit
		 * ##FormInputMin 00.00
		 * ##FormInputMax 23:00
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Time
		 */
		protected $ticket_zeit  = "00:00:00";

		/**
		 * @var int
		 * 
		 * ##FormLabel Typ
		 * ##FormFieldHint <span class='pz-hint'>Tickettyp</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder Tickettyp auswählen
		 * ##FormInputOptions App\Forms\TicketArchiveEntity::fetchTicketTypesAsOptions
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $ticket_typ; 

		/**
		 * @var int
		 * 
		 * ##FormLabel Ticket Priorität
		 * ##FormFieldHint <span class='pz-hint'>Ticket Priorität</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder Ticket Priorität wählen
		 * ##FormInputOptions App\Forms\TicketArchiveEntity::fetchTicketPrioritiesAsOptions
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $ticket_prio; 

		/**
		 * @var int
		 * 
		 * ##FormLabel Status
		 * ##FormFieldHint <span class='pz-hint'>Ticket Status</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder Ticket Status wählen
		 * ##FormInputOptions App\Forms\TicketArchiveEntity::fetchTicketStatusAsOptions
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $ticket_status;
		
		/** @var array */
		protected $ticketClient;
		
		/**
		 * @var \App\Forms\TicketArchiveEntity
		 */
		protected static $instance;
		
		/**
		 * @var string
		 *
		 */
		protected $fullName;

		public function __construct(){
			$this->ticket_eroeffnungstermin = new \DateTime();
			$this->initializeEntityBank();
			static::$instance = $this;
		}


		public function getTicketId() {
			return $this->ticket_id;
		}

		public function getTicketKunde() {
			return $this->ticket_kunde;
		}

		public function getTicketMAVerantwortung() {
			return $this->ticket_MA_verantwortung;
		}

		public function getTicketHeader() {
			return $this->ticket_header;
		}

		public function getTicketEroeffnungstermin() {
			return $this->ticket_eroeffnungstermin;
		}

		public function getTicketEndtermin() {
			return $this->ticket_endtermin;
		}

		public function getTicketZeit() {
			return $this->ticket_zeit;
		}

		public function getTicketTyp() {
			return $this->ticket_typ;
		}

		public function getTicketPrio() {
			return $this->ticket_prio;
		}

		public function getTicketStatus() {
			return $this->ticket_status;
		}
		
		/**
		 * @return string
		 */
		public function getFirstName() {
			return $this->firstName;
		}
		
		/**
		 * @return string
		 */
		public function getWorkerFirstName() {
			return $this->workerFirstName;
		}
		
		/**
		 * @return string
		 */
		public function getLastName() {
			return $this->lastName;
		}
		
		/**
		 * @return string
		 */
		public function getFullName() {
			return $this->fullName;
		}
		
		/**
		 * @return string
		 */
		public function getCompany() {
			return $this->company;
		}
		
		/**
		 * @return array
		 */
		public function getTicketClient() {
			return $this->ticketClient;
		}
		
		
		
		
		public function setTicketId($ticket_id) {
			$this->ticket_id = $ticket_id;
			return $this;
		}

		public function setTicketKunde($ticket_kunde) {
			$this->ticket_kunde = $ticket_kunde;
			return $this;
		}

		public function setTicketMAVerantwortung($ticket_MA_verantwortung) {
			$this->ticket_MA_verantwortung = $ticket_MA_verantwortung;
			return $this;
		}

		public function setTicketHeader($ticket_header) {
			$this->ticket_header = $ticket_header;
			return $this;
		}

		public function setTicketEroeffnungstermin($ticket_eroeffnungstermin) {
			$this->ticket_eroeffnungstermin = $ticket_eroeffnungstermin;
			return $this;
		}

		public function setTicketEndtermin($ticket_endtermin) {
			$this->ticket_endtermin = $ticket_endtermin;
			return $this;
		}

		public function setTicketZeit($ticket_zeit) {
			$this->ticket_zeit = $ticket_zeit;
			return $this;
		}

		public function setTicketTyp($ticket_typ) {
			$this->ticket_typ = $ticket_typ;
			return $this;
		}

		public function setTicketPrio($ticket_prio) {
			$this->ticket_prio = $ticket_prio;
			return $this;
		}

		public function setTicketStatus($ticket_status) {
			$this->ticket_status = $ticket_status;
			return $this;
		}
		
		/**
		 * @param string $firstName
		 *
		 * @return TicketArchiveEntity
		 */
		public function setFirstName( $firstName ): TicketArchiveEntity {
			$this->firstName = $firstName;
			
			return $this;
		}
		
		/**
		 * @param string $workerFirstName
		 *
		 * @return TicketArchiveEntity
		 */
		public function setWorkerFirstName($workerFirstName ): TicketArchiveEntity {
			$this->workerFirstName = $workerFirstName;
			
			return $this;
		}
		
		/**
		 * @param string $lastName
		 *
		 * @return TicketArchiveEntity
		 */
		public function setLastName( $lastName ): TicketArchiveEntity {
			$this->lastName = $lastName;
			
			return $this;
		}
		
		/**
		 * @param string $fullName
		 *
		 * @return TicketArchiveEntity
		 */
		public function setFullName( $fullName ): TicketArchiveEntity {
			$this->fullName = (trim($this->company)) ? (
				trim($fullName) ? trim($fullName) . " -- {$this->company}" : $this->company
			) : trim($fullName);
			return $this;
		}
		
		/**
		 * @param string $company
		 *
		 * @return TicketArchiveEntity
		 */
		public function setCompany( $company ): TicketArchiveEntity {
			$this->company = $company;
			
			return $this;
		}
		
		/**
		 * @param array $ticketClient
		 *
		 * @return TicketArchiveEntity
		 */
		public function setTicketClient( $ticketClient ): TicketArchiveEntity {
			$this->ticketClient = $ticketClient;
			
			return $this;
		}
		
		
		
		
		
	}