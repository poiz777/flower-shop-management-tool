<?php 

	namespace  App\Helpers\Traits;

	use Doctrine\ORM\EntityRepository;
	use App\Poiz\HTML\Helpers\ShopTranslator;

	/**
	 * FormObjectLexer
	 * Form-Object Lexer Trait automatically generated by Poiz Doctrine Mediator.
	 * You may add additional Methods to this Trait...
	 **/
trait FormObjectLexer {
    
    public function __construct() {
        $this->updated_at = new \DateTime();
        if ( ! $this->created_at ) {
            $this->created_at = new \DateTime();
        }
        try {
            $this->classProps = (array) $this->getClassPropertyInfo();
        } catch ( \Exception $e ) {
            die( $e->getMessage() );
        }
    }

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
		$originalClass      = get_class($formEntityInstance);
		$refClass           = new \ReflectionClass($originalClass);
		
		foreach ($refClass->getProperties() as &$refProperty) {
			$objClassProps          = new \stdClass();
			$objClassProps->name    = $refProperty->getName();
			$objClassProps->id      = $refProperty->getName();
			if (preg_match('/@var\s+([^\s]+)/', $refProperty->getDocComment(), $matches)) {
				list(, $type) = $matches;
				$objClassProps->type                = trim($type);
			}
			if (preg_match('/\#\#FormClass\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $class) = $matches;
				$objClassProps->class               = trim($class);
			}else{
				$objClassProps->class               = "form-control pz-form-widget {$this->getGuessedClass($objClassProps->name)}";
			}
			if (preg_match('/\#\#FormKey\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $formKey) = $matches;
				$objClassProps->formKey               = trim($formKey);
			}
			if (preg_match('/\#\#FormLabel\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $label) = $matches;
				$objClassProps->label               = $this->translate(trim($label));
			}
			if (preg_match('/\#\#FormInputKey\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $formKey) = $matches;
				$objClassProps->formKey               = trim($formKey);
			}
			if (preg_match('/\#\#FormInputLabel\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $label) = $matches;
				$objClassProps->label               = $this->translate(trim($label));
			}
			if (preg_match('/\#\#FormDZoneAllow\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $allowedFiles)               = $matches;
				$objClassProps->allowedFiles        = trim($allowedFiles);        //($a=$allowedFiles) ? array_filter(explode(",", $a)) : $a;
			}
			if (preg_match('/\#\#FormFieldHint\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $inputFieldHint)             = $matches;
				$objClassProps->inputFieldHint      =  $this->translate(trim($inputFieldHint));
			}
			if (preg_match('/\#\#FormPlaceholder\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $placeholder) = $matches;
				$objClassProps->placeholder         = 'NULL' === trim($placeholder) ? '' : $this->translate(trim($placeholder));
			}
			if (preg_match('/\#\#FormInputReadOnly\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $readOnly)   = $matches;
				$objClassProps->readOnly            = !!trim($readOnly);  //('1' === );
			}
			if (preg_match('/\#\#FormInputDisabled\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $disabled)   = $matches;
				$objClassProps->disabled            = !!trim($disabled);  //('1' === );
			}
			if (preg_match('/\#\#FormUseLabel\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $useLabel) = $matches;
				$objClassProps->useLabel            = trim($useLabel);
			}
			if (preg_match('/\#\#FormAddLabel\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $addLabel) = $matches;
				$objClassProps->addLabel            = trim($addLabel);
			}
			if (preg_match('/\#\#FormInputPrepend\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $prepend) = $matches;
				$objClassProps->prepend             =  $this->translate(trim($prepend));
			}
			if (preg_match('/\#\#FormInputAppend\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $append) = $matches;
				$objClassProps->append              =  $this->translate(trim($append));
			}
			if (preg_match('/\#\#FormInputType\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $inputType) = $matches;
				$objClassProps->inputType           = trim($inputType);
			}
			if (preg_match('/\#\#FormInputEntityClass\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $entityClass) = $matches;
				$objClassProps->entityClass           = trim($entityClass);
			}
			if (preg_match('/\#\#FormInputOptions\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $inputOptions) = $matches;
				$objClassProps->inputOptions        = $inputOptions;
				
				if($objClassProps->inputOptions){
					if(is_callable($objClassProps->inputOptions)) {
						$objClassProps->inputOptions = call_user_func( $objClassProps->inputOptions);
					}
				}
			}
			if (preg_match('/\#\#FormInputSwitchConfig\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $switchConfig) = $matches;
				$objClassProps->switchConfig        = $switchConfig;
				
				if($objClassProps->switchConfig){
					if(is_callable($objClassProps->switchConfig)) {
						$result   = call_user_func_array( $objClassProps->switchConfig, [$objClassProps]);
						if(is_array($result) && $result){
							foreach ($result as $key=>$value){
								$objClassProps->{$key}  = $value;
							}
						}
						# $objClassProps->inputOptions = call_user_func_array( $objClassProps->inputOptions, []);
					}
				}
			}
			if (preg_match('/\#\#FormInputCodeLang\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $codeLang)   = $matches;
				$objClassProps->codeLang            = trim($codeLang);
			}
			if (preg_match('/\#\#FormInputCodeTheme\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $codeEditorTheme)            = $matches;
				$objClassProps->codeEditorTheme           = trim($codeEditorTheme);
			}
			if (preg_match('/\#\#FormInputDzURL\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $dzURL)      = $matches;
				$objClassProps->dzURL               = trim($dzURL);
			}
			if (preg_match('/\#\#FormInputRequired\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $inputRequired) = $matches;
				$objClassProps->inputRequired       = trim($inputRequired);
			}
			if (preg_match('/\#\#FormInputFixedValue\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $inputFixedValue)            = $matches;
				$objClassProps->inputFixedValue     = trim($inputFixedValue);
			}
			if (preg_match('/\#\#FormInputState\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $inputState) = $matches;
				$objClassProps->inputState          = trim($inputState);
			}
			if (preg_match('/\#\#FormElementClass\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $cssClassExtra) = $matches;
				$objClassProps->cssClassExtra       = trim($cssClassExtra);
			}
			if (preg_match('/\#\#FormBlockWrapperClass\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $blockWrapperClass) = $matches;
				$objClassProps->blockWrapperClass   = trim($blockWrapperClass);
			}
			if (preg_match('/\#\#FormElementData\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $dataAttributes) = $matches;
				$objClassProps->dataAttributes      = trim($dataAttributes);
			}
			if (preg_match('/\#\#FormRawContent\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $rawContent) = $matches;
				$objClassProps->rawContent          = trim($rawContent);
			}
			if (preg_match('/\#\#FormInputDropDownMaxSelection\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $dropDownMax) = $matches;
				$objClassProps->dropDownMax         = trim($dropDownMax);
			}
			if (preg_match('/\#\#FormInputMin\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $minInputVal) = $matches;
				$objClassProps->minInputVal         = trim($minInputVal);
			}
			if (preg_match('/\#\#FormInputMax\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $maxInputVal) = $matches;
				$objClassProps->maxInputVal         = trim($maxInputVal);
			}
			if (preg_match('/\#\#FormInputStep\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $step) = $matches;
				$objClassProps->inputStep           = trim($step);
			}
			
			if ( preg_match('/\#\#FormFieldIsNullable\s+(.*)/', $refProperty->getDocComment(), $matches) ||
			     preg_match('/\#\#FormInputIsNullable\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $nullable)           = $matches;
				$nullable                   = strtolower(trim($nullable)) == 'true' ? true : (strtolower(trim($nullable)) == 'false' ? false : trim($nullable));
				$objClassProps->isNullable  = boolval($nullable);
			}
			
			if (preg_match('/\#\#FormValidationStrategy\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $validationStrategy)         = $matches;
				$objClassProps->validationStrategy  = trim($validationStrategy);
			}
			
			if (preg_match('/\#\#FormValidationStrategies\s+(.*)/', $refProperty->getDocComment(), $matches)) {
				list(, $validationStrategy)         = $matches;
				$objClassProps->validationStrategy  = trim($validationStrategy);
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
	
	
	public function autoSetClassProps($arrayOrObject) {
		if( (is_array($arrayOrObject) || is_object($arrayOrObject)) && $arrayOrObject ) {
			foreach($arrayOrObject as $property=>$value){
				$value  = is_object($value)  || is_array($value) ? $value : ( (strtolower($value) == 'true') ? true : (strtolower($value) == 'false' ? false : $value) );
				if(property_exists($this, $property)){
					$set    = $this->siftSetterMethod($property);
					if(is_string($set)) {
						$this->{$set}($value);
						$this->entityBank[$property]	= $value;
					}
				}
			}
		}
		return $this;
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
		static::$instance = $this;
		return $this->entityBank;
	}
	
	public function getEntityBank() {
			$this->initializeEntityBank();
			unset($this->entityBank['eMan']);
			unset($this->entityBank['instance']);
			unset($this->entityBank['classProps']);
			unset($this->entityBank['entityBank']);
			unset($this->entityBank['toggleConfig']);
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
		return array_map(function($obj){ return $this->objectToArrayRecursive($obj); }, $this->classProps);
	}
	
	public function setClassProps($classProps){
	    $this->classProps =  $classProps;
      }

	private function translate($string, $domain='pz'){
			return $string;
	}
	

}