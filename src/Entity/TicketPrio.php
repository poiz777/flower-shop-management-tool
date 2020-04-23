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
	 * TicketPrio
	 * @Table(name="ticket_prio")
	 * @Entity(repositoryClass="App\Entity\Repo\TicketPrioRepo")
	 **/
	class TicketPrio { 

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
		 * @Id TicketPrio
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel Ticket Prio Id 
		 * ##FormFieldHint <span class='pz-hint'>ticket_prio_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $ticket_prio_id; 

		/**
		 * @var string
		 * @Column(name="ticket_prio_name", type="string", length=20, nullable=false) 
		 * 
		 * ##FormLabel Ticket Prio Name 
		 * ##FormFieldHint <span class='pz-hint'>ticket_prio_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $ticket_prio_name; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getTicketPrioId() {
			return $this->ticket_prio_id;
		}

		public function getTicketPrioName() {
			return $this->ticket_prio_name;
		}


		public function setTicketPrioId($ticket_prio_id) {
			$this->ticket_prio_id = $ticket_prio_id;
			return $this;
		}

		public function setTicketPrioName($ticket_prio_name) {
			$this->ticket_prio_name = $ticket_prio_name;
			return $this;
		}




	} 
