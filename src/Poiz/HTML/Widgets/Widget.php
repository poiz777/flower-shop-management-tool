<?php
	/**
	 * Created by PhpStorm.
	 * User: poiz
	 * Date: 08.03.19
	 * Time: 17:24
	 */
	
	namespace  App\Poiz\HTML\Widgets;
	
	
	use  App\Poiz\HTML\Helpers\ShopTranslator;
    use  App\Poiz\HTML\Widgets\FormHelpers\ErrorLogger;
	use App\Poiz\HTML\Widgets\FormHelpers\PzDate;
	
	abstract class Widget {
		protected $id;
		protected $hash;
		protected $widget;
		/**
		 * @var array
		 */
		protected $cleanData = array();
		/**
		 * @var ErrorLogger
		 */
		protected $errorBag;
		protected $className;
		protected $fieldType;
		protected $fieldName;
		protected $fieldValue;
		protected $classNames;
		protected $isCollection;            // FOR FIELDS WITH MULTIPLE VALUES...
		protected $config;
		protected $options;                 // FOR FIELDS LIKE SELECT, ETC
		public $injectScripts   = true;     // SHOULD DRIVER-SCRIPTS BE INJECTED INLINE? DEFAULT IS `TRUE`
		public $widgetMeta      = [];       // META-DATA FOR THE WIDGET...
	
		protected $defaultConfig    =  [
			'class'         => 'form-control',
			'id'            => '',
			'name'          => '',
			'formKey'       => '',  // category_form
			'inputFieldHint'=> '',
			'wpUploadAction'=> '',   // UPLOADS ACTION FOR WP DROP-ZONE UPLOAD VIA AJAX - THE AJAX ACTION FOR WP.
			// BY DEFAULT THIS IS TEXT HOWEVER, EACH SUBCLASS SHOULD RECTIFY THIS
			// IT IS ADVISED NOT TO RELY ON THIS CONFIG VALUE AS A DEVELOPER COULD OVERRIDE IT,
			// IT IS BEST TO USE THE INTERNAL $fieldType PROPERTY FOR THIS PURPOSE AND IGNORE THIS.
			'inputType'     => 'text',
			'value'         => '',
			'entityClass'   => ' App\Poiz\HTML\Widgets\FormElements\Text',
			// THESE ARE HTML5 DATA-ATTRIBUTES
			// EG: " data-sku='' data-color='red' data-open='1' ",
			'data'          => '',
			'label'         => '',
			// LABEL TYPE INFO:
			// POSSIBLE VALUES:
			// 1.) placeholder  [LABEL IS USED AS PLACEHOLDER: OVERRIDES PLACEHOLDER VALUE IF LABEL KEY IS NOT EMPTY]
			// 2.) normal       [LABEL IS PLACED NORMALLY ABOVE OR BESIDE TEXT-FIELD: THIS IS THE DEFAULT]
			'labelType'     => 'normal',
			// IF addLabel IS FALSE, LABEL WILL BE COMPLETELY IGNORED!
			'inputStep'     => null,   // 0.50,
			'minInputVal'   => null,
			'maxInputVal'   => null,   // 1000000,
			'addLabel'      => true,
			'useLabel'      => true,
			'disabled'      => false,
			'readOnly'      => false,
			'isNullable'    => false,
			'placeholder'   => '',  // $this->config['isNullable']
			// DEFAULT VALIDATION IS NONE - THIS MEANS NO VALIDATION WILL TAKE PLACE FOR THE WIDGET
			// EACH SUB-CLASS IMPLEMENTS ITS OWN UNIQUE VALIDATION STRATEGY WHICH COULD BE OVERRIDDEN BY END DEVELOPER.
			'inputOptions'  => null,
			'inputRequired' => '0',
			'dzURL'         => '',
			'allowedFiles'  => '',
			'validationStrategy'    => 'none',
		];
		
		const VALIDATION_STRATEGY   = [
			'NONE'      => 'none',
			'TEL'       => 'tel',
			'FAX'       => 'fax',
			'INT'       => 'int',
			'NUM'       => 'num',
			'HEX'       => 'hex',
			'RGB'       => 'rgb',
			'RAW'       => 'raw',
			'URL'       => 'url',
			'DATE'      => 'date',
			'BOOL'      => 'bool',
			'MISC'      => 'misc',
			'RGBA'      => 'rgb',
			'HTML'      => 'html',
			'CITY'      => 'city',
			'STATE'     => 'state',
			'EMAIL'     => 'email',
			'REGEX'     => 'regex',
			'STRING'    => 'string',
			'AL_NUM'    => 'al_num',
			'DATETIME'  => 'datetime',
			'PASSWORD'  => 'password',
			'NON_EMPTY' => 'non_empty',
			'PASS_THROUGH'  => 'pass_through',
		];
		
		/**
		 * @var ShopTranslator
		 */
		private $shopTranslator;
		
		/*
		public function __construct(array $config, array $options =[], $injectScripts=true) {
			$this->config         = $config;
			$this->options        = $options;
			$this->injectScripts  = $injectScripts;
		}*/
		
		# public abstract function renderWidget();
		# public abstract function addToErrorsPool();
		# public abstract function renderErrors ();
		public abstract function render();
		
		public function setTranslator($translator){
			$this->shopTranslator = $translator;
			return $this;
		}
		
		protected function build($tag, $closeTag=false, $extraClass=null) {
			$extraClass     = trim($extraClass) ? " " . trim($extraClass) : '';
			$this->widget   = "";
			if(isset($this->config['addLabel']) && $this->config['addLabel']){
				if($this->config['labelType'] == 'normal') {
					$labelClasses   = (isset($this->config['errorMessage']) && $this->config['errorMessage']) ? 'pz-error has-error  pz-label': 'pz-label';
					$label          = empty(trim($this->config['label'])) ? 'Please Provide Label in Widget Config Class' : trim($this->config['label']);
					$this->widget  .= "<label class='{$labelClasses}' for='{$this->config['id']}'>{$label}";
					if(isset($this->config['inputFieldHint'])){ $this->widget           .= $this->config['inputFieldHint']; }
					$this->widget  .= "</label>";
				}
			}
			
			if(isset($this->config['errorMessage']) && $this->config['errorMessage']){
				$this->widget  .= "<aside class='pz-error-pod pz-error has-error'>{$this->config['errorMessage']}</aside>";
			}
			
			$widgetClasses  = isset($this->config['class']) ? $this->config['class'] : 'pz-widget';
			$widgetClasses  = (isset($this->config['errorMessage']) && $this->config['errorMessage']) ? "pz-error has-error {$widgetClasses}": $widgetClasses;
			
			$this->widget  .= ($closeTag) ? "<{$tag} " :  "<input type='{$tag}' ";
			if(isset($this->config['id'])){ $this->widget           .= " id=\"{$this->config['id']}\""; }
			if($this->config['formKey'] && isset($this->config['name'])){
			    $this->widget         .= " name=\"" .  $this->config['formKey'] ."[" . $this->config['name'] . "]\"";
			}else{
			    $this->widget         .= " name=\"{$this->config['name']}\"";
      }
			$this->widget             .= " class=\"{$widgetClasses}{$extraClass}\"";
			if(isset($this->config['invalid']) && $this->config['invalid']){ $this->widget  .= " style=\"border-color:red; color:red;\""; }
			if(isset($this->config['placeholder'])){ $this->widget  .= " placeholder=\"{$this->config['placeholder']}\""; }
			if(isset($this->config['data'])){ $this->widget         .= " {$this->config['data']}"; }
			if(isset($this->config['type'])){ $this->widget         .= " data-widget-type=\"{$this->config['type']}\""; }
			if(isset($this->config['readOnly']) && $this->config['readOnly']){ $this->widget  .= " readonly"; }
			if(isset($this->config['disabled']) && $this->config['disabled']){ $this->widget  .= " disabled=\"disabled\""; }
			
			if(isset($this->config['inputStep']) && !is_null($this->config['inputStep'])  ){ $this->widget   .= " step=\"{$this->config['inputStep']}\""; }
			if(isset($this->config['minInputVal']) && !is_null($this->config['minInputVal']) ){ $this->widget .= " min=\"{$this->config['minInputVal']}\""; }
			if(isset($this->config['maxInputVal']) && !is_null($this->config['maxInputVal'])  ){ $this->widget .= " max=\"{$this->config['maxInputVal']}\""; }
			
			$this->widget                                           .= " data-hash='{$this->hash}' ";
			
			if($closeTag){
					$this->widget  .= ">";
					if(isset($this->config['value'])){
						if($this->config['value'] instanceof \DateTime) {
							$this->widget    .= ($this->config['value'])->format("Y-m-d\TH:i:s");
							$this->config['value'] = ($this->config['value'])->format("Y-m-d\TH:i:s");
						}else{
							$this->widget    .= $this->config['value'];
						}
					}
					$this->widget  .= "</$tag>";
			}else {
				if(isset($this->config['value'])){
					$this->resetConfigForDate();
					$this->widget    .= " value=\"{$this->config['value']}\"";
				}
				$this->widget  .= " />";
			}
			return $this->widget;
		}
		
		public function validate($postVars=null) {
			$err                = [];
			$validationStatus   = '';
			try{
				$validationStatus           = $this->validateWidget($postVars[$this->config['name']], $this->config['validationStrategy'], $this->config['label']);
				$this->config['value']      = $validationStatus;
				if(!empty($err = $this->errorBag->getErrors())){
					$this->config['errorMessage']   = $err[$this->config['label']];
					$this->config['invalid']        = true;
				}
				$this->buildWidget();
			}catch (\Exception $e){
				throw new \Exception($e->getMessage());
			}
			return ['widget' => $this, 'error' => $err, 'value' => $validationStatus];
		}
		
		protected function initializeGlobalStore(){
			if(!isset($GLOBALS['global_store'])){
				# require __DIR__ . '/Translations/Translation.php';
				if(isset($global_store)){
					$GLOBALS['global_store']    = $global_store;
				}else{
					$GLOBALS['global_store']    = array();
				}
			}
		}

		protected function resetConfigForDate(){
			if($this->config['value'] instanceof \DateTime){
				if(isset($this->config['entityClass'])){
					if( preg_match("#DateTimeLocal$#", $this->config['entityClass']) ||
					    preg_match("#DateTime$#", $this->config['entityClass'])){
						$this->config['value'] = ($this->config['value'])->format("Y-m-d\TH:i:s");
					}elseif(preg_match("#DatePicker$#", $this->config['entityClass'])){
						$this->config['value'] = ($this->config['value'])->format("d.m.Y");
					}elseif( preg_match("#Date$#", $this->config['entityClass'])){
						$this->config['value'] = ($this->config['value'])->format("Y-m-d");
					}elseif( preg_match("#Time$#", $this->config['entityClass'])){
						$this->config['value'] = ($this->config['value'])->format("H:i");
					}
				}
			}
		}
		
		protected function generateWidgetHash( int $bitsDash=0) {
			$this->resetConfigForDate();
			$characters     = strtoupper(md5(json_encode($this->config)));
			$rayRandString  = [];
			
			for ($i = 0; $i < strlen($characters); $i++) {
				if($bitsDash>0){
					if($i%$bitsDash === 0 && $i !== 0){
						$rayRandString[] = '-';
					}
				}
				$rayRandString[] = $characters[$i];
			}
			return implode('', $rayRandString);
		}
		
		protected function generateRandomHash(int $length = 6, int $bitsDash=0) {
			$characters     = '0123456789ABCDEF';
			$rayRandString  = [];
			
			for ($i = 0; $i < $length; $i++) {
				if($bitsDash>0){
					if($i%$bitsDash === 0 && $i !== 0){
						$rayRandString[] = '-';
					}
				}
				$rayRandString[] = $characters[rand(0, strlen($characters) - 1)];
			}
			return implode('', $rayRandString);
		}
		
		/**
		 * @param $widgetValue
		 * @param $validationStrategy
		 * @param $errorTag
		 *
		 * @return bool|float|null
		 * @throws \Exception
		 */
		protected function validateWidget($widgetValue, $validationStrategy, $errorTag, $returnDateTimeObj=true) {
			# $global_store   = $GLOBALS["global_store"];
			# $lang           = $global_store['active_lang'];
			# $shopTranslator = new ShopTranslator();
			$returnData     = null;
			$sanitizedVal   = $this->sanitize($widgetValue, false); // TODO: FIND A WAY TO MAKE THE STRIP_TAGS FLAG DYNAMIC...
			$shopTranslator =  $this->shopTranslator;
			$isNullable     = (isset($this->config['isNullable']) && empty(trim($sanitizedVal))  && $this->config['isNullable']) ? $this->config['isNullable'] : false;
			
			switch($validationStrategy){
				
				case "tel":
					if(!$isNullable  && !preg_match('#^(\+\d{1,3})?\s?(\d{2,4})\s?(\d{2,4})\s?(\d{2,4})\s?(\d{2,4})$#', $sanitizedVal)){
						$this->errorBag->append_to_log($errorTag, $shopTranslator->translate('pz.api.trans.dict.forms.errors.tel'));
					}
					$returnData     =  $sanitizedVal;
					break;
				
				case "fax":
					if(!$isNullable  && !preg_match('#^(\+\d{1,3})?\s?(\d{2,4})\s?(\d{2,4})\s?(\d{2,4})\s?(\d{2,4})$#', $sanitizedVal)){
						$this->errorBag->append_to_log($errorTag, $shopTranslator->translate('pz.api.trans.dict.forms.errors.fax'));
					}
					$returnData     =  $sanitizedVal;
					break;
				
				case "int":
					if(!$isNullable  && !preg_match('#^(\-?\d{1,})(\d)?#', $sanitizedVal)){
						$this->errorBag->append_to_log($errorTag, $shopTranslator->translate('pz.api.trans.dict.forms.errors.num'));
					}
					$returnData     = !empty($sanitizedVal) ? intval($sanitizedVal) : $sanitizedVal;
					break;
				
				case "num":
					if(!$isNullable  && !preg_match('#^([\-\d]{1,})(\.)?(\d)*$#', $sanitizedVal)){
						$this->errorBag->append_to_log($errorTag, $shopTranslator->translate('pz.api.trans.dict.forms.errors.num'));
					}
					$returnData     = !empty($sanitizedVal) ?
													( is_float($sanitizedVal) || is_double($sanitizedVal) ? doubleval($sanitizedVal) : intval($sanitizedVal))
													: $sanitizedVal;
					break;
				
				case "bool":
            if(!$isNullable  && !is_bool($sanitizedVal) && !in_array($sanitizedVal, [0, 1, '0', '1',])){
                $this->errorBag->append_to_log($errorTag, $shopTranslator->translate('pz.api.trans.dict.forms.errors.bool'));
            }
					$returnData     = !empty($sanitizedVal) ? (int)$sanitizedVal : $sanitizedVal;
					break;
				
				case "date":
					if(!$isNullable  && !preg_match('#(\d{2,4})([\.\-\/])(\d{2})([\.\-\/])(\d{2,4})#', $sanitizedVal)){
						$this->errorBag->append_to_log($errorTag, $shopTranslator->translate('pz.api.trans.dict.forms.errors.date'));
					}
					$returnData     =  $sanitizedVal;
					$returnData     = $returnDateTimeObj ? new \DateTime($returnData) : $returnData;
					break;
				
				case "datetime":
					# if(!preg_match('#(\d{4})(\-)(\d{2})(\-)(\d{2})[\sT]?((\d{2}):(\d{2})(:?\d*?))?#', $sanitizedVal)){
					# if(!preg_match('#(\d{2,4})([.-/])(\d{2})([.-/])(\d{2,4})([\sT]?\d{2}:\d{2}(:?\d*?))?#', $sanitizedVal)){
					if(!$isNullable  && !preg_match('#(\d{2,4})([\.\-\/])(\d{2})([\.\-\/])(\d{2,4})([\sT]?\d{2}:\d{2}(:?\d*?))?#', $sanitizedVal)){
						$this->errorBag->append_to_log($errorTag, $shopTranslator->translate('pz.api.trans.dict.forms.errors.date'));
					}
					$returnData     =  preg_replace("# ?T ?#", " ", $sanitizedVal);
					$returnData     = $returnDateTimeObj ? new \DateTime($returnData) : $returnData;
					break;
				
				case "string":
					if(!$isNullable  && !preg_match('#(^[a-zA-Z])([\w\.\-\(\)\ ])*\w+$#uis', $sanitizedVal)){
						$this->errorBag->append_to_log($errorTag,  $shopTranslator->translate('pz.api.trans.dict.forms.errors.string'));
					}
					$returnData     =  $sanitizedVal;
					break;
				
				case "misc":
					if(!$isNullable  && !preg_match('#(^[a-zA-z])?([\w\.\-\ ])*\w*$#ui', $sanitizedVal)){
						$this->errorBag->append_to_log($errorTag,  $shopTranslator->translate('pz.api.trans.dict.forms.errors.string'));
					}
					$returnData     =  $sanitizedVal;
					break;
				
				case "al_num":
					if(!$isNullable  && !preg_match('#(^[a-z0-9\-\+])([\w\.\-\\:\;\+\(\)\ ])*\w*$#ui', $sanitizedVal)){
						$this->errorBag->append_to_log($errorTag,  $shopTranslator->translate('pz.api.trans.dict.forms.errors.string'));
					}
					$returnData     =  $sanitizedVal;
					break;
				
				case "hex":
					if(!$isNullable  && !preg_match('#(^\#)([a-f0-9]{3}){1,2}$#ui', $sanitizedVal)){
						$this->errorBag->append_to_log($errorTag,  $shopTranslator->translate('pz.api.trans.dict.forms.errors.hex'));
					}
					$returnData     =  $sanitizedVal;
					break;
				
				case "rgb":
				case "rgba":
					if(!$isNullable  && !preg_match('#^RGB(A?)\(([0-9]{1,3}\ ?,\ ?){2}([0-9]{1,3}),?\ ?[\.\d]*\)$#ui', $sanitizedVal)){
						$this->errorBag->append_to_log($errorTag,  $shopTranslator->translate('pz.api.trans.dict.forms.errors.rgb'));
					}
					$returnData     =  $sanitizedVal;
					break;
				
				case "city":
				case "state":
					if(!$isNullable  && !preg_match('#(^[a-z0-9\-\+])([\w\.\-\\:\;\+\(\)\/\ ])*\w*$ui#', $sanitizedVal)){
						$this->errorBag->append_to_log($errorTag,  $shopTranslator->translate('pz.api.trans.dict.forms.errors.string'));
					}
					$returnData     =  $sanitizedVal;
					break;
				
				case "password":
					if(!$isNullable  && !preg_match('#(^[a-z0-9\-\+_\}\{\(\)])([\w\.\-\\:\;\+\(\)\/\}\{\(\)\ ])*\w*$ui#', $sanitizedVal)){
						$this->errorBag->append_to_log($errorTag,  $shopTranslator->translate('pz.api.trans.dict.forms.errors.string'));
					}
					$returnData     =  $sanitizedVal;
					break;
				
				case "url":
          if(!$isNullable  && !preg_match('#^(https?\:\/\/)?(www)?[a-z0-9\-_]*\.[a-z0-9\.\-_]*$ui#', $sanitizedVal)){
              $this->errorBag->append_to_log($errorTag,  $shopTranslator->translate('pz.api.trans.dict.forms.errors.url'));
          }
					$returnData     =  $sanitizedVal;
					break;
				
				case "email":
					if (!$isNullable  && !filter_var($sanitizedVal, FILTER_VALIDATE_EMAIL)) {
						$this->errorBag->append_to_log($errorTag, $shopTranslator->translate('pz.api.trans.dict.forms.errors.email'));
					}
					$returnData     =  $sanitizedVal;
					break;
				
				case "non_empty":
					if (!$isNullable  && !strlen($sanitizedVal)) {
						$this->errorBag->append_to_log($errorTag, $shopTranslator->translate('pz.api.trans.dict.forms.errors.non_empty'));
					}
					$returnData     =  $sanitizedVal;
					break;
				
				case "raw":
				case "none":
					$sanitizedVal   = $this->sanitize($widgetValue, true);
					$returnData     =  $sanitizedVal;
					break;
				
				case "html":
				case "pass_through":
				default:
					$sanitizedVal   = $this->sanitize($widgetValue, false);
					$returnData     = $sanitizedVal;
					break;
			}
			
			$this->cleanData[$errorTag]      = $sanitizedVal;
			return $returnData;
		}
		
		/**
		 * @param $data
		 * @param bool $strip_tags
		 *
		 * @return int|string
		 */
		private function sanitize($data, $strip_tags=false) {
			if($data == '0'){
				return 0;
			}
			if($strip_tags){
				$data = strip_tags($data);
			}
			return htmlspecialchars(stripslashes( trim($data) ) );
		}
		
		protected function validateExtreme(Widget $instance, $postVars=null) {
			$validationStatus           = $instance->validateWidget($postVars[$instance->config['name']], $instance->config['validationStrategy'], $instance->config['label']);
			$instance->config['value']  = $validationStatus;
			if(!empty($err = $instance->errorBag->getErrors())){
				$instance->config['errorMessage']   = $err[$instance->config['label']];
				$instance->config['invalid']        = true;
			}
			$instance->build($this->fieldType);
			return sizeof($err);    //  ['widget' => $instance->build()->render(), 'error'=> sizeof($err)];
		}
		/**
		 * @return string
		 */
		public function getHash(): string {
			return $this->hash;
		}
		
		/**
		 * @return array|mixed
		 */
		public function getConfig(): ?array {
			return $this->config;
		}
        
    /**
     * @return mixed
     */
    public function getWidget() {
        return $this->widget;
    }
    
    /**
     * @return mixed
     */
    public function getFieldType() {
        return $this->fieldType;
    }
    
    /**
     * @param mixed $fieldType
     */
    public function setFieldType( $fieldType ): void {
        $this->fieldType = $fieldType;
    }
    
    
	}
