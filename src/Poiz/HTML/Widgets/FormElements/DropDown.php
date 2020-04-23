<?php
	/**
	 * Created by PhpStorm.
	 * User: poiz
	 * Date: 09.03.19
	 * Time: 17:57
	 */
	
	namespace  App\Poiz\HTML\Widgets\FormElements;
	
	
	use  App\Poiz\HTML\Widgets\FormHelpers\ErrorLogger;
	use  App\Poiz\HTML\Widgets\Widget;
	
	class DropDown extends Widget {
		
		protected  $fieldType  = 'drop_down';
		/**
		 * Text constructor.
		 *
		 * @param array $config
		 * @param array $options
		 */
		public function __construct(array $config, array $options =[]) {
			$this->defaultConfig['validationStrategy']  = static::VALIDATION_STRATEGY['STRING'];
			if(isset($config['validationStrategy'])){
				try{
					$config['validationStrategy']   = static::VALIDATION_STRATEGY[strtoupper($config['validationStrategy'])];
				}catch (\Exception $e){
					// TODO: SET A DEFAULT VALIDATION STRATEGY OR LEAVE AS IS...
				}
			}
			
			$this->config                       = array_merge($this->defaultConfig, $config);
			$this->config['type']               = $this->fieldType;
			
			$this->options  = $options;
			$this->errorBag = new ErrorLogger();
			$this->hash     = $this->generateWidgetHash(4);
			
			$this->initializeGlobalStore();
			$this->buildWidget();
		}
		
		public function render() {
			return $this->widget;
		}
		
		protected function buildWidget() {
			$this->writeOptionsJSFile($this->getWritableJSOptions($this->options));
			$this->widget   = $this->getDropDownPayload();
			return $this;
		}
		
		private function writeOptionsJSFile($jsonData){
			$outputData                 = "var suggestions = {$jsonData};";
			// file_put_contents(__DIR__ . "/../Scripts/suggestions-{$this->config['name']}.js", $outputData);
            file_put_contents(__DIR__ . "/../Scripts/suggestions-{$this->config['name']}.js", $outputData);
		}
		
		private function getWritableJSOptions($options, $jsonEncoded=true){
      if($this->config['formKey'] && isset($this->config['name'])){
          $fieldName  =  $this->config['formKey']  . "[{$this->config['name']}]";
      }else{
          $fieldName  = $this->config['name'];
      }
			$readOnly                   = $this->config['readOnly'] ? ' pz-read-only' : '';
			$objOptions                 = new \stdClass();
			$objOptions->suggestions    = $options;
			$objOptions->fieldName      = $fieldName;
			$objOptions->defaultValue   = $this->config['value'];
			$objOptions->className      = $this->config['class'] . $readOnly;
			$objOptions->appRootID      = 'APP-ID-' . $this->hash;
			$objOptions->placeholder    = $this->config['placeholder'];
			$objOptions->ignoredKeySuffix = '@@@';
			$jsonData                     = json_encode($objOptions, JSON_PRETTY_PRINT);
			return $jsonEncoded ? $jsonData : $objOptions;
		}
		
		private function getDropDownPayload(){
			$widget   = "";
			if(isset($this->config['addLabel']) && $this->config['addLabel']){
				if($this->config['labelType'] == 'normal') {
					$labelClasses   = (isset($this->config['errorMessage']) && $this->config['errorMessage']) ? 'pz-error has-error  pz-label': 'pz-label';
					$label          = empty(trim($this->config['label'])) ? 'Please Provide Label in Widget Config Class' : trim($this->config['label']);
					$widget  .= "<label class='{$labelClasses}' for='{$this->config['id']}'>{$label}";
					if(isset($this->config['inputFieldHint'])){ $widget           .= $this->config['inputFieldHint']; }
					$widget  .= "</label>";
				}
			}
			
			if(isset($this->config['errorMessage']) && $this->config['errorMessage']){
				$widget    .= "<aside class='pz-error-pod pz-error has-error'>{$this->config['errorMessage']}</aside>";
				$jsOptions  = $this->getWritableJSOptions($this->options, false);
				$readOnly   = $this->config['readOnly'] ? ' pz-read-only' : '';
				$jsOptions->className   = $jsOptions->className . " pz-error has-error{$readOnly}";
				$jsonData               = json_encode($jsOptions, JSON_PRETTY_PRINT);
				$outputData             = "var suggestions = {$jsonData};";
				file_put_contents(__DIR__ . "/../Scripts/suggestions-{$this->config['name']}.js", $outputData);
			}
			
			$css1    = file_get_contents(__DIR__ . '/../Scripts/dd.css');
			$script0 = file_get_contents(__DIR__ . "/../Scripts/suggestions-{$this->config['name']}.js");
			$script1 = file_get_contents(__DIR__ . '/../Scripts/dd1.js');
			$script2 = file_get_contents(__DIR__ . '/../Scripts/dd2.js');
			$script3 = file_get_contents(__DIR__ . '/../Scripts/dd3.js');
			$scripts =<<<SCPT
			<style type="text/css" media="all" rel="stylesheet">{$css1}</style>
			{$widget}
			<div id="APP-ID-{$this->hash}"></div>
<script id="script-1-{$this->hash}">
	{$script0}
</script>
<script id="script-2-{$this->hash}">
	{$script1}
</script>
<script id="script-3-{$this->hash}">
	{$script2}
</script>
<script id="script-4-{$this->hash}">
	{$script3}
</script>
SCPT;
			return $scripts;
			
		}
		
		
	}
