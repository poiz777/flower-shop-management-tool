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
	 * Tickets
	 * @Table(name="tickets")
	 * @Entity(repositoryClass="App\Entity\Repo\TicketsRepo")
	 **/
	class Tickets {
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
		 * @Id Tickets
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel Ticket Id 
		 * ##FormFieldHint <span class='pz-hint'>ticket_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $ticket_id;

		/**
		 * @var int
		 * @Column(name="ticket_knowledgeID", type="smallint", length=6, nullable=false) 
		 * 
		 * ##FormLabel Ticket Knowledge I D 
		 * ##FormFieldHint <span class='pz-hint'>ticket_knowledgeID</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $ticket_knowledgeID;

		/**
		 * @var int
		 * @Column(name="ticket_kunde", type="smallint", length=6, nullable=false) 
		 * 
		 * ##FormLabel Ticket Kunde 
		 * ##FormFieldHint <span class='pz-hint'>ticket_kunde</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $ticket_kunde;

		/**
		 * @var int
		 * @Column(name="ticket_MA_verantwortung", type="smallint", length=6, nullable=false) 
		 * 
		 * ##FormLabel Ticket M A Verantwortung 
		 * ##FormFieldHint <span class='pz-hint'>ticket_MA_verantwortung</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $ticket_MA_verantwortung;
		
		/**
		 * @var int
		 *
		 * @Column(name="ticket_opener", type="smallint", length=6, nullable=false)
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
		 * @var string
		 * @Column(name="ticket_header", type="string", length=100, nullable=false) 
		 * 
		 * ##FormLabel Ticket Header 
		 * ##FormFieldHint <span class='pz-hint'>ticket_header</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $ticket_header;
		
		/**
		 * @var \DateTime
		 * @Column(name="ticket_eroeffnungstermin", type="date", nullable=false, options={"default":"1970-01-01"})
		 * 
		 * ##FormLabel Ticket Eroeffnungstermin 
		 * ##FormFieldHint <span class='pz-hint'>ticket_eroeffnungstermin</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy DATETIME 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $ticket_eroeffnungstermin;

		/**
		 * @var \DateTime
		 * @Column(name="ticket_endtermin", type="date", nullable=false, options={"default":"1970-01-01"})
		 * 
		 * ##FormLabel Ticket Endtermin 
		 * ##FormFieldHint <span class='pz-hint'>ticket_endtermin</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy DATETIME 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $ticket_endtermin;

		/**
		 * @var string
		 * @Column(name="ticket_zeit", type="string", nullable=false, options={"default":"00:00:00"})
		 * 
		 * ##FormLabel Ticket Zeit 
		 * ##FormFieldHint <span class='pz-hint'>ticket_zeit</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Time
		 */
		protected $ticket_zeit;

		/**
		 * @var int
		 * @Column(name="ticket_typ", type="smallint", length=6, nullable=false) 
		 * 
		 * ##FormLabel Ticket Typ 
		 * ##FormFieldHint <span class='pz-hint'>ticket_typ</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $ticket_typ;

		/**
		 * @var int
		 * @Column(name="ticket_prio", type="smallint", length=6, nullable=false) 
		 * 
		 * ##FormLabel Ticket Prio 
		 * ##FormFieldHint <span class='pz-hint'>ticket_prio</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $ticket_prio;

		/**
		 * @var int
		 * @Column(name="ticket_status", type="smallint", length=6, nullable=false) 
		 * 
		 * ##FormLabel Ticket Status 
		 * ##FormFieldHint <span class='pz-hint'>ticket_status</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $ticket_status;

		/**
		 * @var int
		 * @Column(name="ticket_gelesen", type="smallint", length=2, nullable=false) 
		 * 
		 * ##FormLabel Ticket Gelesen 
		 * ##FormFieldHint <span class='pz-hint'>ticket_gelesen</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $ticket_gelesen;
		
		
		
		/**
		 * @var \App\Entity\Ticketeintrag[]
		 */
		private $ticketPosts;
		
		/**§
		 * @var \App\Entity\Ticketeintrag[]
		 */
		private $children;
		
		/**
		 * @var int
		 */
		private $ticketsCount;
		
		/**
		 * @var int
		 */
		private $ticketPostsCount;
		
		/**
		 * @var array
		 */
		private $client;
		
		/**
		 * @var string
		 */
		private $ticketDueTime;
		
		/**
		 * @var string
		 */
		private $ticketDueHour;
		
		/**
		 * @var \App\Entity\Tickets
		 */
		protected static $instance;

		public function __construct(){
			global $kernel;
			static::$instance = $this;
			$session          = $kernel->getContainer()->get('session');
			$melSession       = $session->get(RequestBridge::SessionNameSpace);
			$this->ticket_eroeffnungstermin = new \DateTime();
			$this->ticket_MA_verantwortung  = isset($melSession['department']) ? $melSession['department'] : $this->ticket_MA_verantwortung;
			
			$this->initializeEntityBank();
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

		public function getTicketGelesen() {
			return $this->ticket_gelesen;
		}
		
		/**
		 * @return int
		 */
		public function getTicketOpener() {
			return $this->ticket_opener;
		}
		
		
		
		
		
		
		
		/**
		 * @param int $ticket_opener
		 * @return \App\Entity\Tickets
		 */
		public function setTicketOpener($ticket_opener) {
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

		public function setTicketGelesen($ticket_gelesen) {
			$this->ticket_gelesen = $ticket_gelesen;
			return $this;
		}
		
		
		
		
		
		
		/**
		 * @return \App\Entity\Ticketeintrag[]
		 */
		public function getTicketPosts() {
			return $this->ticketPosts;
		}
		
		/**
		 * @return \App\Entity\Ticketeintrag[]
		 */
		public function getChildren(){
			return $this->children;
		}
		
		/**
		 * @return int
		 */
		public function getTicketsCount() {
			return $this->ticketsCount;
		}
		
		/**
		 * @return int
		 */
		public function getTicketPostsCount() {
			return $this->ticketPostsCount;
		}
		
		/**
		 * @return array
		 */
		public function getClient(){
			return $this->client;
		}
		
		/**
		 * @return string
		 */
		public function getTicketDueTime() {
			return $this->ticketDueTime;
		}
		
		/**
		 * @return string
		 */
		public function getTicketDueHour(){
			return $this->ticketDueHour;
		}
		
		
		
		
		/**
		 * @param \App\Entity\Ticketeintrag[] $ticketPosts
		 *
		 * @return Tickets
		 */
		public function setTicketPosts( $ticketPosts ): Tickets {
			$this->ticketPosts = $ticketPosts;
			
			return $this;
		}
		
		/**
		 * @param \App\Entity\Ticketeintrag[] $children
		 *
		 * @return Tickets
		 */
		public function setChildren( $children ): Tickets {
			$this->children = $children;
			
			return $this;
		}
		
		/**
		 * @param int $ticketsCount
		 *
		 * @return Tickets
		 */
		public function setTicketsCount( $ticketsCount ): Tickets {
			$this->ticketsCount = $ticketsCount;
			
			return $this;
		}
		
		/**
		 * @param int $ticketPostsCount
		 *
		 * @return Tickets
		 */
		public function setTicketPostsCount( $ticketPostsCount ): Tickets {
			$this->ticketPostsCount = $ticketPostsCount;
			
			return $this;
		}
		
		/**
		 * @param array $client
		 *
		 * @return Tickets
		 */
		public function setClient( $client ): Tickets {
			$this->client = $client;
			
			return $this;
		}
		
		/**
		 * @param string $ticketDueTime
		 *
		 * @return Tickets
		 */
		public function setTicketDueTime( $ticketDueTime ): Tickets {
			$this->ticketDueTime = $ticketDueTime;
			
			return $this;
		}
		
		/**
		 * @param string $ticketDueHour
		 *
		 * @return Tickets
		 */
		public function setTicketDueHour( $ticketDueHour ): Tickets {
			$this->ticketDueHour = $ticketDueHour;
			
			return $this;
		}
		
		
		



	} 
