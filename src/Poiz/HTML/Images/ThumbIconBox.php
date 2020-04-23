<?php
	
	
	namespace  App\Poiz\HTML\Images;
	use  App\Poiz\HTML\FormEntity\GenericObjectFieldsMapper as GofM;
	
	class ThumbIconBox {
		use GofM;
		
		/**
		 * @var string $fileName
		 */
		protected  $fileName;
		
		/**
		 * @var string $fileRealName
		 */
		protected  $fileRealName;
		
		/**
		 * @var string $fileLocation
		 */
		protected  $fileLocation;
		
		/**
		 * @var int $status
		 */
		protected  $status; // int
		
		/**
		 * @var string $hash
		 */
		protected  $hash;
		
		/**
		 * @var string $fileType
		 */
		protected  $fileType; // EG: "pdf" NOT DOT PREFIX
		
		/**
		 * @var string $fileSize
		 */
		protected  $fileSize;
		
		/**
		 * @var string $url
		 */
		protected  $url;
		
		/**
		 * @var string $oKIcon
		 */
		protected  $oKIcon;
		
		/**
		 * @var string $notOKIcon
		 */
		protected  $notOKIcon;
		
		/**
		 * @var string $genericIcon
		 */
		protected  $genericIcon;
		
		
		/**
		 * @var string $classSuffix
		 */
		protected  $classSuffix;
		
		/**
		 * @var array $fileIconsMap
		 */
		protected $fileIconsMap = [
			'png'     => PZ_JOBS_ICONS_URL . 'jobs/generics/png.png',
			'svg'     => PZ_JOBS_ICONS_URL . 'jobs/generics/svg.png',
		];
		
		/**
		 * @var string
		 */
		protected $thumbIconBox  = '';
		
		/**
		 * ThumbIconBox constructor.
		 *
		 * @param array  $thumbData
		 */
		public function __construct($thumbData=[]) {
			$this->map($thumbData);
		}
		
		public function getDataFileIconByFileType(){
			$iconURI      = "";
			$pixFiles     = ['png', 'bmp', 'jpg', 'jpeg', 'gif', 'wmbp', 'ico', 'icn', 'icns', 'tif', 'tiff'];  // 'svg'
			$pdfFiles     = ['pdf', 'pdf-x', 'pdfx'];
			$audioFiles   = ['mp3', 'wav', 'aif', 'aiff', 'mp4'];
			$videoFiles   = ['mp4', 'avi', 'ogg', 'quicktime', 'qt', 'mov'];
			$otherFiles   = ['doc', 'pdf', 'docx', 'ppt', 'xls', 'xlsx', 'svg'];
			
			if(in_array($this->fileType, $pixFiles)){
				$iconURI    = $this->url;
			}else if(in_array($this->fileType, $otherFiles)){
				$iconURI    = PZ_JOBS_ICONS_URL . "jobs/generics/{$this->fileType}.png";
			}
			return $iconURI;
		}
		
		public function build() {
			global $post;
			$maxChars = 20;
			$iconURI  = $this->getDataFileIconByFileType();
			$fileName = pathinfo($this->getFileRealName(), PATHINFO_FILENAME);
			$fileAlias            = preg_replace("#[\-/_+{}()]#", " ", substr($fileName, 0, $maxChars));
			$fileAlias           .= strlen($fileName) > $maxChars ?  "..." : "";
			$this->thumbIconBox  .= "<div class='pz-thumb-icon pz-grid-child pz-grid-child-{$this->classSuffix}'>";
			$this->thumbIconBox  .= "<span class='pz-trash fa fa-trash' data-file-path='{$this->fileLocation}' data-id='{$post->ID}'></span>";
			$this->thumbIconBox  .= "<span class='pz-info fa fa-info'></span>";
			$this->thumbIconBox  .= "<span class='pz-resource-name'>$fileAlias</span>";
			$this->thumbIconBox  .= "<div class='pz-file-info-box pz-hidden'>{$this->getFileInfoAsHTML()}</div>";
			$this->thumbIconBox  .= "<div class='pz-bg-enabled' style='background-image: url({$iconURI});'></div>";
			$this->thumbIconBox  .= "</div>";
			return $this->thumbIconBox;
		}
		
		protected function getFileInfoAsHTML(){
			$fileInfoHTML = "<div class='pz-file-info-container'>";
			$fileInfoHTML.= $this->geRecordStripHTML('Size: ', $this->fileSize);
			$fileInfoHTML.= $this->geRecordStripHTML('File Type: ', strtoupper($this->fileType));
			$fileInfoHTML.= $this->geRecordStripHTML('File URI: ', $this->url);
			$fileInfoHTML.= $this->geRecordStripHTML('File Path: ', $this->fileLocation);
			$fileInfoHTML.= $this->geRecordStripHTML('File Name: ', $this->fileRealName);
			$fileInfoHTML.= $this->geRecordStripHTML('MCHN. Name: ', $this->hash);
			$fileInfoHTML.= "</div>";
			return $fileInfoHTML;
		}
		protected function geRecordStripHTML($stripTitle, $stripContent){
			$fileInfoHTML = "<div class='col-md-12 list-group-item no-lr-pad'>";
			$fileInfoHTML.= "<div class='col-md-4'>";
			$fileInfoHTML.= "<strong>{$stripTitle}</strong>";
			$fileInfoHTML.= "</div>";
			$fileInfoHTML.= "<div class='col-md-6'>";
			$fileInfoHTML.= "<em>{$stripContent}</em>";
			$fileInfoHTML.= "</div>";
			$fileInfoHTML.= "</div>";
			return $fileInfoHTML;
		}
		
		
		
		/**
		 * @return string
		 */
		public function getFileName(): string {
			return $this->fileName;
		}
		
		/**
		 * @return string
		 */
		public function getFileRealName() {
			return $this->fileRealName;
		}
		
		/**
		 * @return string
		 */
		public function getFileLocation() {
			return $this->fileLocation;
		}
		
		/**
		 * @return int
		 */
		public function getStatus() {
			return $this->status;
		}
		
		/**
		 * @return string
		 */
		public function getHash() {
			return $this->hash;
		}
		
		/**
		 * @return string
		 */
		public function getFileType() {
			return $this->fileType;
		}
		
		/**
		 * @return string
		 */
		public function getFileSize() {
			return $this->fileSize;
		}
		
		/**
		 * @return string
		 */
		public function getUrl() {
			return $this->url;
		}
		
		/**
		 * @return string
		 */
		public function getOKIcon() {
			return $this->oKIcon;
		}
		
		/**
		 * @return string
		 */
		public function getNotOKIcon() {
			return $this->notOKIcon;
		}
		
		/**
		 * @return string
		 */
		public function getGenericIcon() {
			return $this->genericIcon;
		}
		
		/**
		 * @return string
		 */
		public function getClassSuffix(): string {
			return $this->classSuffix;
		}
		
		/**
		 * @param string $classSuffix
		 *
		 * @return ThumbIconBox
		 */
		public function setClassSuffix( $classSuffix ): ThumbIconBox {
			$this->classSuffix = $classSuffix;
			
			return $this;
		}
		
		/**
		 * @return array
		 */
		public function getFileIconsMap(){
			return $this->fileIconsMap;
		}
		
		/**
		 * @param array $fileIconsMap
		 *
		 * @return ThumbIconBox
		 */
		public function setFileIconsMap( $fileIconsMap ): ThumbIconBox {
			$this->fileIconsMap = $fileIconsMap;
			
			return $this;
		}
		
		/**
		 * @return string
		 */
		public function getThumbIconBox() {
			return $this->thumbIconBox;
		}
		
		/**
		 * @param string $thumbIconBox
		 *
		 * @return ThumbIconBox
		 */
		public function setThumbIconBox( $thumbIconBox ): ThumbIconBox {
			$this->thumbIconBox = $thumbIconBox;
			
			return $this;
		}
		
		
		
		
		
		/**
		 * @param string $fileName
		 *
		 * @return ThumbIconBox
		 */
		public function setFileName( string $fileName ): ThumbIconBox {
			$this->fileName = $fileName;
			
			return $this;
		}
		
		/**
		 * @param string $fileRealName
		 *
		 * @return ThumbIconBox
		 */
		public function setFileRealName( $fileRealName ): ThumbIconBox {
			$this->fileRealName = $fileRealName;
			
			return $this;
		}
		
		/**
		 * @param string $fileLocation
		 *
		 * @return ThumbIconBox
		 */
		public function setFileLocation( $fileLocation ): ThumbIconBox {
			$this->fileLocation = $fileLocation;
			
			return $this;
		}
		
		/**
		 * @param int $status
		 *
		 * @return ThumbIconBox
		 */
		public function setStatus( $status ): ThumbIconBox {
			$this->status = $status;
			
			return $this;
		}
		
		/**
		 * @param string $hash
		 *
		 * @return ThumbIconBox
		 */
		public function setHash( $hash ): ThumbIconBox {
			$this->hash = $hash;
			
			return $this;
		}
		
		/**
		 * @param string $fileType
		 *
		 * @return ThumbIconBox
		 */
		public function setFileType( $fileType ): ThumbIconBox {
			$this->fileType = $fileType;
			
			return $this;
		}
		
		/**
		 * @param string $fileSize
		 *
		 * @return ThumbIconBox
		 */
		public function setFileSize( $fileSize ): ThumbIconBox {
			$this->fileSize = $fileSize;
			
			return $this;
		}
		
		/**
		 * @param string $url
		 *
		 * @return ThumbIconBox
		 */
		public function setUrl( $url ): ThumbIconBox {
			$this->url = $url;
			
			return $this;
		}
		
		/**
		 * @param string $oKIcon
		 *
		 * @return ThumbIconBox
		 */
		public function setOKIcon( $oKIcon ): ThumbIconBox {
			$this->oKIcon = $oKIcon;
			
			return $this;
		}
		
		
		/**
		 * @param string $notOKIcon
		 *
		 * @return ThumbIconBox
		 */
		public function setNotOKIcon( $notOKIcon ): ThumbIconBox {
			$this->notOKIcon = $notOKIcon;
			
			return $this;
		}
		
		/**
		 * @param string $genericIcon
		 *
		 * @return ThumbIconBox
		 */
		public function setGenericIcon($genericIcon ): ThumbIconBox {
			$this->genericIcon = $genericIcon;
			
			return $this;
		}
		
		
		
		
		
		
	}
	
	
	
	/*
	"fileName" => "28C05D8EB0B5F5FD9202C24233C6F94E.pdf"
	"fileRealName" => "PC-Zw-Zeugnis-08-17.pdf"
	"fileLocation" => "/Users/poiz/web_stack/htdocs/odaumwelt.pz/wp-content/plugins/PzJobs/_tmp_/store/kunden/28C05D8EB0B5F5FD9202C24233C6F94E.pdf"
	"status" => 1
	"hash" => "28C05D8EB0B5F5FD9202C24233C6F94E"
	"fileType" => "pdf"
	"fileSize" => "40.20 KB"
	"url" => "APP_BASE_URL/Users/poiz/web_stack/htdocs/odaumwelt.pz/wp-content/plugins/PzJobs/_tmp_/store/kunden/28C05D8EB0B5F5FD9202C24233C6F94E.pdf"
	"oKIcon" => "http://odaumwelt.pz/wp-content/plugins/PzJobs/FrontEnd/images/icons/ok_icon.png"
	"notOKIcon" => "http://odaumwelt.pz/wp-content/plugins/PzJobs/FrontEnd/images/icons/not_ok_icon.png"
	"icon" => "http://odaumwelt.pz/wp-content/plugins/PzJobs/FrontEnd/images/icons/pz-file-icon-generic.png"
*/
