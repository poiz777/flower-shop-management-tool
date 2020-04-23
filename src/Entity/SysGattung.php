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
	 * SysGattung
	 * @Table(name="Sys_Gattung")
	 * @Entity(repositoryClass="App\Entity\Repo\SysGattungRepo")
	 **/
	class SysGattung { 

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
		 * @Id SysGattung
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Sys Gattung Id 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Gattung_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Sys_Gattung_id; 

		/**
		 * @var int
		 * @Column(name="Sys_Gattung_Unterfamilie_id", type="smallint", length=5, nullable=false) 
		 * 
		 * ##FormLabel  Sys Gattung Unterfamilie Id 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Gattung_Unterfamilie_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Sys_Gattung_Unterfamilie_id; 

		/**
		 * @var int
		 * @Column(name="Sys_Gattung_Familie_id", type="smallint", length=5, nullable=false) 
		 * 
		 * ##FormLabel  Sys Gattung Familie Id 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Gattung_Familie_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Sys_Gattung_Familie_id; 

		/**
		 * @var string
		 * @Column(name="Sys_Gattung_name_lat", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Gattung Name Lat 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Gattung_name_lat</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Gattung_name_lat; 

		/**
		 * @var string
		 * @Column(name="Sys_Gattung_name_deutsch", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Gattung Name Deutsch 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Gattung_name_deutsch</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Gattung_name_deutsch; 

		/**
		 * @var string
		 * @Column(name="Sys_Gattung_info_URL", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Gattung Info U R L 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Gattung_info_URL</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Gattung_info_URL; 

		/**
		 * @var string
		 * @Column(name="Sys_Gattung_img_URL", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Gattung Img U R L 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Gattung_img_URL</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Gattung_img_URL; 

		/**
		 * @var string
		 * @Column(name="Sys_Gattung_img_text", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Gattung Img Text 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Gattung_img_text</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Gattung_img_text; 

		/**
		 * @var string
		 * @Column(name="Sys_Gattung_info", type="string", length=2000, nullable=false) 
		 * 
		 * ##FormLabel  Sys Gattung Info 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Gattung_info</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Gattung_info; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getSysGattungId() {
			return $this->Sys_Gattung_id;
		}

		public function getSysGattungUnterfamilieId() {
			return $this->Sys_Gattung_Unterfamilie_id;
		}

		public function getSysGattungFamilieId() {
			return $this->Sys_Gattung_Familie_id;
		}

		public function getSysGattungNameLat() {
			return $this->Sys_Gattung_name_lat;
		}

		public function getSysGattungNameDeutsch() {
			return $this->Sys_Gattung_name_deutsch;
		}

		public function getSysGattungInfoURL() {
			return $this->Sys_Gattung_info_URL;
		}

		public function getSysGattungImgURL() {
			return $this->Sys_Gattung_img_URL;
		}

		public function getSysGattungImgText() {
			return $this->Sys_Gattung_img_text;
		}

		public function getSysGattungInfo() {
			return $this->Sys_Gattung_info;
		}


		public function setSysGattungId($Sys_Gattung_id) {
			$this->Sys_Gattung_id = $Sys_Gattung_id;
			return $this;
		}

		public function setSysGattungUnterfamilieId($Sys_Gattung_Unterfamilie_id) {
			$this->Sys_Gattung_Unterfamilie_id = $Sys_Gattung_Unterfamilie_id;
			return $this;
		}

		public function setSysGattungFamilieId($Sys_Gattung_Familie_id) {
			$this->Sys_Gattung_Familie_id = $Sys_Gattung_Familie_id;
			return $this;
		}

		public function setSysGattungNameLat($Sys_Gattung_name_lat) {
			$this->Sys_Gattung_name_lat = $Sys_Gattung_name_lat;
			return $this;
		}

		public function setSysGattungNameDeutsch($Sys_Gattung_name_deutsch) {
			$this->Sys_Gattung_name_deutsch = $Sys_Gattung_name_deutsch;
			return $this;
		}

		public function setSysGattungInfoURL($Sys_Gattung_info_URL) {
			$this->Sys_Gattung_info_URL = $Sys_Gattung_info_URL;
			return $this;
		}

		public function setSysGattungImgURL($Sys_Gattung_img_URL) {
			$this->Sys_Gattung_img_URL = $Sys_Gattung_img_URL;
			return $this;
		}

		public function setSysGattungImgText($Sys_Gattung_img_text) {
			$this->Sys_Gattung_img_text = $Sys_Gattung_img_text;
			return $this;
		}

		public function setSysGattungInfo($Sys_Gattung_info) {
			$this->Sys_Gattung_info = $Sys_Gattung_info;
			return $this;
		}




	} 
