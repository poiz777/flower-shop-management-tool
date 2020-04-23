<?php 

	namespace App\Forms;

	use App\Helpers\Date\RequestBridge;
	use Doctrine\ORM\EntityManagerInterface;
	use App\Helpers\Traits\EntityFieldMapperTrait;
	use App\Helpers\Traits\FormObjectLexer;

	/**
	 * CashRegisterClientInfoEntity
	 **/
	class CashRegisterClientInfoEntity {
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
		 * ##FormLabel Privat / Geschäftskunde
		 * ##FormFieldHint <span class='pz-hint'>Privat / Geschäftskunde</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormPlaceholder Privat / Geschäftskunde
		 * ##FormInputOptions App\Forms\TicketArchiveEntity::fetchCompanyAndPrivateClientsAsOptions
		 * ##FormValidationStrategy NUM
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
		 * ##FormLabel Zahlungsmittel
		 * ##FormFieldHint <span class='pz-hint'>Zahlungsmittel</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormAddLabel 1
		 * ##FormUseLabel 1
		 * ##FormPlaceholder Zahlungsmittel
		 * ##FormInputOptions App\Forms\TicketArchiveEntity::fetchPaymentMethodsAsOptions
		 * ##FormValidationStrategy NUM
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $paymentMethod;
		
		/**
		 * @var \App\Forms\CashRegisterClientInfoEntity
		 */
		protected static $instance;
		
		public function __construct(){
			global $kernel;
			$dptPayMethodMap      = ['940' => 1, '941' => 10, '942' => 0];
			$melSession           = $kernel->getContainer()->get('session')->get(RequestBridge::SessionNameSpace);
			$this->paymentMethod  = isset($melSession['department']) ? 	$dptPayMethodMap[$melSession['department']] : null;
			$this->client         = 43;  // THE UNKNOWN (UNBEKANNTES) CLIENT...…
			$this->initializeEntityBank();
			static::$instance     = $this;
		}
		
		/**
		 * @return int
		 */
		public function getClient() {
			return $this->client;
		}
		
		/**
		 * @return int
		 */
		public function getPaymentMethod() {
			return $this->paymentMethod;
		}
		
		
		
		/**
		 * @param int $cient
		 *
		 * @return CashRegisterClientInfoEntity
		 */
		public function setClient( $client ): CashRegisterClientInfoEntity {
			$this->client = $client;
			
			return $this;
		}
		
		/**
		 * @param int $paymentMethod
		 *
		 * @return CashRegisterClientInfoEntity
		 */
		public function setPaymentMethod( $paymentMethod ): CashRegisterClientInfoEntity {
			$this->paymentMethod = $paymentMethod;
			
			return $this;
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
		 * @param int $businessClient
		 *
		 * @return CashRegisterClientInfoEntity
		 */
		public function setBusinessClient( $businessClient ): CashRegisterClientInfoEntity {
			$this->businessClient = $businessClient;
			
			return $this;
		}
		
		/**
		 * @param int $privateClient
		 *
		 * @return CashRegisterClientInfoEntity
		 */
		public function setPrivateClient( $privateClient ): CashRegisterClientInfoEntity {
			$this->privateClient = $privateClient;
			
			return $this;
		}
		
		
		public static function getEntityManager(){
			global $kernel;
			return $kernel->getContainer()->get('doctrine.orm.entity_manager');
		}
		
		
		
	}
	