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
	 * SysAbteilung
	 * @Table(name="Sys_Abteilung")
	 * @Entity(repositoryClass="App\Entity\Repo\SysAbteilungRepo")
	 **/
	class SysAbteilung { 

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
		 * @Id SysAbteilung
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Sys Abteilung Id 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Abteilung_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Sys_Abteilung_id; 

		/**
		 * @var string
		 * @Column(name="Sys_Abteilung_name_lat", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Abteilung Name Lat 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Abteilung_name_lat</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Abteilung_name_lat; 

		/**
		 * @var string
		 * @Column(name="Sys_Abteilung_name_deusch", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Abteilung Name Deusch 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Abteilung_name_deusch</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Abteilung_name_deusch; 

		/**
		 * @var string
		 * @Column(name="Sys_Abteilung_info_URL", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Abteilung Info U R L 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Abteilung_info_URL</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Abteilung_info_URL; 

		/**
		 * @var string
		 * @Column(name="Sys_Abteilung_img_URL", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Abteilung Img U R L 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Abteilung_img_URL</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Abteilung_img_URL; 

		/**
		 * @var string
		 * @Column(name="Sys_Abteilung_img_text", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Abteilung Img Text 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Abteilung_img_text</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Abteilung_img_text; 

		/**
		 * @var string
		 * @Column(name="Sys_Abteilung_info", type="string", length=2000, nullable=false) 
		 * 
		 * ##FormLabel  Sys Abteilung Info 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Abteilung_info</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Abteilung_info; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getSysAbteilungId() {
			return $this->Sys_Abteilung_id;
		}

		public function getSysAbteilungNameLat() {
			return $this->Sys_Abteilung_name_lat;
		}

		public function getSysAbteilungNameDeusch() {
			return $this->Sys_Abteilung_name_deusch;
		}

		public function getSysAbteilungInfoURL() {
			return $this->Sys_Abteilung_info_URL;
		}

		public function getSysAbteilungImgURL() {
			return $this->Sys_Abteilung_img_URL;
		}

		public function getSysAbteilungImgText() {
			return $this->Sys_Abteilung_img_text;
		}

		public function getSysAbteilungInfo() {
			return $this->Sys_Abteilung_info;
		}


		public function setSysAbteilungId($Sys_Abteilung_id) {
			$this->Sys_Abteilung_id = $Sys_Abteilung_id;
			return $this;
		}

		public function setSysAbteilungNameLat($Sys_Abteilung_name_lat) {
			$this->Sys_Abteilung_name_lat = $Sys_Abteilung_name_lat;
			return $this;
		}

		public function setSysAbteilungNameDeusch($Sys_Abteilung_name_deusch) {
			$this->Sys_Abteilung_name_deusch = $Sys_Abteilung_name_deusch;
			return $this;
		}

		public function setSysAbteilungInfoURL($Sys_Abteilung_info_URL) {
			$this->Sys_Abteilung_info_URL = $Sys_Abteilung_info_URL;
			return $this;
		}

		public function setSysAbteilungImgURL($Sys_Abteilung_img_URL) {
			$this->Sys_Abteilung_img_URL = $Sys_Abteilung_img_URL;
			return $this;
		}

		public function setSysAbteilungImgText($Sys_Abteilung_img_text) {
			$this->Sys_Abteilung_img_text = $Sys_Abteilung_img_text;
			return $this;
		}

		public function setSysAbteilungInfo($Sys_Abteilung_info) {
			$this->Sys_Abteilung_info = $Sys_Abteilung_info;
			return $this;
		}




	} 
