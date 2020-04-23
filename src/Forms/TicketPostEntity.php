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
	 * TicketPostEntity
	 **/
	class TicketPostEntity {
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
		protected $ticketeintrag_id;
		
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
		protected $ticketeintrag_ticket_id;
		
		/**
		 * @var int
		 *
		 * --FormLabel Zuständig
		 * --FormFieldHint <span class='pz-hint'>Die Filiale, zu dem dieses Ticket gehört.</span>
		 * --FormInputType number
		 * --FormInputRequired 0
		 * --FormPlaceholder Zuständige Filiale wählen
		 * --FormInputOptions App\Forms\TicketPostEntity::fetchMelanieFlowerShops
		 * --FormInputOptions App\Forms\TicketArchiveEntity::fetchDepartmentsAsOptions
		 * --FormValidationStrategy NUM
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $ticket_MA_verantwortung;
		
		/**
		 * @var int
		 *
		 * --FormLabel Ticketbesitzer
		 * ##FormLabel Ticketpost-Autor
		 * ##FormFieldHint <span class='pz-hint'>Wer hat dieses Ticketpost erstellt?</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormPlaceholder Ticketpost-Autor/Besitzer wählen
		 * ##FormInputOptions App\Entity\Arbeitszeit::fetchCoWorkers
		 * ##FormValidationStrategy NUM
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $ticket_opener;
		
		/**
		 * @var string
		 *
		 * ##FormLabel TicketBeitrag
		 * ##FormFieldHint <span class='pz-hint'>Beitrag für dieses Ticket erstellen</span>
		 * ##FormInputType text
		 * ##FormInputRequired 1
		 * ##FormPlaceholder Beispiel
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy NON_EMPTY
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\EditorEnhanced
		 */
		protected $ticketeintrag_eintrag;

		/**
		 * @var \DateTime
		 * 
		 * --FormLabel Endtermin
		 * --FormFieldHint <span class='pz-hint'>Ticket Endtermin</span>
		 * --FormInputType datetime
		 * --FormInputRequired 0
		 * --FormPlaceholder 0
		 * --FormInputOptions NULL
		 * --FormValidationStrategy DATE
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $ticketeintrag_datum;
		
		
		/**
		 * @var \App\Forms\TicketPostEntity
		 */
		protected static $instance;


		public function __construct(){
			global $kernel;
			$session        = $kernel->getContainer()->get('session');
			$melSession     = $session->get(RequestBridge::SessionNameSpace);
			$this->ticketeintrag_datum      = new \DateTime();
			$this->ticket_MA_verantwortung  = isset($melSession['department']) ? $melSession['department'] : $this->ticket_MA_verantwortung;
			$this->initializeEntityBank();
			static::$instance = $this;
		}
		
		/**
		 * @return int
		 */
		public function getTicketeintragId() {
			return $this->ticketeintrag_id;
		}
		
		/**
		 * @return int
		 */
		public function getTicketeintragTicketId() {
			return $this->ticketeintrag_ticket_id;
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
		public function getTicketMAVerantwortung() {
			return $this->ticket_MA_verantwortung;
		}
		
		/**
		 * @return int
		 */
		public function getTicketOpener() {
			return $this->ticket_opener;
		}
		
		/**
		 * @return \DateTime
		 */
		public function getTicketeintragDatum(){
			return $this->ticketeintrag_datum;
		}
		
		
		
		
		
		
		
		
		/**
		 * @param int $ticketeintrag_id
		 *
		 * @return TicketPostEntity
		 */
		public function setTicketeintragId( $ticketeintrag_id ): TicketPostEntity {
			$this->ticketeintrag_id = $ticketeintrag_id;
			
			return $this;
		}
		
		/**
		 * @param int $ticketeintrag_ticket_id
		 *
		 * @return TicketPostEntity
		 */
		public function setTicketeintragTicketId( $ticketeintrag_ticket_id ): TicketPostEntity {
			$this->ticketeintrag_ticket_id = $ticketeintrag_ticket_id;
			
			return $this;
		}
		
		/**
		 * @param string $ticketeintrag_eintrag
		 *
		 * @return TicketPostEntity
		 */
		public function setTicketeintragEintrag( $ticketeintrag_eintrag ): TicketPostEntity {
			$this->ticketeintrag_eintrag = $ticketeintrag_eintrag;
			
			return $this;
		}
		
		/**
		 * @param int $ticket_MA_verantwortung
		 *
		 * @return TicketPostEntity
		 */
		public function setTicketMAVerantwortung( $ticket_MA_verantwortung ): TicketPostEntity {
			$this->ticket_MA_verantwortung = $ticket_MA_verantwortung;
			
			return $this;
		}
		
		/**
		 * @param int $ticket_opener
		 *
		 * @return TicketPostEntity
		 */
		public function setTicketOpener( $ticket_opener ): TicketPostEntity {
			$this->ticket_opener = $ticket_opener;
			
			return $this;
		}
		
		/**
		 * @param \DateTime $ticketeintrag_datum
		 *
		 * @return TicketPostEntity
		 */
		public function setTicketeintragDatum( $ticketeintrag_datum ): TicketPostEntity {
			$this->ticketeintrag_datum = $ticketeintrag_datum;
			
			return $this;
		}
		
		
		
		
	}