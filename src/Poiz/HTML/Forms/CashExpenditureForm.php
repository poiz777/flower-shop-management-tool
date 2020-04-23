<?php
	/**
	 * Created by PhpStorm.
	 * User: poiz
	 * Date: 10.03.19
	 * Time: 06:16
	 */
	
	namespace  App\Poiz\HTML\Forms;
	
	use App\Forms\CashExpenditureEntity;
	use App\Poiz\HTML\Helpers\ShopTranslator;
	use  App\Poiz\HTML\Widgets\Widget;
	
	class CashExpenditureForm {
		protected $errors           = ['count'=> 0];
		protected $elements         = [];
		protected $formEntity;
		
		/**
		 * UserForm constructor.
		 *
		 * @param null|object                                $formEntity
		 * @param \App\Poiz\HTML\Helpers\ShopTranslator|null $translator
		 * @param array                                      $config
		 */
		public function __construct($formEntity=null, ?ShopTranslator $translator=null, $config=[]) {
			$this->translator   = $translator;
			$this->formEntity   = $formEntity ? $formEntity : new CashExpenditureEntity();
			$setValue           = $formEntity ? true : false;
			$this->setup($setValue, $config);
		}
		
		public function getForm(){
			return $this->elements;
		}
		
		public function setup($setValue=false, $rayConfig=[]) {
			$classProps   = $this->formEntity->getClassProps();
			foreach($classProps as $iKey=>$config){
				$config     = array_merge($config, $rayConfig);
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
				$options = is_string($options) ? [] : $options;
				$this->elements[]   = new $config['entityClass']($config, $options);
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
		
		public function getValidatedFormWithErrors(){
			return $this->elements;
		}
		
	}
