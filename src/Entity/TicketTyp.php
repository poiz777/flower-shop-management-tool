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
	 * TicketTyp
	 * @Table(name="ticket_typ")
	 * @Entity(repositoryClass="App\Entity\Repo\TicketTypRepo")
	 **/
	class TicketTyp { 

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
		 * @Id TicketTyp
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel Ticket Typ Id 
		 * ##FormFieldHint <span class='pz-hint'>ticket_typ_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $ticket_typ_id; 

		/**
		 * @var string
		 * @Column(name="ticket_typ_name", type="string", length=25, nullable=false) 
		 * 
		 * ##FormLabel Ticket Typ Name 
		 * ##FormFieldHint <span class='pz-hint'>ticket_typ_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $ticket_typ_name; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getTicketTypId() {
			return $this->ticket_typ_id;
		}

		public function getTicketTypName() {
			return $this->ticket_typ_name;
		}


		public function setTicketTypId($ticket_typ_id) {
			$this->ticket_typ_id = $ticket_typ_id;
			return $this;
		}

		public function setTicketTypName($ticket_typ_name) {
			$this->ticket_typ_name = $ticket_typ_name;
			return $this;
		}




	} 
