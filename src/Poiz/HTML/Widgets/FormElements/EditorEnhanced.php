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
	
	class EditorEnhanced extends Widget {
	protected  $fieldType  = 'EditorEnhanced';
		/**
		 * Text constructor.
		 *
		 * @param array $config
		 * @param array $options
		 */
		public function __construct(array $config, array $options =[]) {
			$this->defaultConfig['validationStrategy']  = static::VALIDATION_STRATEGY['EMAIL'];
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
			$this->widget   = $this->getEditorPayload();
			return $this;
		}
		
		private function getEditorPayload(){
			$widget       = "";
			if(isset($this->config['addLabel']) && $this->config['addLabel']){
				if($this->config['labelType'] == 'normal') {
					$labelClasses   = (isset($this->config['errorMessage']) && $this->config['errorMessage']) ? 'pz-error has-error  pz-label': 'pz-label';
					$label          = empty(trim($this->config['label'])) ? 'Please Provide Label in Widget Config Class' : trim($this->config['label']);
					$widget  .= "<label class='{$labelClasses}' for='{$this->config['id']}'>{$label}";
					if(isset($this->config['inputFieldHint'])){ $widget .= $this->config['inputFieldHint']; }
					$widget  .= "</label>";
				}
			}
			
			if(isset($this->config['errorMessage']) && $this->config['errorMessage']){
				$widget    .= "<aside class='pz-error-pod pz-error has-error'>{$this->config['errorMessage']}</aside>";
			}
			
			$extraClass   = "has-pz-editor tinymce";
			$editorWidget = $this->craftWidget($extraClass);
			$finalWidget  = "{$widget} <div id=\"APP-ID-{$this->hash}\">{$editorWidget}</div>";
			
			if($this->injectScripts){
				$finalWidget .=<<<SCPT
<script id="script-1-{$this->hash}">
//<![CDATA[

//]]>
</script>
SCPT;
			}
			return $finalWidget;
		}
		
		protected function craftWidget($extraClass="has-pz-editor tinymce") {
			$widgetClasses    = isset($this->config['class']) ? $this->config['class'] : 'pz-widget';
			$widgetClasses    = (isset($this->config['errorMessage']) && $this->config['errorMessage']) ? "pz-error has-error {$widgetClasses}": $widgetClasses;
			$editorWidget     = "<textarea ";
			
			if(isset($this->config['id'])){ $editorWidget .= " id=\"{$this->config['id']}\""; }
			if($this->config['formKey'] && isset($this->config['name'])){
				$editorWidget  .= " name=\"" .  $this->config['formKey'] ."[" . $this->config['name'] . "]\"";
			}else{
				$editorWidget  .= " name=\"{$this->config['name']}\"";
			}
			$editorWidget    .= " class=\"{$widgetClasses} {$extraClass}\"";
			if(isset($this->config['invalid']) && $this->config['invalid']){ $editorWidget  .= " style=\"border-color:red; color:red;\""; }
			if(isset($this->config['placeholder'])){ $editorWidget  .= " placeholder=\"{$this->config['placeholder']}\""; }
			if(isset($this->config['data'])){ $editorWidget         .= " {$this->config['data']}"; }
			if(isset($this->config['type'])){ $editorWidget         .= " data-widget-type=\"{$this->config['type']}\""; }
			if(isset($this->config['readOnly']) && $this->config['readOnly']){ $editorWidget  .= " readonly"; }
			if(isset($this->config['disabled']) && $this->config['disabled']){ $editorWidget  .= " disabled=\"disabled\""; }
			$editorWidget    .= " data-hash='{$this->hash}' data-pz-editor='1' ";
			$editorWidget    .= ">";
			
			if(isset($this->config['value'])){
				$editorWidget  .= $this->config['value'];
			}
			$editorWidget    .= "</textarea>";
			return $editorWidget;
		}
	}
