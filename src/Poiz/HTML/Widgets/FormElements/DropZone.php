<?php
    /**
     * Created by PhpStorm.
     * User: Poiz Campbell
     * Date: 09.01.2017
     * Time: 17:57
     */
    
    namespace  App\Poiz\HTML\Widgets\FormElements;
    
    
    use  App\Poiz\HTML\FormEntity\FormObjectLexer;
    use  App\Poiz\HTML\Helpers\ShopTranslator;
    use  App\Poiz\HTML\Images\ThumbIconBox;
    use  App\Poiz\HTML\Widgets\FormHelpers\ErrorLogger;
    use  App\Poiz\HTML\Widgets\Widget;
    
    /*
    defined( "FLOW_PATH_ROOT" ) or define( "FLOW_PATH_ROOT",   PZ_JOBS_PLG_PATH );
    defined( "FLOW_PATH_PACKAGES" ) or define( "FLOW_PATH_PACKAGES",  PZ_JOBS_PLG_PATH );
    defined( "EXT_URI" ) or define( "EXT_URI",   PZ_JOBS_PLG_URL );
    defined( "EXT_PATH" ) or define( "EXT_PATH", PZ_JOBS_PLG_PATH . 'Application/Poiz.Shop/' );
    defined( "AJAX_URL" ) or define( "AJAX_URL", EXT_URI . '/Ajax.php' );
    */
    class DropZone extends Widget {
        
        const PACKAGE_NAME = 'Poiz.Shop';
        protected $fieldType = 'drop_zone';
        /**
         * @var ShopTranslator
         */
        protected $shopTranslator;
        
        
        /**
         * DropZone constructor.
         *
         * @param array $config
         * @param array $options
         */
        public function __construct( array $config, array $options = [] ) {
            $this->shopTranslator                      = new ShopTranslator();
            $this->defaultConfig['validationStrategy'] = static::VALIDATION_STRATEGY['STRING'];
            if ( isset( $config['validationStrategy'] ) ) {
                try {
                    $config['validationStrategy'] = static::VALIDATION_STRATEGY[ strtoupper( $config['validationStrategy'] ) ];
                } catch ( \Exception $e ) {
                    // TODO: SET A DEFAULT VALIDATION STRATEGY OR LEAVE AS IS...
                }
            }
            
            $this->config          = array_merge( $this->defaultConfig, $config );
            $this->config['type']  = $this->fieldType;
            $this->config['value'] = ( isset( $this->config['rawContent'] ) && $this->config['rawContent'] ) ? $this->config['rawContent'] : $this->config['value'];
            
            $this->options  = $options;
            $this->errorBag = new ErrorLogger();
            $this->hash     = $this->generateWidgetHash( 4 );
            $this->initializeGlobalStore();
            $this->buildWidget();
        }
        
        public function render() {
            return $this->widget;
        }
        
        protected function buildWidget() {
            $errorClass   = "";
            $this->widget = "";
            if ( isset( $this->config['addLabel'] ) && $this->config['addLabel'] ) {
                if ( $this->config['labelType'] == 'normal' ) {
                    $labelClasses = ( isset( $this->config['errorMessage'] ) && $this->config['errorMessage'] ) ? 'pz-error has-error  pz-label' : 'pz-label';
                    $label        = empty( trim( $this->config['label'] ) ) ? 'Please Provide Label in Widget Config Class' : trim( $this->config['label'] );
                    $this->widget .= "<label class='{$labelClasses}' for='{$this->config['id']}'>{$label}";
                    if ( isset( $this->config['inputFieldHint'] ) ) {
                        $this->widget .= $this->config['inputFieldHint'];
                    }
                    $this->widget .= "</label>";
                }
            }
            
            if ( isset( $this->config['errorMessage'] ) && $this->config['errorMessage'] ) {
                $errorClass   = " pz-error has-error";
                $this->widget .= "<aside class='pz-error-pod{$errorClass}'>{$this->config['errorMessage']}</aside>";
            }
            
            $ddFeedBack   = $this->buildDropZoneFeedBack( FLOW_PATH_ROOT . "etc/files/Poiz.Shop/tmp/tmp.txt" );
            $hiddenField  = "<input type='hidden' id='{$this->config['name']}' name='{$this->config['name']}' class='hidden pz-hidden' value='{$this->config['value']}' />\n";
	          $lbl        = empty( trim( $this->config['dzUploadInfo'] ) ) ? 'Please Provide Label in Widget Config Class' : trim( $this->config['dzUploadInfo'] );
	          $lblHint    = empty( trim( $this->config['dzUploadHint'] ) ) ? 'Drag & Drop 2 Upload ' : trim( $this->config['dzUploadHint'] );
            $this->widget .= $this->dropZoneConfig();
            $dropCSV      = $this->shopTranslator->translate( $lblHint );
            $uploadInfo   = $this->shopTranslator->translate( $lbl);
            $loadedDataFiles     = $this->renderLoadedDataFiles($this->config['value']);
            $this->widget .= <<<MGK
<div class="pz-drop-down-wrapper" style="overflow:hidden;">
		<div class="pz-file-info-view-pane"  id="pz-file-info-view-pane"></div>
		<div class="pz-grid-parent">{$loadedDataFiles}</div>
    <div data-value="" id="file_upload_info" class="file_upload_info col-md-8 file_upload">
        <h3 class="pz-drag-drop-area">{$uploadInfo}</h3>

        <div class="clear-float" style="clear:both;margin-top:0;"></div>
        <div class="" id="pz-block-list-{$this->config['name']}" style="width:100%;padding:0;margin:0;box-sizing:border-box;max-width:100%;margin-top:5px;min-height:71px;overflow: scroll;">
            {$ddFeedBack}
        </div>
        <div class="clear-float" style="clear:both;margin-top:20px;"></div>
    </div>
    <div data-value="" id="{$this->config['id']}" {$this->config['data']} class="pz-drop-zone col-md-4 {$errorClass}{$this->config['name']}" data-url="{$this->config['dzURL']}">
    	{$hiddenField}
        <h3 class="pz-drag-drop-area">{$dropCSV}<span class="fa fa-dropbox"></span></h3>
        <aside id="uploadTrackBlock" class="uploadTrackBlock">
            <aside id="uploadTrackBg" class="uploadTrackBg"></aside>
            <div id="uploadTrack" class="uploadTrack"></div>
        </aside>
        <div class="clear_float clear-float clearfix"></div>
    </div>
    <div class="clear_float clear-float clearfix"></div>
</div>
MGK;
            $this->widget .= $this->dropZoneConfigSupplemental( $this->config['id'], $this->config['allowedFiles'] );
            
            return $this;
        }
        
        /**
         * @param string $tmpDocPath
         *
         * @return string
         */
        protected function buildDropZoneFeedBack( $tmpDocPath ) {
            $tmpDocStr  = ( file_exists( $tmpDocPath ) && $str = file_get_contents( $tmpDocPath ) ) ? unserialize( $str ) : [];
            $ddFeedBack = "<ul class=\"list-group list-unstyled pz-info-list\" id=\"pz-info-list\" style=\"margin-top:0;\">";
            if ( $tmpDocPath ) {
                foreach ( $tmpDocStr as $iKey => $arrVal ) {
                    if ( $arrVal['hash'] ) {
                        $ddFeedBack .= <<<DDFB
<li class="list-group-item col-md-12" style="letter-spacing:0.035em;font-size:11px;word-wrap: break-word;font-weight:300;position:relative;">
	<span class="fa fa-trash pz-trash-uploaded" style="padding:0 5px;color:#b53fb4;position:absolute;display:block;font-size: 16px;top:5px;right:5px;cursor:pointer;z-index:9999;" data-file-path="{$arrVal['fileLocation']}" data-action="deleteUploadedFileByPath"></span>
	<div class="col-md-2" style="padding:0 5px;font-weight:700;color:#007c9a;">
		<img class="img-responsive thumbnail" src="{$arrVal['icon']}" alt="Icon" style="margin-bottom: 0;">
	</div>
	<div class="col-md-10" style="font-weight:300;color:#b53fb4;padding-top:5px;">
		<strong style="">{$arrVal['fileRealName']}</strong><br>
		<strong style="color:#212121;">{$arrVal['fileSize']}</strong>  <strong style="color:#AB2121;">&nbsp;&nbsp;&nbsp;&nbsp;<span style="color: rgb(3, 139, 170);text-decoration: overline;"><i class="fa fa-tag"></i>{$arrVal['fileType']}</span></strong><br>
		<strong style="color:#613fb5;">Machine Name: </strong>
		<em style="color:#4d4d4d;">{$arrVal['fileName']}</em>
	</div>
</li>
DDFB;
                    }
                }
            }
            $ddFeedBack .= " </ul>";
            
            return $ddFeedBack;
        }
        
        public function dropZoneConfig() {
            $dzJS  = file_get_contents( PZ_JOBS_JS_PATH . '/dropzoneX.js' );
            $dzCSS  = file_get_contents( PZ_JOBS_CSS_PATH . '/dropzone.css' );
            # $dzCSS              = file_get_contents(__DIR__ . "/../../../../Resources/Public/Assets/css/dropzone.css");
            # $dzJS               = file_get_contents(FLOW_PATH_WEB . 'Application/Poiz.Shop/Classes/Codes/Widgets/Scripts/dd.css' . "/../../../../Resources/Public/Assets/js/dropzoneX.js");
            
            $dzConfigScript = <<<PHP_E
	<style type="text/css" media="all">{$dzCSS}</style>
	<script type="text/javascript">{$dzJS}</script>
PHP_E;
            
            return $dzConfigScript;
        }
        
        public function dropZoneConfigSupplemental( $id, $allowedFiles = '.jpg, .jpeg, .gif, .png, .otf, .ttf, .bmp' ) {
            $allowedFiles   = preg_split( '#,\ *?#', $allowedFiles );
            $strAllowed     = implode( ",", $allowedFiles );
            $action         = $this->config['wpUploadAction'] ? $this->config['wpUploadAction'] : "manage_pzj_file_uploads";
            $oKIcon         = $this->getURLFromPath("images/icons/ok_icon.png");                //EXT_URI . "Resources/Public/images/icons/ok_icon.png";
            $notOKIcon      = $this->getURLFromPath("images/icons/not_ok_icon.png");            //EXT_URI . "Resources/Public/images/icons/not_ok_icon.png";
            $preLoaderIcon  = $this->getURLFromPath("images/icons/preloader_transparent.png");  // EXT_URI . "Resources/Public/images/icons/preloader_transparent.gif";
            $dzConfigScript = <<<PHP_E
<script type="text/javascript">

(function ($) {
    $(document).ready(function (e) {
        var pixBox      = $("#{$id}");
    	console.log(pixBox.find("input"));
    	console.log({$id});
        var uploadURL   = php_array.admin_ajax;
        // var uploadURL   = pixBox.attr("data-url");
        var pzData 		= {};

        pzData.errorIcon            = "{$notOKIcon}";
        pzData.allOKIcon            = "{$oKIcon}";
        pzData.preLoaderIcon        = "{$preLoaderIcon}";
        pzData.processor            = uploadURL;
        
        var dZone = new Dropzone("div#{$id}", {
            url				: uploadURL,
            params          : {
		         'csrfToken'    : $("input[name=csrfToken]").val(),
		         'path'         : 'category_icons',
		         'intent'       : "file_upload",
		         'action'       : "{$action}",
		         'doable'       : "file_upload",
		    },
            paramName		: "pz_item_photo",
            maxFilesize		: 1,        // 1MB
            dataType		: "JSON",
            uploadMultiple	: false,
			acceptedFiles   : "{$strAllowed}",
            success: function (ditto, data) {
                console.log(data);
	            	var dataObj		= JSON.parse(data);     //JSON.parse(data);
                var fileType 	=  (dataObj.fileType !== undefined && dataObj.fileType) ? dataObj.fileType.toUpperCase() : "Size: Unknown";
                if(dataObj){
                    var infoListBlock   = $("#pz-info-list");
                    var statusUpdate    = '<li class="list-group-item col-md-12" style="letter-spacing:0.035em;font-size:11px;word-wrap: break-word;font-weight:300;position:relative;">';
                    statusUpdate       += '<span class="fa fa-trash pz-trash-uploaded" style="padding:0 5px;color:#b53fb4;position:absolute;display:block;font-size: 16px;top:5px;right:5px;cursor:pointer;z-index:9999;" data-file-path="' + dataObj.fileLocation + '" data-action="deleteUploadedFileByPath"></span>';
                    statusUpdate       += '<div class="col-lg-2" style="padding:0 5px;font-weight:700;color:#007c9a;">';
                    statusUpdate       += '<img class="img-responsive thumbnail" src="' + dataObj.icon + '" alt="Icon" style="margin-bottom: 0;" />';
                    statusUpdate       += '</div>';
                    statusUpdate       += '<div class="col-lg-10" style="font-weight:300;color:#b53fb4;padding-top:5px;">';
                    statusUpdate       += '<strong style="">' + dataObj.fileRealName + '</strong><br /><strong style="color:#212121;">' + dataObj.fileSize + '</strong>  <strong style="color:#AB2121;">&nbsp;&nbsp;&nbsp;&nbsp;<span style="color: rgb(3, 139, 170);text-decoration: overline;"><i class="fa fa-tag"></i>' + fileType + '</span></strong>';
                    statusUpdate       += '<br /><strong style="color:#613fb5;">Machine Name: </strong><em style="color:#4d4d4d;">' + dataObj.fileName + '</em>';
                    statusUpdate       += '</div>';
                    statusUpdate       += '</li>';

                    infoListBlock.prepend($(statusUpdate));

                    infoListBlock.find(".pz-trash-uploaded").on("click", deleteUploaded);
                    pixBox.find("#uploadTrackBg").css("width", "0");
                    pixBox.find("#uploadTrack").text('');
                    
                    if(dataObj.serialized){
		                var szStr	= dataObj.serialized;
		                pixBox.attr("data-value", szStr);
		                pixBox.find("input[type=hidden]").val(szStr );
                    }
                }
            }
        }).
        on("dragover", function(e){
            pixBox.css({
                "background": "rgba(16, 22, 99, 1)",
                "border": "dashed 2px white"
            })
        }).
        on("drop", function(e){
            pixBox.css({
                "background": "rgba(181, 63, 180, 0.08)",
                "border": "solid 1px rgba(181, 63, 180, 0.26)"
            })
        }).
        on("dragleave", function(e){
           pixBox.css({
                "background": "rgba(181, 63, 180, 0.08)",
                "border": "solid 1px rgba(181, 63, 180, 0.26)"
            })
        }).
        on("uploadprogress", function(first, progress, bytesSent){
           pixBox.find("#uploadTrackBg").css("width", progress.toFixed(5) + "%");
           pixBox.find("#uploadTrack").text( progress.toFixed(2) + "%");
        }).
        on("error", function(a, b, c){
            $("#uploadTrackBg").css("width", "0");
            $("#uploadTrack").text(null);
            var infoListBlock   = $("#pz-info-list");
            var statusUpdate    = '<li class="list-group-item col-md-12" style="letter-spacing:0.035em;font-size:11px;word-wrap: break-word;font-weight:300;position:relative;">';
            statusUpdate       += '<div class="col-md-2" style="padding:0 5px;font-weight:700;color:#007c9a;">';
            statusUpdate       += '<img class="img-responsive thumbnail" src="' + pzData.errorIcon + '" alt="Icon" style="margin-bottom: 0;" />';
            statusUpdate       += '</div>';
            statusUpdate       += '<div class="col-md-10" style="font-weight:300;color:#b53fb4;padding-top:5px;">';
            statusUpdate       += '<strong style="">Error:</strong> <em>Cannot upload File — </em><strong style="color:#613fb5;">' + a.name + "</strong>";
            statusUpdate       += '<br /><strong style="color:#613fb5;"><em style="color:#4d4d4d;">' + b + '</em></strong>';
            statusUpdate       += '</div>';
            statusUpdate       += '</li>';

            infoListBlock.prepend($(statusUpdate));
        }).
        on("maxfilesexceeded", function(first){
            console.log("Max File-Size Exceeded!");
            alert("Max File-Size Exceeded!");
        });
        
        var infoListBlock 	= $("#pz-info-list");
		infoListBlock.find(".pz-trash-uploaded").on("click", deleteUploaded);
        
        function deleteUploaded(event){
            var disObject           = $(this);
            doJQAjaxRequest({
		        'action'    : "{$action}",
            'filePath'	: disObject.attr('data-file-path'),
            'intent'		: disObject.attr('data-action')}, "POST", disObject);
        }
        
        function doJQAjaxRequest(payLoad, sendMethod,  targetObj, contentType){
            contentType     = (contentType === undefined) ? "x-www-form-urlencoded" : "json";
            var req = $.ajax({
                dataType        : 'JSON',
                type            : sendMethod,
                url             : pzData.processor,
                data            : payLoad,
                'Content-Type'  : 'application/' + contentType  + "; charset=UTF-8",
                
                success			: function (data, textStatus, jqXHR){
                    if(data){
                        var dataObj	= data; //JSON.parse(data);
	                    targetObj.parent("li.list-group-item").slideUp(350, function(e){
	                        targetObj.parent("li.list-group-item").remove();
	                    });
	                    if(dataObj.status){
		                    PoizAlert(dataObj.status, 2000);
		                }
	                }
                },
                
                error 			: function (jqXHR, textStatus, errorThrown){
                	console.log('The following error occurred: ' + textStatus, errorThrown);
                }
                
            });
        }
        
	    function PoizAlert(msgText, iTimeOut){
	        msgText                     = (msgText !== undefined)   ? msgText   : "All is well that ends well!";
	        iTimeOut                    = (iTimeOut !== undefined)  ? iTimeOut  : 2000;
	        var message                 = "<span " +
	            "style='display:block;padding:30px;margin:0 auto;width:350px;max-width:350px;color:#000;" +
	            "text-align:center;background:rgba(181, 63, 180, 0.95);border-radius:7px;border:double 3px rgba(255,255,255,0.4);" +
	            "font-size:16px;font-weight:300;letter-spacing:0.01em;color:#FFFFFF;'>" + msgText +
	            "</span>";
	
	        //CREATE MAIN WRAPPER DIV
	        var alertBox    = $("<div />", {
	            id          : "pz-alert",
	            "class"     : "pz-alert"
	        }).css( {
	            position    : "fixed",
	            width       : "100%",
	            height      : "80px",
	            background  : "transparent",
	            display     : "none",
	            margin      : 0,
	            padding     : 0,
	            left        : 0,
	            zIndex      : 2147483646,
	            top         : 0
	        } ).append($(message));
	
	        $(".pz-form-wrapper").parentsUntil("body").parent("body").append(alertBox);
	        alertBox.fadeIn(500, function(e){
	            setTimeout(function(){
	                alertBox.fadeOut(500, function(e){alertBox.remove();});
	            }, iTimeOut);
	        });
	    }
     
    });
})(jQuery);
	</script>
PHP_E;
            
            return $dzConfigScript;
        }
        
        protected function renderLoadedDataFiles($serializeDataFiles){
        	$rayLoadedDataFiles   =  unserialize($serializeDataFiles);
        	$outputHTML           = "";
        	if($rayLoadedDataFiles){
        		foreach($rayLoadedDataFiles as $iKey=>$pixData){
        			$pixData['classSuffix'] = $iKey;
        			$thumbBox               = new ThumbIconBox($pixData, $iKey);
        			$outputHTML            .= $thumbBox->build();
		        }
	        }
        	return $outputHTML;
        }
        
        public function getURLFromPath( $path = "css/django.css") {
            return PZ_JOBS_PLG_URL . ("/FrontEnd/{$path}");
        }
        
        
    }
