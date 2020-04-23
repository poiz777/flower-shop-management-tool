<?php 

	namespace App\Forms;

	use Doctrine\ORM\EntityManagerInterface;
	use App\Helpers\Traits\EntityFieldMapperTrait;
	use App\Helpers\Traits\FormObjectLexer;

	/**
	 * PriorityStatusTypeWEntity
	 **/
	class PriorityStatusTypeWEntity {
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
		protected $typeW;
		
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
		protected $priorityW;
		
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
		protected $statusW;
		
		/**
		 * @var \App\Forms\PriorityStatusTypeWEntity
		 */
		protected static $instance;
		
		public function __construct(){
			$this->initializeEntityBank();
			static::$instance = $this;
		}
		
		/**
		 * @return int
		 */
		public function getPriorityW(){
			return $this->priorityW;
		}
		
		/**
		 * @return int
		 */
		public function getStatusW(){
			return $this->statusW;
		}
		
		/**
		 * @return int
		 */
		public function getTypeW() {
			return $this->typeW;
		}
		
		/**
		 * @param int $priority
		 *
		 * @return PriorityStatusTypeWEntity
		 */
		public function setPriorityW( $priority): PriorityStatusTypeWEntity {
			$this->priorityW = $priority;
			
			return $this;
		}
		
		/**
		 * @param int $status
		 *
		 * @return PriorityStatusTypeWEntity
		 */
		public function setStatusW($status): PriorityStatusTypeWEntity {
			$this->statusW = $status;
			
			return $this;
		}
		
		/**
		 * @param int $type
		 *
		 * @return PriorityStatusTypeWEntity
		 */
		public function setTypeW($type): PriorityStatusTypeWEntity {
			$this->typeW = $type;
			
			return $this;
		}
		
		
		
	}
	