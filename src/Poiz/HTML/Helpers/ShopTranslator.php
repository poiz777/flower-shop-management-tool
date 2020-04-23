<?php
    /**
     * Created by PhpStorm.
     * User: poiz
     * Date: 12.04.19
     * Time: 08:24
     */
    
    namespace App\Poiz\HTML\Helpers;
    
    
    use Symfony\Contracts\Translation\TranslatorInterface;


    /**
     * Class ShopTranslator
     * @package App\Poiz\HTML\Helpers
     */
    class ShopTranslator {
    
        /**
         * @var \App\Poiz\HTML\Helpers\ShopTranslator
         */
        protected static $instance;
        
        /**
         * @var TranslatorInterface
         */
        protected $translator;
	
	    /**
	     * ShopTranslator constructor.
	     *
	     * @param \Symfony\Contracts\Translation\TranslatorInterface $translator
	     */
	    public function __construct( \Symfony\Contracts\Translation\TranslatorInterface $translator ) {
		    $this->translator = $translator;
            static::$instance   = $this;
	    }
	
	
        
        public static function getInstance() {
            if(!static::$instance){
                static::$instance = new ShopTranslator();
            }
            return static::$instance;
        }
        
    
        protected static $PZ_SHOP_TRANSLATION_LOCALE    = NULL;   // NULL;
        const PZ_SHOP_TRANSLATION_SOURCE    = "ShopTranslationDictionary";
        const PZ_SHOP_TRANSLATION_PACKAGE   = "Poiz.Shop";
    
        /**
         * @param string $keyToTranslate
         *
         * @return string Translated label or source label / ID key
         */
        public function translate(?string $keyToTranslate) {
	        return $this->translator->trans($keyToTranslate);
        }
    
        /**
         * @param TranslatorInterface $translator
         */
        public function injectTranslator( TranslatorInterface $translator ) {
            $this->translator = $translator;
        }
    
        /**
         * @return string
         */
        public static function getPzShopTranslationLocale(): string {
            return self::$PZ_SHOP_TRANSLATION_LOCALE;
        }
    
        /**
         * @param string $pzShopTranslationLocale
         */
        public static function setPzShopTranslationLocale( string $pzShopTranslationLocale ): void {
            self::$PZ_SHOP_TRANSLATION_LOCALE = $pzShopTranslationLocale;
        }
    
        /**
         */
        public static function setPzShopTranslationLocaleFromRequest(ActionRequest $request = null ) {
            $locale         = null;
            $httpRequest    =  $request->getHttpRequest(); //  !$request ? $this->actionRequest->getHttpRequest() : $request->getHttpRequest();
            $requestParts   = array_filter(explode("/", $httpRequest->getUri()->getPath()), function($part){
                return !!trim($part);
            });
    
            if(in_array(current($requestParts), ['de', 'fr', 'en']) ){
                $locale = current($requestParts);
                static::$PZ_SHOP_TRANSLATION_LOCALE = $locale;
            }
            return $locale;
        }
        
        
        
    }
