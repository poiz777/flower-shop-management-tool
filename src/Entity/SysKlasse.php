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
	 * SysKlasse
	 * @Table(name="Sys_Klasse")
	 * @Entity(repositoryClass="App\Entity\Repo\SysKlasseRepo")
	 **/
	class SysKlasse { 

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
		 * @Id SysKlasse
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Sys Klasse Id 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Klasse_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Sys_Klasse_id; 

		/**
		 * @var int
		 * @Column(name="Sys_Klasse_Abteilung_id", type="smallint", length=5, nullable=false) 
		 * 
		 * ##FormLabel  Sys Klasse Abteilung Id 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Klasse_Abteilung_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Sys_Klasse_Abteilung_id; 

		/**
		 * @var string
		 * @Column(name="Sys_Klasse_name_lat", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Klasse Name Lat 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Klasse_name_lat</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Klasse_name_lat; 

		/**
		 * @var string
		 * @Column(name="Sys_Klasse_name_deutsch", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Klasse Name Deutsch 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Klasse_name_deutsch</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Klasse_name_deutsch; 

		/**
		 * @var string
		 * @Column(name="Sys_Klasse_info_URL", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Klasse Info U R L 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Klasse_info_URL</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Klasse_info_URL; 

		/**
		 * @var string
		 * @Column(name="Sys_Klasse_img_URL", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Klasse Img U R L 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Klasse_img_URL</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Klasse_img_URL; 

		/**
		 * @var string
		 * @Column(name="Sys_Klasse_img_text", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Klasse Img Text 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Klasse_img_text</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Klasse_img_text; 

		/**
		 * @var string
		 * @Column(name="Sys_Klasse_info", type="string", length=2000, nullable=false) 
		 * 
		 * ##FormLabel  Sys Klasse Info 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Klasse_info</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Klasse_info; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getSysKlasseId() {
			return $this->Sys_Klasse_id;
		}

		public function getSysKlasseAbteilungId() {
			return $this->Sys_Klasse_Abteilung_id;
		}

		public function getSysKlasseNameLat() {
			return $this->Sys_Klasse_name_lat;
		}

		public function getSysKlasseNameDeutsch() {
			return $this->Sys_Klasse_name_deutsch;
		}

		public function getSysKlasseInfoURL() {
			return $this->Sys_Klasse_info_URL;
		}

		public function getSysKlasseImgURL() {
			return $this->Sys_Klasse_img_URL;
		}

		public function getSysKlasseImgText() {
			return $this->Sys_Klasse_img_text;
		}

		public function getSysKlasseInfo() {
			return $this->Sys_Klasse_info;
		}


		public function setSysKlasseId($Sys_Klasse_id) {
			$this->Sys_Klasse_id = $Sys_Klasse_id;
			return $this;
		}

		public function setSysKlasseAbteilungId($Sys_Klasse_Abteilung_id) {
			$this->Sys_Klasse_Abteilung_id = $Sys_Klasse_Abteilung_id;
			return $this;
		}

		public function setSysKlasseNameLat($Sys_Klasse_name_lat) {
			$this->Sys_Klasse_name_lat = $Sys_Klasse_name_lat;
			return $this;
		}

		public function setSysKlasseNameDeutsch($Sys_Klasse_name_deutsch) {
			$this->Sys_Klasse_name_deutsch = $Sys_Klasse_name_deutsch;
			return $this;
		}

		public function setSysKlasseInfoURL($Sys_Klasse_info_URL) {
			$this->Sys_Klasse_info_URL = $Sys_Klasse_info_URL;
			return $this;
		}

		public function setSysKlasseImgURL($Sys_Klasse_img_URL) {
			$this->Sys_Klasse_img_URL = $Sys_Klasse_img_URL;
			return $this;
		}

		public function setSysKlasseImgText($Sys_Klasse_img_text) {
			$this->Sys_Klasse_img_text = $Sys_Klasse_img_text;
			return $this;
		}

		public function setSysKlasseInfo($Sys_Klasse_info) {
			$this->Sys_Klasse_info = $Sys_Klasse_info;
			return $this;
		}




	} 
