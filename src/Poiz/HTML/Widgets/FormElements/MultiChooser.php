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
	
	class MultiChooser extends Widget {
		
		protected  $fieldType  = 'multi_chooser';
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
			
			$this->config           = array_merge($this->defaultConfig, $config);
			$this->config['type']   = $this->fieldType;
			
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
			$this->widget   = $this->getMultiChooserPayload();
			return $this;
		}
		
		private function writeOptionsJSFile($jsonData){
			$outputData                 = "var suggestions = {$jsonData};";
			file_put_contents(__DIR__ . "/../Scripts/suggestions-{$this->config['name']}.js", $outputData);
		}
		
		private function getWritableJSOptions($options, $jsonEncoded=true){
			$objOptions                 = new \stdClass();
			$objOptions->suggestions    = $options;
			$objOptions->fieldName      = $this->config['name'];
			$objOptions->defaultValue   = $this->config['value'];
			$objOptions->className      = $this->config['class'];
			$objOptions->widgetDataKey  = 'values_multi_choice_' . $this->hash;
			$objOptions->donorRef       = 'pzOptionsDonor';
			$objOptions->receiverRef    = 'pzChosenOptions';
			$objOptions->cssClass       = 'pz-drop-down-field form-control';
			$objOptions->mainFieldID    = 'pz-drop-down-field-main';
			
			$objOptions->appRootID      = 'APP-ID-' . $this->hash;
			$jsonData                   = json_encode($objOptions, JSON_PRETTY_PRINT);
			return $jsonEncoded ? $jsonData : $objOptions;
			
		}
		
		private function getMultiChooserPayload(){
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
				$jsOptions->className   = $jsOptions->className . " pz-error has-error";
				$jsonData               = json_encode($jsOptions, JSON_PRETTY_PRINT);
				$outputData             = "var suggestions = {$jsonData};";
				file_put_contents(__DIR__ . "/../Scripts/suggestions-{$this->config['name']}.js", $outputData);
			}
   
			$css1    = file_get_contents(__DIR__ . '/../Scripts/multi-chooser.css');
			$script0 = file_get_contents(__DIR__ . "/../Scripts/suggestions-{$this->config['name']}.js");
			$script1 = file_get_contents(__DIR__ . '/../Scripts/multi-chooser-1.js');
			$script2 = file_get_contents(__DIR__ . '/../Scripts/multi-chooser-2.js');
			$scripts =<<<SCPT
			
			<style type="text/css" media="all" rel="stylesheet">{$css1}</style>
			{$widget}
			<div id="APP-ID-{$this->hash}">Will be replaced!!!</div>
<script id="script-0-{$this->hash}">
	{$script0}
</script>
<script id="script-1-{$this->hash}">
	{$script1}
</script>
<script id="script-2-{$this->hash}">
	{$script2}
</script>
SCPT;
			return $scripts;
			
		}
		
		function getMultiChooserPayload2(){
			$widget  = "<label class='' for=''>Some Label</label>";
			$css1    = file_get_contents(__DIR__ . '/../Scripts/multi-chooser.css');
			$script0 = file_get_contents(__DIR__ . "/../Scripts/suggestions-interests.js");
			$script1 = file_get_contents(__DIR__ . '/../Scripts/multi-chooser-1.js');
			$script2 = file_get_contents(__DIR__ . '/../Scripts/multi-chooser-2.js');
			$scripts =<<<SCPT
                
                <style type="text/css" media="all" rel="stylesheet">{$css1}</style>
                {$widget}
                <div id="APP-ID-5236-FA8D-CBAA-C26A-113D-B171-9CA1-D92F">Will be replaced!!!</div>
    <script id="script-0">
        {$script0}
    </script>
    <script id="script-1">
        {$script1}
    </script>
    <script id="script-2">
        {$script2}
    </script>
SCPT;
			return $widget . $scripts;
			
		}
		
	}
	
	
/*

<!--
<link href=/a/css/multi-chooser.css rel=preload as=style>
<link href=/a/js/Scripts/multi-chooser-2.js rel=preload as=script>
<link href=/a/js/Scripts/multi-chooser-1.js rel=preload as=script>
<link href=/a/css/app.d0d05f46.css rel=stylesheet>
-->
// /Users/poiz/web_stack/htdocs/code-samples.dvp/Poiz/Codes/Widgets/Scripts
appRootID: "app",
widgetDataKey: "values_multi_choice",
fieldName: "personal_values",
donorRef: "pzOptionsDonor",
receiverRef: "pzChosenOptions",
defaultValue: "SELECT YOUR MORAL IDEAL",
cssClass: "pz-drop-down-field form-control",
mainFieldID: "pz-drop-down-field-main"
*/
