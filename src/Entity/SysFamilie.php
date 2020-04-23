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
	 * SysFamilie
	 * @Table(name="Sys_Familie")
	 * @Entity(repositoryClass="App\Entity\Repo\SysFamilieRepo")
	 **/
	class SysFamilie { 

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
		 * @Id SysFamilie
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Sys Familie Id 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Familie_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Sys_Familie_id; 

		/**
		 * @var int
		 * @Column(name="Sys_Familie_Unterklasse_id", type="smallint", length=5, nullable=false) 
		 * 
		 * ##FormLabel  Sys Familie Unterklasse Id 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Familie_Unterklasse_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Sys_Familie_Unterklasse_id; 

		/**
		 * @var int
		 * @Column(name="Sys_Familie_Ordnung_id", type="smallint", length=5, nullable=false) 
		 * 
		 * ##FormLabel  Sys Familie Ordnung Id 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Familie_Ordnung_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Sys_Familie_Ordnung_id; 

		/**
		 * @var string
		 * @Column(name="Sys_Familie_name_lat", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Familie Name Lat 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Familie_name_lat</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Familie_name_lat; 

		/**
		 * @var string
		 * @Column(name="Sys_Familie_name_deutsch", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Familie Name Deutsch 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Familie_name_deutsch</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Familie_name_deutsch; 

		/**
		 * @var string
		 * @Column(name="Sys_Familie_info_URL", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Familie Info U R L 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Familie_info_URL</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Familie_info_URL; 

		/**
		 * @var string
		 * @Column(name="Sys_Familie_img_URL", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Familie Img U R L 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Familie_img_URL</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Familie_img_URL; 

		/**
		 * @var string
		 * @Column(name="Sys_Familie_img_text", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Familie Img Text 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Familie_img_text</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Familie_img_text; 

		/**
		 * @var string
		 * @Column(name="Sys_Familie_info", type="string", length=2000, nullable=false) 
		 * 
		 * ##FormLabel  Sys Familie Info 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Familie_info</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Familie_info; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getSysFamilieId() {
			return $this->Sys_Familie_id;
		}

		public function getSysFamilieUnterklasseId() {
			return $this->Sys_Familie_Unterklasse_id;
		}

		public function getSysFamilieOrdnungId() {
			return $this->Sys_Familie_Ordnung_id;
		}

		public function getSysFamilieNameLat() {
			return $this->Sys_Familie_name_lat;
		}

		public function getSysFamilieNameDeutsch() {
			return $this->Sys_Familie_name_deutsch;
		}

		public function getSysFamilieInfoURL() {
			return $this->Sys_Familie_info_URL;
		}

		public function getSysFamilieImgURL() {
			return $this->Sys_Familie_img_URL;
		}

		public function getSysFamilieImgText() {
			return $this->Sys_Familie_img_text;
		}

		public function getSysFamilieInfo() {
			return $this->Sys_Familie_info;
		}


		public function setSysFamilieId($Sys_Familie_id) {
			$this->Sys_Familie_id = $Sys_Familie_id;
			return $this;
		}

		public function setSysFamilieUnterklasseId($Sys_Familie_Unterklasse_id) {
			$this->Sys_Familie_Unterklasse_id = $Sys_Familie_Unterklasse_id;
			return $this;
		}

		public function setSysFamilieOrdnungId($Sys_Familie_Ordnung_id) {
			$this->Sys_Familie_Ordnung_id = $Sys_Familie_Ordnung_id;
			return $this;
		}

		public function setSysFamilieNameLat($Sys_Familie_name_lat) {
			$this->Sys_Familie_name_lat = $Sys_Familie_name_lat;
			return $this;
		}

		public function setSysFamilieNameDeutsch($Sys_Familie_name_deutsch) {
			$this->Sys_Familie_name_deutsch = $Sys_Familie_name_deutsch;
			return $this;
		}

		public function setSysFamilieInfoURL($Sys_Familie_info_URL) {
			$this->Sys_Familie_info_URL = $Sys_Familie_info_URL;
			return $this;
		}

		public function setSysFamilieImgURL($Sys_Familie_img_URL) {
			$this->Sys_Familie_img_URL = $Sys_Familie_img_URL;
			return $this;
		}

		public function setSysFamilieImgText($Sys_Familie_img_text) {
			$this->Sys_Familie_img_text = $Sys_Familie_img_text;
			return $this;
		}

		public function setSysFamilieInfo($Sys_Familie_info) {
			$this->Sys_Familie_info = $Sys_Familie_info;
			return $this;
		}




	} 
