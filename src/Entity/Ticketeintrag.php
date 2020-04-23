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
	 * Ticketeintrag
	 * @Table(name="ticketeintrag")
	 * @Entity(repositoryClass="App\Entity\Repo\TicketeintragRepo")
	 **/
	class Ticketeintrag {
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
		 * @Id Ticketeintrag
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel Ticketeintrag Id 
		 * ##FormFieldHint <span class='pz-hint'>ticketeintrag_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $ticketeintrag_id; 

		/**
		 * @var int
		 * @Column(name="ticketeintrag_ticket_id", type="smallint", length=6, nullable=false) 
		 * 
		 * ##FormLabel Ticketeintrag Ticket Id 
		 * ##FormFieldHint <span class='pz-hint'>ticketeintrag_ticket_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $ticketeintrag_ticket_id; 

		/**
		 * @var int
		 * @Column(name="ticketeintrag_ersteller_id", type="smallint", length=6, nullable=false) 
		 * 
		 * ##FormLabel Ticketeintrag Ersteller Id 
		 * ##FormFieldHint <span class='pz-hint'>ticketeintrag_ersteller_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $ticketeintrag_ersteller_id;
		
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
		 * @var \DateTime
		 * @Column(name="ticketeintrag_datum", type="datetime", nullable=false)
		 * 
		 * ##FormLabel Ticketeintrag Datum 
		 * ##FormFieldHint <span class='pz-hint'>ticketeintrag_datum</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy DATETIME 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $ticketeintrag_datum; 

		/**
		 * @var string
		 * @Column(name="ticketeintrag_eintrag", type="string", length=4000, nullable=false) 
		 * 
		 * ##FormLabel Ticketeintrag Eintrag 
		 * ##FormFieldHint <span class='pz-hint'>ticketeintrag_eintrag</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $ticketeintrag_eintrag;
		
		
		/**
		 * @var \App\Entity\Tickets
		 */
		protected static $instance;


		public function __construct(){
			$this->ticketeintrag_datum  = new \DateTime();
			static::$instance           = $this;
			$this->initializeEntityBank();
			
		}


		public function getTicketeintragId() {
			return $this->ticketeintrag_id;
		}

		public function getTicketeintragTicketId() {
			return $this->ticketeintrag_ticket_id;
		}

		public function getTicketeintragErstellerId() {
			return $this->ticketeintrag_ersteller_id;
		}

		public function getTicketeintragDatum() {
			return $this->ticketeintrag_datum;
		}

		public function getTicketeintragEintrag() {
			return $this->ticketeintrag_eintrag;
		}
		
		public function getTicketOpener($ticketOpener) {
			return $this->ticket_opener;
		}


		public function setTicketeintragId($ticketeintrag_id) {
			$this->ticketeintrag_id = $ticketeintrag_id;
			return $this;
		}

		public function setTicketeintragTicketId($ticketeintrag_ticket_id) {
			$this->ticketeintrag_ticket_id = $ticketeintrag_ticket_id;
			return $this;
		}

		public function setTicketeintragErstellerId($ticketeintrag_ersteller_id) {
			$this->ticketeintrag_ersteller_id = $ticketeintrag_ersteller_id;
			return $this;
		}

		public function setTicketeintragDatum($ticketeintrag_datum) {
			$this->ticketeintrag_datum = $ticketeintrag_datum;
			return $this;
		}

		public function setTicketeintragEintrag($ticketeintrag_eintrag) {
			$this->ticketeintrag_eintrag = $ticketeintrag_eintrag;
			return $this;
		}

		public function setTicketOpener($ticketOpener) {
			$this->ticket_opener = $ticketOpener;
			return $this;
		}




	} 
