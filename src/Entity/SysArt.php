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
	 * SysArt
	 * @Table(name="Sys_Art")
	 * @Entity(repositoryClass="App\Entity\Repo\SysArtRepo")
	 **/
	class SysArt { 

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
		 * @Id SysArt
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Sys Art Id 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Art_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Sys_Art_id; 

		/**
		 * @var int
		 * @Column(name="Sys_Art_Familie_id", type="smallint", length=5, nullable=false) 
		 * 
		 * ##FormLabel  Sys Art Familie Id 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Art_Familie_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Sys_Art_Familie_id; 

		/**
		 * @var int
		 * @Column(name="Sys_Art_Unterfamilie_id", type="smallint", length=5, nullable=false) 
		 * 
		 * ##FormLabel  Sys Art Unterfamilie Id 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Art_Unterfamilie_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Sys_Art_Unterfamilie_id; 

		/**
		 * @var int
		 * @Column(name="Sys_Art_Gattung_id", type="smallint", length=5, nullable=false) 
		 * 
		 * ##FormLabel  Sys Art Gattung Id 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Art_Gattung_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Sys_Art_Gattung_id; 

		/**
		 * @var string
		 * @Column(name="Sys_Art_name_lat", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Art Name Lat 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Art_name_lat</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Art_name_lat; 

		/**
		 * @var string
		 * @Column(name="Sys_Art_name_deutsch", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Art Name Deutsch 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Art_name_deutsch</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Art_name_deutsch; 

		/**
		 * @var string
		 * @Column(name="Sys_Art_info_URL", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Art Info U R L 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Art_info_URL</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Art_info_URL; 

		/**
		 * @var string
		 * @Column(name="Sys_Art_img_URL", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Art Img U R L 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Art_img_URL</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Art_img_URL; 

		/**
		 * @var string
		 * @Column(name="Sys_Art_img_text", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Art Img Text 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Art_img_text</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Art_img_text; 

		/**
		 * @var string
		 * @Column(name="Sys_Art_info", type="string", length=2000, nullable=false) 
		 * 
		 * ##FormLabel  Sys Art Info 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Art_info</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Art_info; 

		/**
		 * @var int
		 * @Column(name="Sys_Art_Beschreiber", type="smallint", length=5, nullable=false) 
		 * 
		 * ##FormLabel  Sys Art Beschreiber 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Art_Beschreiber</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Sys_Art_Beschreiber; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getSysArtId() {
			return $this->Sys_Art_id;
		}

		public function getSysArtFamilieId() {
			return $this->Sys_Art_Familie_id;
		}

		public function getSysArtUnterfamilieId() {
			return $this->Sys_Art_Unterfamilie_id;
		}

		public function getSysArtGattungId() {
			return $this->Sys_Art_Gattung_id;
		}

		public function getSysArtNameLat() {
			return $this->Sys_Art_name_lat;
		}

		public function getSysArtNameDeutsch() {
			return $this->Sys_Art_name_deutsch;
		}

		public function getSysArtInfoURL() {
			return $this->Sys_Art_info_URL;
		}

		public function getSysArtImgURL() {
			return $this->Sys_Art_img_URL;
		}

		public function getSysArtImgText() {
			return $this->Sys_Art_img_text;
		}

		public function getSysArtInfo() {
			return $this->Sys_Art_info;
		}

		public function getSysArtBeschreiber() {
			return $this->Sys_Art_Beschreiber;
		}


		public function setSysArtId($Sys_Art_id) {
			$this->Sys_Art_id = $Sys_Art_id;
			return $this;
		}

		public function setSysArtFamilieId($Sys_Art_Familie_id) {
			$this->Sys_Art_Familie_id = $Sys_Art_Familie_id;
			return $this;
		}

		public function setSysArtUnterfamilieId($Sys_Art_Unterfamilie_id) {
			$this->Sys_Art_Unterfamilie_id = $Sys_Art_Unterfamilie_id;
			return $this;
		}

		public function setSysArtGattungId($Sys_Art_Gattung_id) {
			$this->Sys_Art_Gattung_id = $Sys_Art_Gattung_id;
			return $this;
		}

		public function setSysArtNameLat($Sys_Art_name_lat) {
			$this->Sys_Art_name_lat = $Sys_Art_name_lat;
			return $this;
		}

		public function setSysArtNameDeutsch($Sys_Art_name_deutsch) {
			$this->Sys_Art_name_deutsch = $Sys_Art_name_deutsch;
			return $this;
		}

		public function setSysArtInfoURL($Sys_Art_info_URL) {
			$this->Sys_Art_info_URL = $Sys_Art_info_URL;
			return $this;
		}

		public function setSysArtImgURL($Sys_Art_img_URL) {
			$this->Sys_Art_img_URL = $Sys_Art_img_URL;
			return $this;
		}

		public function setSysArtImgText($Sys_Art_img_text) {
			$this->Sys_Art_img_text = $Sys_Art_img_text;
			return $this;
		}

		public function setSysArtInfo($Sys_Art_info) {
			$this->Sys_Art_info = $Sys_Art_info;
			return $this;
		}

		public function setSysArtBeschreiber($Sys_Art_Beschreiber) {
			$this->Sys_Art_Beschreiber = $Sys_Art_Beschreiber;
			return $this;
		}




	} 
