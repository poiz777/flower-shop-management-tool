<?php
	/**
	 * Created by PhpStorm.
	 * User: poiz
	 * Date: 10.03.19
	 * Time: 06:16
	 */
	
	namespace  App\Poiz\HTML\Forms;
	
	
	use App\Poiz\Biller\Entity\Bill;
	use  App\Poiz\HTML\Widgets\Widget;
	
	class BillForm {
		protected $errors           = ['count'=> 0];
		protected $elements         = [];
		protected $formEntity;
		
		/**
		 * UserForm constructor.
		 *
		 * @param null $formEntity
		 */
		public function __construct($formEntity=null) {
			$this->formEntity   = $formEntity ? $formEntity : new Bill();
			$setValue           = $formEntity ? true : false;
			$this->setup($setValue);
		}
		
		public function getForm(){
			return $this->elements;
		}
		
		public function setup($setValue=false) {
			foreach($this->formEntity->getClassProps() as $iKey=>$config){
				$options    = [];
				if($setValue){
				    foreach($this->formEntity->getEntityBank() as $fieldName=>$fieldVal){
				        if($fieldName == $config['name']){
				            $config['value']    = $fieldVal;
                                break;
                        }
                    }
                }
                
                if(isset($config['inputOptions']) && $config['inputOptions'] !== 'NULL' ){
                    $options    = $config['inputOptions'];
                    unset($config['inputOptions']);
                }
                
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
			
			foreach($elements as $element) {
				$status = $element->validate( $postVars );
				$this->formEntity->autoSetClassProps([$element->getConfig()['name'] => $status['value']]);
				$this->errors['count'] += sizeof( $status['error'] );
				$this->elements[]       = $status['widget'];
				$dataBankArray[$element->getConfig()['name']]   = $status['value'];
			}
			
			//return ($this->errors['count'] > 0) ? false : ['objectData'=>$this->formEntity, 'entityBank'=>$dataBankArray];
			return ($this->errors['count'] > 0) ? false : $this->formEntity;
		}
		
		public function getValidatedFormWithErrors(){
			return $this->elements;
		}
		
	}
