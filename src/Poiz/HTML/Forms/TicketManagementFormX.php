<?php
	/**
	 * Created by PhpStorm.
	 * User: poiz
	 * Date: 10.03.19
	 * Time: 06:16
	 */
	
	namespace  App\Poiz\HTML\Forms;
	
	use App\Forms\TicketManagementEntityX;
	use App\Poiz\HTML\Helpers\ShopTranslator;
	use  App\Poiz\HTML\Widgets\Widget;
	
	class TicketManagementFormX {
		protected $errors           = ['count'=> 0];
		protected $elements         = [];
		public $widgetMetaData      = [];
		protected $formEntity;
		
		/**
		 * UserForm constructor.
		 *
		 * @param null|object                                $formEntity
		 * @param \App\Poiz\HTML\Helpers\ShopTranslator|null $translator
		 * @param bool                                       $injectScripts
		 */
		public function __construct($formEntity=null, ?ShopTranslator $translator=null, $injectScripts=true) {
			$this->translator   = $translator;
			$this->formEntity   = $formEntity ? $formEntity : new TicketManagementEntityX();
			$setValue           = $formEntity ? true : false;
			$this->setup($setValue, $injectScripts);
		}
		
		public function getForm(){
			return $this->elements;
		}
		public function setup($setValue=false, $injectScripts=true) {
			/**  @var  Widget $element */
			foreach($this->formEntity->getClassProps() as $iKey=>$config){
				$options    = [];
				if($setValue){
					foreach($this->formEntity->getEntityBank() as $fieldName=>$fieldVal){
						if($fieldName == $config['name']){
							if($fieldVal instanceof \DateTime){
								if(isset($config['entityClass'])){
									if( preg_match("#DateTime$#", $config['entityClass'])){
											$fieldVal = $fieldVal->format('Y-m-d H:i:s');
											$fieldVal = preg_match("#^\-#", $fieldVal) ? date("Y-m-d H:i:s", strtotime('1970-01-01')) : $fieldVal;
									}elseif( preg_match("#Date$#", $config['entityClass'])){
										$fieldVal = $fieldVal->format('Y-m-d');
										$fieldVal = preg_match("#^\-#", $fieldVal) ? date("Y-m-d", strtotime('1970-01-01')) : $fieldVal;
									}elseif( preg_match("#Time$#", $config['entityClass'])){
										$fieldVal = $fieldVal->format('H:i');
										$fieldVal = preg_match("#^\-#", $fieldVal) ? date("H:i", strtotime('1970-01-01')) : $fieldVal;
									}
								}
							}
							$config['value']    = $fieldVal;
							break;
						}
					}
				}
				
				if(isset($config['inputOptions']) && $config['inputOptions'] !== 'NULL' ){
					$options    = $config['inputOptions'];
					unset($config['inputOptions']);
				}
				$options  = is_string($options) ? [] : $options;
				if(stristr($config['entityClass'], 'DropDownEnhanced')){  //  || stristr($config['entityClass'], 'Editor')
					$element  = new $config['entityClass']($config, $options, $injectScripts);
					$this->widgetMetaData[] = $element->widgetMeta;
				}else{
					$element  = new $config['entityClass']($config, $options);
				}
				$this->elements[]       = $element;
			}
		}
		
		public function isValid($postVars){
			if(!$postVars) return false;
			/**@var Widget $element */
			$elements       = $this->elements;
			$this->errors   = ['count'=> 0];
			$this->elements = [];
			$dataBankArray  = [];
			
			$updatePayload  = [];
			foreach($elements as $element) {
				$status           = $element->setTranslator($this->translator)->validate( $postVars );
				$updatePayload[$element->getConfig()['name']] = $status['value'];
				$this->formEntity = $this->formEntity->autoSetClassProps([$element->getConfig()['name'] => $status['value']]);
				$this->errors['count'] += sizeof( $status['error'] );
				$this->elements[]       = $status['widget'];
				$dataBankArray[$element->getConfig()['name']]   = $status['value'];
			}
			
			return ($this->errors['count'] > 0) ? false : $this->formEntity;
		}
		
		public function setTranslator($translator){
			return $this->translator = $translator;
		}
		
		public function getFormErrors(){
			return $this->errors['count'];
		}
		
		/**
		 * @return array
		 */
		public function getElements(): array {
			return $this->elements;
		}
		
		/**
		 * @param array $elements
		 *
		 * @return TicketManagementFormX
		 */
		public function setElements( array $elements ): TicketManagementFormX {
			$this->elements = $elements;
			
			return $this;
		}
		
		/**
		 * @return array
		 */
		public function getWidgetMetaData(): array {
			return $this->widgetMetaData;
		}
		
		/**
		 * @param array $widgetMetaData
		 *
		 * @return TicketManagementFormX
		 */
		public function setWidgetMetaData( array $widgetMetaData ): TicketManagementFormX {
			$this->widgetMetaData = $widgetMetaData;
			
			return $this;
		}
		
		/**
		 * @return \App\Forms\TicketManagementEntity|object|null
		 */
		public function getFormEntity() {
			return $this->formEntity;
		}
		
		/**
		 * @param \App\Forms\TicketManagementEntity|object|null $formEntity
		 *
		 * @return TicketManagementFormX
		 */
		public function setFormEntity( $formEntity ) {
			$this->formEntity = $formEntity;
			
			return $this;
		}
		
		
		public function getValidatedFormWithErrors(){
			return $this->elements;
		}
		
	}
