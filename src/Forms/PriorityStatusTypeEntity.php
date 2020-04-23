<?php 

	namespace App\Forms;

	use Doctrine\ORM\EntityManagerInterface;
	use App\Helpers\Traits\EntityFieldMapperTrait;
	use App\Helpers\Traits\FormObjectLexer;

	/**
	 * PriorityStatusTypeEntity
	 **/
	class PriorityStatusTypeEntity {
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
		 *
		 * ##FormLabel Typ
		 * ##FormFieldHint <span class='pz-hint'>Tickettyp</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormAddLabel 0
		 * ##FormUseLabel 0
		 * ##FormPlaceholder Typ
		 * ##FormInputOptions App\Forms\TicketArchiveEntity::fetchTicketTypesAsOptions
		 * ##FormValidationStrategy NUM
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $type;
		
		/**
		 * @var int
		 *
		 * ##FormLabel Ticket Priorität
		 * ##FormFieldHint <span class='pz-hint'>Ticket Priorität</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormAddLabel 0
		 * ##FormUseLabel 0
		 * ##FormPlaceholder Priorität
		 * ##FormInputOptions App\Forms\TicketArchiveEntity::fetchTicketPrioritiesAsOptions
		 * ##FormValidationStrategy NUM
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $priority;
		
		/**
		 * @var int
		 *
		 * ##FormLabel Status
		 * ##FormFieldHint <span class='pz-hint'>Ticket Status</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormAddLabel 0
		 * ##FormUseLabel 0
		 * ##FormPlaceholder Status
		 * ##FormInputOptions App\Forms\TicketArchiveEntity::fetchTicketStatusAsOptions
		 * ##FormValidationStrategy NUM
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $status;
		
		/**
		 * @var \App\Forms\PriorityStatusTypeEntity
		 */
		protected static $instance;
		
		public function __construct(){
			$this->initializeEntityBank();
			static::$instance = $this;
		}
		
		/**
		 * @return int
		 */
		public function getPriority(){
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
		public function getType() {
			return $this->type;
		}
		
		/**
		 * @param int $priority
		 *
		 * @return PriorityStatusTypeEntity
		 */
		public function setPriority( $priority): PriorityStatusTypeEntity {
			$this->priority = $priority;
			
			return $this;
		}
		
		/**
		 * @param int $status
		 *
		 * @return PriorityStatusTypeEntity
		 */
		public function setStatus($status): PriorityStatusTypeEntity {
			$this->status = $status;
			
			return $this;
		}
		
		/**
		 * @param int $type
		 *
		 * @return PriorityStatusTypeEntity
		 */
		public function setType($type): PriorityStatusTypeEntity {
			$this->type = $type;
			
			return $this;
		}
		
		
		
	}
	