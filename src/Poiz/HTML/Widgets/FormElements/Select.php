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
	
	class Select extends Widget {
		
		protected  $fieldType  = 'text';
		/**
		 * Text constructor.
		 *
		 * @param array $config
		 * @param array $options
		 */
		public function __construct(array $config, array $options =[]) {
			$this->defaultConfig['validationStrategy']  = static::VALIDATION_STRATEGY['MISC'];
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
            
            $this->widget  .= "<select ";
            if(isset($this->config['id'])){ $this->widget           .= " id=\"{$this->config['id']}\""; }
            if($this->config['formKey'] && isset($this->config['name'])){
                $this->widget         .= " name=\"" .  $this->config['formKey'] ."[" . $this->config['name'] . "]\"";
            }else{
                $this->widget         .= " name=\"{$this->config['name']}\"";
            }
            $this->widget                                           .= " class=\"{$widgetClasses}\"";
            if(isset($this->config['invalid']) && $this->config['invalid']){ $this->widget  .= " style=\"border-color:red; color:red;\""; }
            if(isset($this->config['placeholder'])){ $this->widget  .= " placeholder=\"{$this->config['placeholder']}\""; }
            if(isset($this->config['data'])){ $this->widget         .= " {$this->config['data']}"; }
            if(isset($this->config['type'])){ $this->widget         .= " data-widget-type=\"{$this->config['type']}\""; }
            if(isset($this->config['readOnly']) && $this->config['readOnly']){ $this->widget  .= " readonly"; }
            if(isset($this->config['disabled']) && $this->config['disabled']){ $this->widget  .= " disabled=\"disabled\""; }
            
            $this->widget.= " data-hash='{$this->hash}'>";
            if($this->options){
                foreach ($this->options as $value=>$label){
                    $selectedFlag   = $value == $this->config['value'] ? "selected=\"selected\"" : "";
                    $selectedFlag   = is_bool($this->config['value']) && $value == (int)$this->config['value'] ? "selected=\"selected\"" : $selectedFlag;
                    
                    $this->widget.= "<option value='{$value}' {$selectedFlag}>{$label}</option>";
                }
            }
            $this->widget.= "</select>";
            #dump($this->fieldValue);
            #dump($this->config);
			return $this;
		}
		
		
		
	}
