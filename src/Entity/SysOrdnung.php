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
	 * SysOrdnung
	 * @Table(name="Sys_Ordnung")
	 * @Entity(repositoryClass="App\Entity\Repo\SysOrdnungRepo")
	 **/
	class SysOrdnung { 

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
		 * @Id SysOrdnung
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Sys Ordnung Id 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Ordnung_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Sys_Ordnung_id; 

		/**
		 * @var int
		 * @Column(name="Sys_Ordnung_Klasse_id", type="smallint", length=5, nullable=false) 
		 * 
		 * ##FormLabel  Sys Ordnung Klasse Id 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Ordnung_Klasse_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Sys_Ordnung_Klasse_id; 

		/**
		 * @var int
		 * @Column(name="Sys_Ordnung_Unterklasse_id", type="smallint", length=5, nullable=false) 
		 * 
		 * ##FormLabel  Sys Ordnung Unterklasse Id 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Ordnung_Unterklasse_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Sys_Ordnung_Unterklasse_id; 

		/**
		 * @var string
		 * @Column(name="Sys_Ordnung_name_lat", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Ordnung Name Lat 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Ordnung_name_lat</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Ordnung_name_lat; 

		/**
		 * @var string
		 * @Column(name="Sys_Ordnung_name_deutsch", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Ordnung Name Deutsch 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Ordnung_name_deutsch</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Ordnung_name_deutsch; 

		/**
		 * @var string
		 * @Column(name="Sys_Ordnung_info_URL", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Ordnung Info U R L 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Ordnung_info_URL</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Ordnung_info_URL; 

		/**
		 * @var string
		 * @Column(name="Sys_Ordnung_img_URL", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Ordnung Img U R L 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Ordnung_img_URL</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Ordnung_img_URL; 

		/**
		 * @var string
		 * @Column(name="Sys_Ordnung_img_text", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Ordnung Img Text 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Ordnung_img_text</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Ordnung_img_text; 

		/**
		 * @var string
		 * @Column(name="Sys_Ordnung_info", type="string", length=2000, nullable=false) 
		 * 
		 * ##FormLabel  Sys Ordnung Info 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Ordnung_info</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Ordnung_info; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getSysOrdnungId() {
			return $this->Sys_Ordnung_id;
		}

		public function getSysOrdnungKlasseId() {
			return $this->Sys_Ordnung_Klasse_id;
		}

		public function getSysOrdnungUnterklasseId() {
			return $this->Sys_Ordnung_Unterklasse_id;
		}

		public function getSysOrdnungNameLat() {
			return $this->Sys_Ordnung_name_lat;
		}

		public function getSysOrdnungNameDeutsch() {
			return $this->Sys_Ordnung_name_deutsch;
		}

		public function getSysOrdnungInfoURL() {
			return $this->Sys_Ordnung_info_URL;
		}

		public function getSysOrdnungImgURL() {
			return $this->Sys_Ordnung_img_URL;
		}

		public function getSysOrdnungImgText() {
			return $this->Sys_Ordnung_img_text;
		}

		public function getSysOrdnungInfo() {
			return $this->Sys_Ordnung_info;
		}


		public function setSysOrdnungId($Sys_Ordnung_id) {
			$this->Sys_Ordnung_id = $Sys_Ordnung_id;
			return $this;
		}

		public function setSysOrdnungKlasseId($Sys_Ordnung_Klasse_id) {
			$this->Sys_Ordnung_Klasse_id = $Sys_Ordnung_Klasse_id;
			return $this;
		}

		public function setSysOrdnungUnterklasseId($Sys_Ordnung_Unterklasse_id) {
			$this->Sys_Ordnung_Unterklasse_id = $Sys_Ordnung_Unterklasse_id;
			return $this;
		}

		public function setSysOrdnungNameLat($Sys_Ordnung_name_lat) {
			$this->Sys_Ordnung_name_lat = $Sys_Ordnung_name_lat;
			return $this;
		}

		public function setSysOrdnungNameDeutsch($Sys_Ordnung_name_deutsch) {
			$this->Sys_Ordnung_name_deutsch = $Sys_Ordnung_name_deutsch;
			return $this;
		}

		public function setSysOrdnungInfoURL($Sys_Ordnung_info_URL) {
			$this->Sys_Ordnung_info_URL = $Sys_Ordnung_info_URL;
			return $this;
		}

		public function setSysOrdnungImgURL($Sys_Ordnung_img_URL) {
			$this->Sys_Ordnung_img_URL = $Sys_Ordnung_img_URL;
			return $this;
		}

		public function setSysOrdnungImgText($Sys_Ordnung_img_text) {
			$this->Sys_Ordnung_img_text = $Sys_Ordnung_img_text;
			return $this;
		}

		public function setSysOrdnungInfo($Sys_Ordnung_info) {
			$this->Sys_Ordnung_info = $Sys_Ordnung_info;
			return $this;
		}




	} 
