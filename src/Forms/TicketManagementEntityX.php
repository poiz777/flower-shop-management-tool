<?php 

	namespace App\Forms;

	use App\Entity\KnowledgeEintrag;
	use App\Entity\KnowledgeKategorie;
	use App\Entity\Personen;
	use App\Entity\TicketPrio;
	use App\Entity\TicketStatus;
	use App\Entity\TicketTyp;
	use App\Helpers\Date\RequestBridge;
	use Doctrine\ORM\Mapping\Column;
	use Doctrine\ORM\EntityManagerInterface;
	use App\Helpers\Traits\EntityFieldMapperTrait;
	use App\Helpers\Traits\FormObjectLexer;

	/**
	 * TicketManagementEntityX
	 **/
	class TicketManagementEntityX {
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
		 * ##FormLabel Ticket Id
		 * ##FormFieldHint <span class='pz-hint'>ticket_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormPlaceholder 0
		 * ##FormUseLabel 0
		 * ##FormAddLabel 0
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy NONE
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Hidden
		 */
		protected $ticket_id;
		
		/**
		 * @var string
		 *
		 * ##FormLabel Betreff
		 * ##FormFieldHint <span class='pz-hint'>Kurztitel des Tickets.</span>
		 * ##FormInputType text
		 * ##FormInputRequired 1
		 * ##FormPlaceholder Kurztitel des Tickets
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy NON_EMPTY
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $ticket_header;
		
		/**
		 * @var int
		 *
		 *  REVERT BACK TO THIS ONCE THE DROP-DOWN CAN FILTER BY DATA-ATTRIBUTES
		 *  USE THIS AS A REPLACEMENT FOR THE 2 DISTINCT CLIENT FIELD: `privateClient` & `businessClient`
		 *  AT WHICH POINT YOU SHOULD DELETE AND NEVER SEE THIS NOTICE...
		 *
		 * ##FormLabel Kunde
		 * ##FormFieldHint <span class='pz-hint'>Privat- oder Geschäftskunde</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormPlaceholder Kunde auswählen
		 * ##FormInputOptions App\Forms\TicketArchiveEntity::fetchCompanyAndPrivateClientsAsOptions
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $ticket_kunde=43;
		
		/**
		 * @var int
		 *
		 * ##FormLabel Zuständig
		 * ##FormFieldHint <span class='pz-hint'>Die Filiale, zu dem dieses Ticket gehört.</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder Zuständige Filiale wählen
		 * --FormInputOptions App\Forms\TicketManagementEntityX::fetchMelanieFlowerShops
		 * ##FormInputOptions App\Forms\TicketArchiveEntity::fetchDepartmentsAsOptions
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $ticket_MA_verantwortung;
		
		/**
		 * @var int
		 *
		 * --FormLabel Ticketbesitzer
		 * ##FormLabel Ticket-Autor
		 * ##FormFieldHint <span class='pz-hint'>Wer hat dieses Ticket erstellt?</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormPlaceholder Ticket-Autor/Besitzer wählen
		 * ##FormInputOptions App\Entity\Arbeitszeit::fetchCoWorkers
		 * ##FormValidationStrategy NUM
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $ticket_opener;

		/**
		 * @var \DateTime
		 * 
		 * --FormLabel Ticket Eroeffnungstermin 
		 * --FormFieldHint <span class='pz-hint'>ticket_eroeffnungstermin</span>
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
		protected $ticket_zeit;

		/**
		 * @var int
		 * 
		 * ##FormLabel Typ
		 * ##FormFieldHint <span class='pz-hint'>Tickettyp</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder Tickettyp auswählen
		 * ##FormInputOptions App\Forms\TicketManagementEntityX::fetchTicketTypesAsOptions
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $ticket_typ = 1;

		/**
		 * @var int
		 * 
		 * --FormLabel Ticket gelesen?
		 * --FormFieldHint <span class='pz-hint'>Ticket schon gelesen?</span>
		 * --FormInputType number
		 * --FormInputRequired 0 
		 * --FormPlaceholder Bitte wählen
		 * --FormInputOptions App\Forms\TicketManagementEntityX::fetchTicketYesNoOptions
		 * --FormValidationStrategy MISC
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $ticket_gelesen=1;
		
		/**
		 * @var int
		 *
		 * --FormLabel Ticket Priorität
		 * --FormFieldHint <span class='pz-hint'>Ticket Priorität</span>
		 * --FormInputType number
		 * --FormInputRequired 0
		 * --FormPlaceholder Ticket Priorität wählen
		 * --FormInputOptions App\Forms\TicketManagementEntityX::fetchTicketPrioritiesAsOptions
		 * --FormValidationStrategy NUM
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $ticket_prio=1;

		/**
		 * @var int
		 * 
		 * ##FormLabel Status
		 * ##FormFieldHint <span class='pz-hint'>Ticket Status</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder Ticket Status wählen
		 * ##FormInputOptions App\Forms\TicketManagementEntityX::fetchTicketStatusAsOptions
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $ticket_status=1;
		
		
		/**
		 * @var int
		 *
		 * ##FormLabel Wissensdatenbank
		 * ##FormFieldHint <span class='pz-hint'>Wissensdatenbank-Eintrag</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormPlaceholder Wissensdatenbank-Eintrag auswählen
		 * ##FormInputOptions App\Forms\TicketManagementEntityX::fetchKnowledgeDataAsOptions
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $ticket_knowledgeID;
		
		/**
		 * #var string
		 *
		 * --FormLabel TicketBeitrag
		 * --FormFieldHint <span class='pz-hint'>Beitrag für dieses Ticket erstellen</span>
		 * --FormInputType text
		 * --FormInputRequired 1
		 * --FormPlaceholder Beispiel
		 * --FormInputOptions NULL
		 * --FormValidationStrategy NON_EMPTY
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\EditorEnhanced
		 */
		 protected $ticketeintrag_eintrag;
		
		/**
		 * @var \App\Forms\TicketManagementEntityX
		 */
		protected static $instance;


		public function __construct(){
			global $kernel;
			$session        = $kernel->getContainer()->get('session');
			$melSession     = $session->get(RequestBridge::SessionNameSpace);
			$this->ticket_zeit              = date('H:i');
			$this->ticket_eroeffnungstermin = new \DateTime();
			$this->ticket_endtermin         = new \DateTime();
			$this->ticket_MA_verantwortung  = isset($melSession['department']) ? $melSession['department'] : $this->ticket_MA_verantwortung;
			$this->initializeEntityBank();
			static::$instance = $this;
		}


		public function getTicketId() {
			return $this->ticket_id;
		}

		public function getTicketKnowledgeID() {
			return $this->ticket_knowledgeID;
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
		 * @return int
		 */
		public function getBusinessClient() {
			return $this->businessClient;
		}
		
		/**
		 * @return int
		 */
		public function getPrivateClient() {
			return $this->privateClient;
		}
		
		/**
		 * @return string
		 */
		public function getTicketeintragEintrag() {
			return $this->ticketeintrag_eintrag;
		}
		
		/**
		 * @return int
		 */
		public function getTicketOpener() {
			return $this->ticket_opener;
		}
		
		
		public function getTicketGelesen() {
			return $this->ticket_gelesen;
		}
		
		
		
		
		
		
		/**
		 * @param int $ticket_opener
		 *
		 * @return TicketManagementEntityX
		 */
		public function setTicketOpener( $ticket_opener ): TicketManagementEntityX {
			$this->ticket_opener = $ticket_opener;
			
			return $this;
		}

		public function setTicketId($ticket_id) {
			$this->ticket_id = $ticket_id;
			return $this;
		}

		public function setTicketKnowledgeID($ticket_knowledgeID) {
			$this->ticket_knowledgeID = $ticket_knowledgeID;
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
		 * @param int $businessClient
		 *
		 * @return TicketManagementEntityX
		 */
		public function setBusinessClient($businessClient ): TicketManagementEntityX {
			$this->businessClient = $businessClient;
			return $this;
		}
		
		/**
		 * @param int $privateClient
		 *
		 * @return TicketManagementEntityX
		 */
		public function setPrivateClient($privateClient ): TicketManagementEntityX {
			$this->privateClient = $privateClient;
			return $this;
		}
		
		/**
		 * @param string $ticketeintrag_eintrag
		 *
		 * @return TicketManagementEntityX
		 */
		public function setTicketeintragEintrag( $ticketeintrag_eintrag ): TicketManagementEntityX {
			$this->ticketeintrag_eintrag = $ticketeintrag_eintrag;
			return $this;
		}
		
		public function setTicketGelesen($ticket_gelesen) {
			$this->ticket_gelesen = $ticket_gelesen;
			return $this;
		}
		
	}
	
	/*
	[
		'ticket_Betreff',
		'ticket_kundin_gk',
		'ticket_kundin_pk',
		'ticket_MA',
		'ticketschluss_tag',
		'ticketschluss_monat',
		'ticketschluss_jahr',
		'ticketschluss_stunde',
		'ticketschluss_minute',
		'ticket_Typ',
		'ticket_Prio',
		'ticket_Status',  // tickets_tbl
		'ticketeintrag',  // ticketeintrag_eintrag  tickets_tbl
	];
	*/