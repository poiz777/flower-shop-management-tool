<?php
	/**
	 * Created by PhpStorm.
	 * User: Poiz Campbell
	 * Date: 09.01.2017
	 * Time: 17:57
	 */
	
	namespace  App\Poiz\HTML\Widgets\FormElements;
	
	
	use  App\Poiz\HTML\Widgets\FormHelpers\ErrorLogger;
	use  App\Poiz\HTML\Widgets\Widget;
	
	class H2 extends Widget {
		
		protected  $fieldType  = 'h2';
		/**
		 * H2 constructor.
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
			$this->config['value']              = ($this->config['rawContent']) ? $this->config['rawContent'] : $this->config['value'];
			
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
			$this->build($this->fieldType, true);
			return $this;
		}
		
		
		
	}
