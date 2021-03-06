<?php
	/**
	 * Created by PhpStorm.
	 * User: poiz
	 * Date: 10.03.19
	 * Time: 11:12
	 */
	
	namespace  App\Poiz\HTML\FormEntity;
	
	
	trait FormEntityLexer {
		
		/**
		 * READS THE FORM ENTITY CLASS AND PARSES THE ANNOTATED MEMBER PROPERTIES.
		 * THE ANNOTATION HERE IS EXPECTED TO START WITH 2 HASHES EG: ##FormLabel
		 * @param mixed|null $formEntityInstance
		 *
		 * @return array
		 * @throws \ReflectionException
		 */
		protected function getClassPropertyInfo($formEntityInstance=null){
			$formEntityInstance = (!$formEntityInstance) ? $this : $formEntityInstance;
			$arrClassProps      = [];
			$refClass           = new \ReflectionClass($formEntityInstance);
			
			foreach ($refClass->getProperties() as &$refProperty) {
				$objClassProps          = new \stdClass();
				$objClassProps->name    = $refProperty->getName();
				$objClassProps->id      = $refProperty->getName();
				if (preg_match('/@var\s+([^\s]+)/', $refProperty->getDocComment(), $matches)) {
					list(, $type) = $matches;
					$objClassProps->type                = $type;
				}
				if (preg_match('/\#\#FormClass\s+(.*)/', $refProperty->getDocComment(), $matches)) {
					list(, $class) = $matches;
					$objClassProps->class               = $class;
				}else{
					$objClassProps->class               = "form-control pz-form-widget {$this->getGuessedClass($objClassProps->name)}";
				}
				if (preg_match('/\#\#FormLabel\s+(.*)/', $refProperty->getDocComment(), $matches)) {
					list(, $label) = $matches;
					$objClassProps->label               = $label;
				}
				if (preg_match('/\#\#FormInputLabel\s+(.*)/', $refProperty->getDocComment(), $matches)) {
					list(, $label) = $matches;
					$objClassProps->label               = $label;
				}
				if (preg_match('/\#\#FormDZoneAllow\s+(.*)/', $refProperty->getDocComment(), $matches)) {
					list(, $allowedFiles)               = $matches;
					$objClassProps->allowedFiles        = ($a=$allowedFiles) ? array_filter(explode(",", $a)) : $a;
				}
				if (preg_match('/\#\#FormFieldHint\s+(.*)/', $refProperty->getDocComment(), $matches)) {
					list(, $inputFieldHint)             = $matches;
					$objClassProps->inputFieldHint      = $inputFieldHint;
				}
				if (preg_match('/\#\#FormPlaceholder\s+(.*)/', $refProperty->getDocComment(), $matches)) {
					list(, $placeholder) = $matches;
					$objClassProps->placeholder         = $placeholder;
				}
				if (preg_match('/\#\#FormUseLabel\s+(.*)/', $refProperty->getDocComment(), $matches)) {
					list(, $useLabel) = $matches;
					$objClassProps->useLabel            = $useLabel;
				}
				if (preg_match('/\#\#FormAddLabel\s+(.*)/', $refProperty->getDocComment(), $matches)) {
					list(, $addLabel) = $matches;
					$objClassProps->addLabel            = $addLabel;
				}
				if (preg_match('/\#\#FormInputPrepend\s+(.*)/', $refProperty->getDocComment(), $matches)) {
					list(, $prepend) = $matches;
					$objClassProps->prepend             = $prepend;
				}
				if (preg_match('/\#\#FormInputAppend\s+(.*)/', $refProperty->getDocComment(), $matches)) {
					list(, $append) = $matches;
					$objClassProps->append              = $append;
				}
				if (preg_match('/\#\#FormInputType\s+(.*)/', $refProperty->getDocComment(), $matches)) {
					list(, $inputType) = $matches;
					$objClassProps->inputType           = $inputType;
				}
				if (preg_match('/\#\#FormInputOptions\s+(.*)/', $refProperty->getDocComment(), $matches)) {
					list(, $inputOptions) = $matches;
					$objClassProps->inputOptions        = $inputOptions;
					
					if($objClassProps->inputOptions){
						if(is_callable($objClassProps->inputOptions)) {
							$objClassProps->inputOptions = call_user_func( $objClassProps->inputOptions );
						}
					}
				}
				if (preg_match('/\#\#FormInputCodeLang\s+(.*)/', $refProperty->getDocComment(), $matches)) {
					list(, $codeLang)   = $matches;
					$objClassProps->codeLang            = $codeLang;
				}
				if (preg_match('/\#\#FormInputCodeTheme\s+(.*)/', $refProperty->getDocComment(), $matches)) {
					list(, $codeEditorTheme)            = $matches;
					$objClassProps->codeEditorTheme           = $codeEditorTheme;
				}
				if (preg_match('/\#\#FormInputDzURL\s+(.*)/', $refProperty->getDocComment(), $matches)) {
					list(, $dzURL)      = $matches;
					$objClassProps->dzURL               = $dzURL;
				}
				if (preg_match('/\#\#FormInputRequired\s+(.*)/', $refProperty->getDocComment(), $matches)) {
					list(, $inputRequired) = $matches;
					$objClassProps->inputRequired       = $inputRequired;
				}
				if (preg_match('/\#\#FormInputFixedValue\s+(.*)/', $refProperty->getDocComment(), $matches)) {
					list(, $inputFixedValue)            = $matches;
					$objClassProps->inputFixedValue     = $inputFixedValue;
				}
				if (preg_match('/\#\#FormInputState\s+(.*)/', $refProperty->getDocComment(), $matches)) {
					list(, $inputState) = $matches;
					$objClassProps->inputState          = $inputState;
				}
				if (preg_match('/\#\#FormElementClass\s+(.*)/', $refProperty->getDocComment(), $matches)) {
					list(, $cssClassExtra) = $matches;
					$objClassProps->cssClassExtra       = $cssClassExtra;
				}
				if (preg_match('/\#\#FormBlockWrapperClass\s+(.*)/', $refProperty->getDocComment(), $matches)) {
					list(, $blockWrapperClass) = $matches;
					$objClassProps->blockWrapperClass   = $blockWrapperClass;
				}
				if (preg_match('/\#\#FormElementData\s+(.*)/', $refProperty->getDocComment(), $matches)) {
					list(, $dataAttributes) = $matches;
					$objClassProps->dataAttributes      = $dataAttributes;
				}
				if (preg_match('/\#\#FormRawContent\s+(.*)/', $refProperty->getDocComment(), $matches)) {
					list(, $rawContent) = $matches;
					$objClassProps->rawContent          = $rawContent;
				}
				if (preg_match('/\#\#FormInputMax\s+(.*)/', $refProperty->getDocComment(), $matches)) {
					list(, $rangeMax) = $matches;
					$objClassProps->rangeMax            = $rangeMax;
				}
				if (preg_match('/\#\#FormInputDropDownMaxSelection\s+(.*)/', $refProperty->getDocComment(), $matches)) {
					list(, $dropDownMax) = $matches;
					$objClassProps->dropDownMax         = $dropDownMax;
				}
				if (preg_match('/\#\#FormInputMin\s+(.*)/', $refProperty->getDocComment(), $matches)) {
					list(, $rangeMin) = $matches;
					$objClassProps->rangeMin            = $rangeMin;
				}
				if (preg_match('/\#\#FormValidationStrategy\s+(.*)/', $refProperty->getDocComment(), $matches)) {
					list(, $validationStrategy)         = $matches;
					$objClassProps->validationStrategy  = $validationStrategy;
				}
				if(isset($objClassProps->inputType) && $objClassProps->inputType){
					$arrClassProps[]                        = $objClassProps;
				}
			}
			return $arrClassProps;
		}
		
		protected function getGuessedClass($fieldName){
			return trim(preg_replace_callback("#([A-Z_])#u", function($match) use ($fieldName) {
				return "-" . strtolower($match[0]);
			}, $fieldName), '- ');
		}
		
		public function autoSetClassProps($props){
			if( (is_array($props) || is_object($props)) && $props ){
				foreach($props as $propName=>$propValue){
					$gsName                     = $this->rinseFieldName($propName);
					$setterMethod               = "set" . $gsName;
					if(property_exists($this, $propName)){
						if(method_exists($this, $setterMethod)){
							$this->$setterMethod($propValue);
						}else if(property_exists($this, $propName)){
							$this->$propName			= $propValue;
						}
						$this->entityBank[$propName]	= $propValue;
					}
				}
			}
		}
		
		public function initializeProperties($object){
			foreach ($object as $prop=>$propVal) {
				if(property_exists($this, $prop)){
					if($prop == "entityBank" || preg_match("#^_#", $prop)){ continue; }
					$this->$prop				= $propVal;
					$this->entityBank[$prop]	= $propVal;
				}
			}
			return $this;
		}
		
		protected function rinseFieldName($fieldName){
			$arrName    = preg_split("#[_\-\s]+#",    $fieldName);
			$arrName    = array_map("ucfirst", $arrName);;
			$strName    = implode("", $arrName);
			return $strName;
		}
		
		public function autoSetClassProperties($arrData){
			if(!is_null($arrData)){
				foreach($arrData as $prop=>$val){
					if(property_exists($this, $prop)){
						$this->$prop				= $val;
						$this->entityBank[$prop]    = $val;
					}
				}
			}
		}
		
		/**
		 * @param $formEntityInstance
		 *
		 * @return array
		 * @throws \ReflectionException
		 */
		protected function getClassProperties($formEntityInstance){
			$arrClassProps                  = [];
			$refClass                       = new \ReflectionClass($formEntityInstance);
			
			foreach ($refClass->getProperties() as &$refProperty) {
				$arrClassProps[]        = $refProperty->getName();
			}
			return $arrClassProps;
		}
		
		/**
		 * @return mixed
		 * @throws \ReflectionException
		 */
		public function initializeEntityBank(){
			$refClass					= new \ReflectionClass($this);
			
			foreach ($refClass->getProperties() as &$refProperty) {
				$key					= $refProperty->getName();
				$this->entityBank[$key]	= $this->$key;
			}
			return $this->entityBank;
		}
		
		public function objectToArrayRecursive2($object, &$return_array=null){
			if(!is_object($object) || empty($object)) return null;
			$return_array = (!$return_array) ? [] : $return_array;
			foreach($object as $key=>$val){
				if(is_object($val)){
					$return_array[$key] = [];
					$this->objectToArrayRecursive2($val, $return_array[$key]);
				}else{
					$return_array[$key]		= $val;
				}
			}
			return $return_array;
		}
		
		public function arrayToObjectRecursive2($array, &$objReturn=null){
			if(!is_array($array) || empty($array)) return null;
			$objReturn = (!$objReturn) ? new \stdClass() : $objReturn;
			foreach($array as $key=>$val){
				if(is_array($val)){
					$objReturn->$key = new \stdClass();
					$this->arrayToObjectRecursive2($val, $objReturn->$key);
				}else{
					$objReturn->$key		= $val;
				}
			}
			return $objReturn;
		}
		
		public function recursiveArrayFind2($key, $data){
			if(array_key_exists($key, $data)){
				return $data[$key];
			}else{
				if(is_array($data)){
					foreach($data as $k=>$value){
						if($k == $key){
							return $value;
						}else if(is_array($value)){
							return $this->recursiveArrayFind2($key, $value);
						}
					}
				}
			}
			return null;
		}
		
		public function getEntityBank() {
			return $this->entityBank;
		}
		
		public function setEntityBank($eBank) {
			$this->entityBank = $eBank;
			return $this;
		}
		
		public function getClassProps() {
            try {
				$this->classProps = (array) $this->getClassPropertyInfo();
				unset($this->classProps['classProps']);
            } catch ( \Exception $e ) {
                die( $e->getMessage() );
			}
			dump(array_map(function($obj){ return $this->objectToArrayRecursive2($obj); }, $this->classProps));
			return array_map(function($obj){ return $this->objectToArrayRecursive2($obj); }, $this->classProps);
		}
	}
