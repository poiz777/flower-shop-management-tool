<?php 

	namespace App\Entity;

	use Doctrine\ORM\Mapping as ORM;
	use Doctrine\ORM\Mapping\Id;
	use Doctrine\ORM\Mapping\Table;
	use Doctrine\ORM\Mapping\Column;
	use Doctrine\ORM\Mapping\Entity;
	use Doctrine\ORM\Mapping\OneToOne;
	use Doctrine\ORM\Mapping\JoinColumn;
	use Doctrine\ORM\Mapping\GeneratedValue;
	use Doctrine\ORM\Mapping\JoinColumns;
	use Doctrine\ORM\Mapping\OneToMany;
	use Doctrine\ORM\Mapping\ManyToOne;
	use Doctrine\Common\Collections\ArrayCollection;
	use Doctrine\ORM\EntityManagerInterface;
	use Doctrine\ORM\Mapping\ManyToMany;
	use App\Helpers\Traits\EntityFieldMapperTrait;
	use App\Helpers\Traits\FormObjectLexer;

	/**
	 * SysUnterart
	 * @Table(name="Sys_Unterart")
	 * @Entity(repositoryClass="App\Entity\Repo\SysUnterartRepo")
	 **/
	class SysUnterart { 

		use EntityFieldMapperTrait; 

		/**
		 * @var array
		 */
		protected $entityBank	= [];
		/**
		 * @var EntityManagerInterface
		 */
		protected $eMan;


		/**
		 * @var int
		 * @Id SysUnterart
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Sys Unterart Id 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Unterart_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Sys_Unterart_id; 

		/**
		 * @var int
		 * @Column(name="Sys_Unterart_Art_id", type="smallint", length=5, nullable=false) 
		 * 
		 * ##FormLabel  Sys Unterart Art Id 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Unterart_Art_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Sys_Unterart_Art_id; 

		/**
		 * @var string
		 * @Column(name="Sys_Unterart_name_lat", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Unterart Name Lat 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Unterart_name_lat</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Unterart_name_lat; 

		/**
		 * @var string
		 * @Column(name="Sys_Unterart_name_deutsch", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Unterart Name Deutsch 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Unterart_name_deutsch</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Unterart_name_deutsch; 

		/**
		 * @var string
		 * @Column(name="Sys_Unterart_info_URL", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Unterart Info U R L 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Unterart_info_URL</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Unterart_info_URL; 

		/**
		 * @var string
		 * @Column(name="Sys_Unterart_img_URL", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Unterart Img U R L 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Unterart_img_URL</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Unterart_img_URL; 

		/**
		 * @var string
		 * @Column(name="Sys_Unterart_img_text", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Unterart Img Text 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Unterart_img_text</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Unterart_img_text; 

		/**
		 * @var string
		 * @Column(name="Sys_Unterart_info", type="string", length=2000, nullable=false) 
		 * 
		 * ##FormLabel  Sys Unterart Info 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Unterart_info</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Unterart_info; 

		/**
		 * @var int
		 * @Column(name="Sys_Unterart_Beschreiber", type="smallint", length=5, nullable=false) 
		 * 
		 * ##FormLabel  Sys Unterart Beschreiber 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Unterart_Beschreiber</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Sys_Unterart_Beschreiber; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getSysUnterartId() {
			return $this->Sys_Unterart_id;
		}

		public function getSysUnterartArtId() {
			return $this->Sys_Unterart_Art_id;
		}

		public function getSysUnterartNameLat() {
			return $this->Sys_Unterart_name_lat;
		}

		public function getSysUnterartNameDeutsch() {
			return $this->Sys_Unterart_name_deutsch;
		}

		public function getSysUnterartInfoURL() {
			return $this->Sys_Unterart_info_URL;
		}

		public function getSysUnterartImgURL() {
			return $this->Sys_Unterart_img_URL;
		}

		public function getSysUnterartImgText() {
			return $this->Sys_Unterart_img_text;
		}

		public function getSysUnterartInfo() {
			return $this->Sys_Unterart_info;
		}

		public function getSysUnterartBeschreiber() {
			return $this->Sys_Unterart_Beschreiber;
		}


		public function setSysUnterartId($Sys_Unterart_id) {
			$this->Sys_Unterart_id = $Sys_Unterart_id;
			return $this;
		}

		public function setSysUnterartArtId($Sys_Unterart_Art_id) {
			$this->Sys_Unterart_Art_id = $Sys_Unterart_Art_id;
			return $this;
		}

		public function setSysUnterartNameLat($Sys_Unterart_name_lat) {
			$this->Sys_Unterart_name_lat = $Sys_Unterart_name_lat;
			return $this;
		}

		public function setSysUnterartNameDeutsch($Sys_Unterart_name_deutsch) {
			$this->Sys_Unterart_name_deutsch = $Sys_Unterart_name_deutsch;
			return $this;
		}

		public function setSysUnterartInfoURL($Sys_Unterart_info_URL) {
			$this->Sys_Unterart_info_URL = $Sys_Unterart_info_URL;
			return $this;
		}

		public function setSysUnterartImgURL($Sys_Unterart_img_URL) {
			$this->Sys_Unterart_img_URL = $Sys_Unterart_img_URL;
			return $this;
		}

		public function setSysUnterartImgText($Sys_Unterart_img_text) {
			$this->Sys_Unterart_img_text = $Sys_Unterart_img_text;
			return $this;
		}

		public function setSysUnterartInfo($Sys_Unterart_info) {
			$this->Sys_Unterart_info = $Sys_Unterart_info;
			return $this;
		}

		public function setSysUnterartBeschreiber($Sys_Unterart_Beschreiber) {
			$this->Sys_Unterart_Beschreiber = $Sys_Unterart_Beschreiber;
			return $this;
		}




	} 
