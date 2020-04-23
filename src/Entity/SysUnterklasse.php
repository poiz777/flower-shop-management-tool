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
	 * SysUnterklasse
	 * @Table(name="Sys_Unterklasse")
	 * @Entity(repositoryClass="App\Entity\Repo\SysUnterklasseRepo")
	 **/
	class SysUnterklasse { 

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
		 * @Id SysUnterklasse
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Sys Unterklasse Id 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Unterklasse_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Sys_Unterklasse_id; 

		/**
		 * @var int
		 * @Column(name="Sys_Unterklasse_Klasse_id", type="smallint", length=5, nullable=false) 
		 * 
		 * ##FormLabel  Sys Unterklasse Klasse Id 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Unterklasse_Klasse_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Sys_Unterklasse_Klasse_id; 

		/**
		 * @var string
		 * @Column(name="Sys_Unterklasse_name_lat", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Unterklasse Name Lat 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Unterklasse_name_lat</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Unterklasse_name_lat; 

		/**
		 * @var string
		 * @Column(name="Sys_Unterklasse_name_deutsch", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Unterklasse Name Deutsch 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Unterklasse_name_deutsch</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Unterklasse_name_deutsch; 

		/**
		 * @var string
		 * @Column(name="Sys_Unterklasse_info_URL", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Unterklasse Info U R L 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Unterklasse_info_URL</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Unterklasse_info_URL; 

		/**
		 * @var string
		 * @Column(name="Sys_Unterklasse_img_URL", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Unterklasse Img U R L 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Unterklasse_img_URL</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Unterklasse_img_URL; 

		/**
		 * @var string
		 * @Column(name="Sys_Unterklasse_img_text", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Unterklasse Img Text 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Unterklasse_img_text</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Unterklasse_img_text; 

		/**
		 * @var string
		 * @Column(name="Sys_Unterklasse_info", type="string", length=2000, nullable=false) 
		 * 
		 * ##FormLabel  Sys Unterklasse Info 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Unterklasse_info</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Unterklasse_info; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getSysUnterklasseId() {
			return $this->Sys_Unterklasse_id;
		}

		public function getSysUnterklasseKlasseId() {
			return $this->Sys_Unterklasse_Klasse_id;
		}

		public function getSysUnterklasseNameLat() {
			return $this->Sys_Unterklasse_name_lat;
		}

		public function getSysUnterklasseNameDeutsch() {
			return $this->Sys_Unterklasse_name_deutsch;
		}

		public function getSysUnterklasseInfoURL() {
			return $this->Sys_Unterklasse_info_URL;
		}

		public function getSysUnterklasseImgURL() {
			return $this->Sys_Unterklasse_img_URL;
		}

		public function getSysUnterklasseImgText() {
			return $this->Sys_Unterklasse_img_text;
		}

		public function getSysUnterklasseInfo() {
			return $this->Sys_Unterklasse_info;
		}


		public function setSysUnterklasseId($Sys_Unterklasse_id) {
			$this->Sys_Unterklasse_id = $Sys_Unterklasse_id;
			return $this;
		}

		public function setSysUnterklasseKlasseId($Sys_Unterklasse_Klasse_id) {
			$this->Sys_Unterklasse_Klasse_id = $Sys_Unterklasse_Klasse_id;
			return $this;
		}

		public function setSysUnterklasseNameLat($Sys_Unterklasse_name_lat) {
			$this->Sys_Unterklasse_name_lat = $Sys_Unterklasse_name_lat;
			return $this;
		}

		public function setSysUnterklasseNameDeutsch($Sys_Unterklasse_name_deutsch) {
			$this->Sys_Unterklasse_name_deutsch = $Sys_Unterklasse_name_deutsch;
			return $this;
		}

		public function setSysUnterklasseInfoURL($Sys_Unterklasse_info_URL) {
			$this->Sys_Unterklasse_info_URL = $Sys_Unterklasse_info_URL;
			return $this;
		}

		public function setSysUnterklasseImgURL($Sys_Unterklasse_img_URL) {
			$this->Sys_Unterklasse_img_URL = $Sys_Unterklasse_img_URL;
			return $this;
		}

		public function setSysUnterklasseImgText($Sys_Unterklasse_img_text) {
			$this->Sys_Unterklasse_img_text = $Sys_Unterklasse_img_text;
			return $this;
		}

		public function setSysUnterklasseInfo($Sys_Unterklasse_info) {
			$this->Sys_Unterklasse_info = $Sys_Unterklasse_info;
			return $this;
		}




	} 
