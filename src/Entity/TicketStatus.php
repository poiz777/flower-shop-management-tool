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
	 * TicketStatus
	 * @Table(name="ticket_status")
	 * @Entity(repositoryClass="App\Entity\Repo\TicketStatusRepo")
	 **/
	class TicketStatus { 

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
		 * @Id TicketStatus
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel Ticket Status Id 
		 * ##FormFieldHint <span class='pz-hint'>ticket_status_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $ticket_status_id; 

		/**
		 * @var string
		 * @Column(name="ticket_status_name", type="string", length=25, nullable=false) 
		 * 
		 * ##FormLabel Ticket Status Name 
		 * ##FormFieldHint <span class='pz-hint'>ticket_status_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $ticket_status_name; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getTicketStatusId() {
			return $this->ticket_status_id;
		}

		public function getTicketStatusName() {
			return $this->ticket_status_name;
		}


		public function setTicketStatusId($ticket_status_id) {
			$this->ticket_status_id = $ticket_status_id;
			return $this;
		}

		public function setTicketStatusName($ticket_status_name) {
			$this->ticket_status_name = $ticket_status_name;
			return $this;
		}




	} 
