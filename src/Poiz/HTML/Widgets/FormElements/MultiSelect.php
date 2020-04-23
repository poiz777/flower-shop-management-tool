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
	
	class MultiSelect extends Widget {
        
        protected $fieldType = 'multi_select';
        
        /**
         * Text constructor.
         *
         * @param array $config
         * @param array $options
         */
        public function __construct( array $config, array $options = [] ) {
            $this->defaultConfig['validationStrategy'] = static::VALIDATION_STRATEGY['STRING'];
            if ( isset( $config['validationStrategy'] ) ) {
                try {
                    $config['validationStrategy'] = static::VALIDATION_STRATEGY[ strtoupper( $config['validationStrategy'] ) ];
                } catch ( \Exception $e ) {
                    // TODO: SET A DEFAULT VALIDATION STRATEGY OR LEAVE AS IS...
                }
            }
            
            $this->config         = array_merge( $this->defaultConfig, $config );
            $this->config['type'] = $this->fieldType;
            
            $this->options  = $options;
            $this->errorBag = new ErrorLogger();
            $this->hash     = $this->generateWidgetHash( 4 );
            $this->initializeGlobalStore();
            $this->buildWidget();
        }
        
        public function render() {
            return $this->widget;   // $this->getMultiChooserPayload();   //
        }
        
        protected function buildWidget() {
            $this->writeOptionsJSFile( $this->getWritableJSOptions( $this->options ) );
            $this->widget = $this->getMultiSelectPayload();
            $this->widget = $this->getMultiChooserPayload();
            
            return $this;
        }
        
        private function writeOptionsJSFile( $jsonData ) {
            $outputData = "var multiSelectSuggestions = {$jsonData};";
            file_put_contents( __DIR__ . "/../Scripts/suggestions-{$this->config['name']}.js", $outputData );
        }
        
        private function getWritableJSOptions( $options, $jsonEncoded = true ) {
            $objOptions                = new \stdClass();
            $objOptions->suggestions   = $options;
            $objOptions->fieldName     = $this->config['name'];
            $objOptions->defaultValue  = $this->config['value'];
            $objOptions->className     = $this->config['class'];
            $objOptions->widgetDataKey = 'values_multi_choice_' . $this->hash;
            $objOptions->donorRef      = 'pzOptionsDonor';
            $objOptions->receiverRef   = 'pzChosenOptions';
            $objOptions->cssClass      = 'pz-drop-down-field form-control';
            $objOptions->mainFieldID   = 'pz-drop-down-field-main';
            
            $objOptions->appRootID = 'APP-ID-' . $this->hash;
            $jsonData              = json_encode( $objOptions, JSON_PRETTY_PRINT );
            
            return $jsonEncoded ? $jsonData : $objOptions;
            
        }
        
        private function getMultiSelectPayload() {
            $widget = "";
            if ( isset( $this->config['addLabel'] ) && $this->config['addLabel'] ) {
                if ( $this->config['labelType'] == 'normal' ) {
                    $labelClasses = ( isset( $this->config['errorMessage'] ) && $this->config['errorMessage'] ) ? 'pz-error has-error  pz-label' : 'pz-label';
                    $label        = empty( trim( $this->config['label'] ) ) ? 'Please Provide Label in Widget Config Class' : trim( $this->config['label'] );
                    $widget       .= "<label class='{$labelClasses}' for='{$this->config['id']}'>{$label}";
                    if ( isset( $this->config['inputFieldHint'] ) ) {
                        $widget .= $this->config['inputFieldHint'];
                    }
                    $widget .= "</label>";
                }
            }
            
            if ( isset( $this->config['errorMessage'] ) && $this->config['errorMessage'] ) {
                $widget               .= "<aside class='pz-error-pod pz-error has-error'>{$this->config['errorMessage']}</aside>";
                $jsOptions            = $this->getWritableJSOptions( $this->options, false );
                $jsOptions->className = $jsOptions->className . " pz-error has-error";
                $jsonData             = json_encode( $jsOptions, JSON_PRETTY_PRINT );
                $outputData           = "var suggestions = {$jsonData};";
                file_put_contents( __DIR__ . "/../Scripts/suggestions-{$this->config['name']}.js", $outputData );
            }
            $css1    = file_get_contents( __DIR__ . '/../Scripts/multi-select.css' );
            $script0 = file_get_contents( __DIR__ . "/../Scripts/suggestions-{$this->config['name']}.js" );
            $script1 = file_get_contents( __DIR__ . '/../Scripts/multi-select-1.js' );
            $script2 = file_get_contents( __DIR__ . '/../Scripts/multi-select-2.js' );
            $script3 = file_get_contents( __DIR__ . '/../Scripts/multi-select-3.js' );
            $scripts = <<<SCPT
			
			<style type="text/css" media="all" rel="stylesheet">{$css1}</style>
            <script id="script-0-{$this->hash}">
                {$script0}
            </script>
			{$widget}
			<div id="APP-ID-{$this->hash}"></div>
<script id="script-1-{$this->hash}">
	{$script1}
</script>
<script id="script-2-{$this->hash}">
	{$script2}
</script>
<script id="script-3-{$this->hash}">
	{$script3}
</script>
SCPT;
            
            return $scripts;
            
        }
        
        function getMultiChooserPayload() {
            $codeBase = __DIR__ . '/../Scripts';
            $widget   = "<label class='' for=''>Some Label</label>";
            
            $css1    = file_get_contents( $codeBase . '/multi-select.css' );
            $script0 = file_get_contents( $codeBase . "/suggestions-interests.js" );
            $script1 = file_get_contents( $codeBase . '/multi-select-1.js' );
            $script2 = file_get_contents( $codeBase . '/multi-select-2.js' );
            $script3 = file_get_contents( $codeBase . '/multi-select-3.js' );
            $scripts = <<<SCPT
                <style type="text/css" media="all" rel="stylesheet">{$css1}</style>
    <script id="script-0-{$this->hash}"> {$script0} </script>
                {$widget}
                <div id="django"></div>
                <div id="APP-ID-39C3-6015-AD3C-D5DC-311C-864B-2C82-DF1A"></div>
                <div id="APP-ID-5236-FA8D-CBAA-C26A-113D-B171-9CA1-D92F"></div>
    <script id="script-1-{$this->hash}">{$script1}</script>
    <script id="script-2-{$this->hash}">{$script2}</script>
    <script id="script-3-{$this->hash}">{$script3}</script>
SCPT;
            
            return $scripts;
            
            
        }
        
        
        
        function getMultiChooserPayload2() {
            $codeBase = __DIR__ . '/../Scripts';
            $widget   = "<label class='' for=''>Some Label</label>";
            
            $css1    = file_get_contents( $codeBase . '/multi-select.css' );
            $script0 = file_get_contents( $codeBase . "/suggestions-interests.js" );
            $script1 = file_get_contents( $codeBase . '/multi-select-aio.js' );
            //$script1 = file_get_contents( $codeBase . '/multi-select-1.js' );
            //$script2 = file_get_contents( $codeBase . '/multi-select-2.js' );
            //$script3 = file_get_contents( $codeBase . '/multi-select-3.js' );
            $scripts = <<<SCPT
                <style type="text/css" media="all" rel="stylesheet">{$css1}</style>
    <script id="script-0-{$this->hash}"> {$script0} </script>
                {$widget}
                <div id="APP-ID-39C3-6015-AD3C-D5DC-311C-864B-2C82-DF1A"></div>
                <div id="APP-ID-5236-FA8D-CBAA-C26A-113D-B171-9CA1-D92F"></div>
    <script id="script-1-{$this->hash}">{$script1}</script>
SCPT;
            
            return $scripts;
            
            
        }
    }
