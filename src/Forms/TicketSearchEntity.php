<?php 

	namespace App\Forms;

	use App\Helpers\Date\RequestBridge;
	use Doctrine\ORM\EntityManagerInterface;
	use App\Helpers\Traits\EntityFieldMapperTrait;
	use App\Helpers\Traits\FormObjectLexer;

	/**
	 * TicketSearchEntity
	 **/
	class TicketSearchEntity {
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
		 * @var string
		 *
		 * ##FormLabel Ticket
		 * ##FormFieldHint <span class='pz-hint'>Ticket</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormPlaceholder Ticket Title here, please...
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $ticketTitle;
		
		/**
		 * @var int
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
		protected $client;
		
		/**
		 * @var int
		 *
		 * --FormLabel Geschäftskunde
		 * --FormFieldHint <span class='pz-hint'>Geschäftskunde</span>
		 * --FormInputType number
		 * --FormInputRequired 0
		 * --FormAddLabel 1
		 * --FormUseLabel 1
		 * --FormPlaceholder Geschäftskunde
		 * --FormInputOptions App\Forms\TicketArchiveEntity::fetchCompanyClientsAsOptions
		 * --FormValidationStrategy MISC
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		# protected $businessClient;
		
		/**
		 * @var int
		 *
		 * --FormLabel Privatkundin
		 * --FormFieldHint <span class='pz-hint'>Privatkundin</span>
		 * --FormInputType number
		 * --FormInputRequired 0
		 * --FormAddLabel 1
		 * --FormUseLabel 1
		 * --FormPlaceholder Privatkundin
		 * --FormInputOptions App\Forms\TicketArchiveEntity::fetchPrivateClientsAsOptions
		 * --FormValidationStrategy MISC
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		# protected $privateClient;
		
		/**
		 * @var int
		 *
		 * ##FormLabel Zuständig
		 * ##FormFieldHint <span class='pz-hint'>Zuständige Filiale fürs Ticket.</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormPlaceholder Zuständig Filiale auswählen
		 * ##FormInputOptions App\Forms\TicketArchiveEntity::fetchDepartmentsAsOptions
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $department;
		
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
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $ticket_opener;
		
		/**
		 * @var \DateTime
		 * ##FormLabel Anfangstermin
		 * ##FormFieldHint <span class='pz-hint'>Anfangstermin</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0
		 * ##FormPlaceholder 01.01.1970
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy DATE
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $startDate;
		
		/**
		 * @var \DateTime
		 * ##FormLabel Endtermin
		 * ##FormFieldHint <span class='pz-hint'>Endtermin</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0
		 * ##FormPlaceholder 01.01.1970
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy DATE
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $endDate;
		
		/**
		 * @var int
		 *
		 * ##FormLabel Typ
		 * ##FormFieldHint <span class='pz-hint'>Tickettyp</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormPlaceholder Typ
		 * ##FormInputOptions App\Forms\TicketArchiveEntity::fetchTicketTypesAsOptions
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $type;
		
		/**
		 * @var int
		 *
		 * --FormLabel Ticket Priorität
		 * --FormFieldHint <span class='pz-hint'>Ticket Priorität</span>
		 * --FormInputType number
		 * --FormInputRequired 0
		 * --FormAddLabel 1
		 * --FormUseLabel 1
		 * --FormPlaceholder Priorität
		 * --FormInputOptions App\Forms\TicketArchiveEntity::fetchTicketPrioritiesAsOptions
		 * --FormValidationStrategy NUM
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $priority;
		
		/**
		 * @var int
		 *
		 * ##FormLabel Status
		 * ##FormFieldHint <span class='pz-hint'>Ticket Status</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormPlaceholder Status
		 * ##FormInputOptions App\Forms\TicketArchiveEntity::fetchTicketStatusAsOptions
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $status;
		
		
		/**
		 * @var int
		 *
		 * ##FormLabel Wissens-DB
		 * ##FormFieldHint <span class='pz-hint'>Wissensdatenbank-Eintrag</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormPlaceholder Wissensdatenbank-Eintrag auswählen
		 * ##FormInputOptions App\Forms\TicketManagementEntity::fetchKnowledgeDataAsOptions
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $knowledgeBaseID;
		
		/**
		 * -- var string
		 *
		 * --FormLabel Ticketeintrag
		 * --FormFieldHint <span class='pz-hint'>Ticketeintrag</span>
		 * --FormInputType number
		 * --FormInputRequired 0
		 * --FormInputKey sales_search
		 * --FormAddLabel 1
		 * --FormUseLabel 1
		 * --FormPlaceholder Ticketeintrag
		 * --FormValidationStrategy NUM 
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Editor
		 */
		# protected $ticketEntry;
		
		
		/**
		 * @var \App\Forms\TicketSearchEntity
		 */
		protected static $instance;
		
		
		public function __construct(){
			global $kernel;
			# $entityManager      = $kernel->getContainer()->get('doctrine.orm.entity_manager');
			$firstDayOfDisMonth = date('Y-m') . "-01";
			$this->startDate    = new \DateTime($firstDayOfDisMonth);
			$this->endDate      = new \DateTime();
			$melSession         = $kernel->getContainer()->get('session')->get(RequestBridge::SessionNameSpace);
			
			if(isset($melSession['department'])){
				$this->department = $melSession['department'];
			}
			static::$instance = $this;
			$this->initializeEntityBank();
		}
		
		
		
		/**
		 * @return int
		 */
		public function getClient() {
			return $this->client;
		}
		
		/**
		 * @return \DateTime
		 */
		public function getStartDate() {
			return $this->startDate;
		}
		
		/**
		 * @return \DateTime
		 */
		public function getEndDate() {
			return $this->endDate;
		}
		
		/**
		 * @return int
		 */
		public function getDepartment() {
			return $this->department;
		}
		
		/**
		 * @return string
		 */
		public function getTicketTitle() {
			return $this->ticketTitle;
		}
		
		/**
		 * @return int
		 */
		public function getType() {
			return $this->type;
		}
		
		/**
		 * @return int
		 */
		public function getPriority() {
			return $this->priority;
		}
		
		/**
		 * @return int
		 */
		public function getStatus(){
			return $this->status;
		}
		
		/**
		 * @return int
		 */
		public function getKnowledgeBaseID(){
			return $this->knowledgeBaseID;
		}
		
		/**
		 * @return int
		 */
		public function getTicketOpener() {
			return $this->ticket_opener;
		}
		
		/**
		 * @param int $client
		 *
		 * @return TicketSearchEntity
		 */
		public function setClient( $client ): TicketSearchEntity {
			$this->client = $client;
			
			return $this;
		}
		
		/**
		 * @param \DateTime $startDate
		 *
		 * @return TicketSearchEntity
		 */
		public function setStartDate( $startDate ): TicketSearchEntity {
			$this->startDate = $startDate;
			
			return $this;
		}
		
		/**
		 * @param \DateTime $endDate
		 *
		 * @return TicketSearchEntity
		 */
		public function setEndDate( $endDate ): TicketSearchEntity {
			$this->endDate = $endDate;
			
			return $this;
		}
		
		/**
		 * @param int $department
		 *
		 * @return TicketSearchEntity
		 */
		public function setDepartment($department ): TicketSearchEntity {
			$this->department = $department;
			
			return $this;
		}
		
		/**
		 * @param string $ticketTitle
		 *
		 * @return TicketSearchEntity
		 */
		public function setTicketTitle( $ticketTitle ): TicketSearchEntity {
			$this->ticketTitle = $ticketTitle;
			
			return $this;
		}
		
		/**
		 * @param int $type
		 *
		 * @return TicketSearchEntity
		 */
		public function setType( $type ): TicketSearchEntity {
			$this->type = $type;
			
			return $this;
		}
		
		/**
		 * @param int $priority
		 *
		 * @return TicketSearchEntity
		 */
		public function setPriority( $priority ): TicketSearchEntity {
			$this->priority = $priority;
			
			return $this;
		}
		
		/**
		 * @param int $status
		 *
		 * @return TicketSearchEntity
		 */
		public function setStatus( $status ): TicketSearchEntity {
			$this->status = $status;
			
			return $this;
		}
		
		/**
		 * @param int $knowledgeBaseID
		 *
		 * @return TicketSearchEntity
		 */
		public function setKnowledgeBaseID( $knowledgeBaseID ): TicketSearchEntity {
			$this->knowledgeBaseID = $knowledgeBaseID;
			
			return $this;
		}
		
		/**
		 * @param int $ticket_opener
		 *
		 * @return TicketSearchEntity
		 */
		public function setTicketOpener( $ticket_opener ): TicketSearchEntity {
			$this->ticket_opener = $ticket_opener;
			
			return $this;
		}
		
		
		
	}
	