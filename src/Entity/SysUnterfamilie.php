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
	 * SysUnterfamilie
	 * @Table(name="Sys_Unterfamilie")
	 * @Entity(repositoryClass="App\Entity\Repo\SysUnterfamilieRepo")
	 **/
	class SysUnterfamilie { 

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
		 * @Id SysUnterfamilie
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Sys Unterfamilie Id 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Unterfamilie_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Sys_Unterfamilie_id; 

		/**
		 * @var int
		 * @Column(name="Sys_Unterfamilie_Familie_id", type="smallint", length=5, nullable=false) 
		 * 
		 * ##FormLabel  Sys Unterfamilie Familie Id 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Unterfamilie_Familie_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Sys_Unterfamilie_Familie_id; 

		/**
		 * @var string
		 * @Column(name="Sys_Unterfamilie_name", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Unterfamilie Name 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Unterfamilie_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Unterfamilie_name; 

		/**
		 * @var string
		 * @Column(name="Sys_Unterfamilie_info_URL", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Unterfamilie Info U R L 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Unterfamilie_info_URL</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Unterfamilie_info_URL; 

		/**
		 * @var string
		 * @Column(name="Sys_Unterfamilie_img_URL", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Unterfamilie Img U R L 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Unterfamilie_img_URL</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Unterfamilie_img_URL; 

		/**
		 * @var string
		 * @Column(name="Sys_Unterfamilie_img_text", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Unterfamilie Img Text 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Unterfamilie_img_text</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Unterfamilie_img_text; 

		/**
		 * @var string
		 * @Column(name="Sys_Unterfamilie_info", type="string", length=2000, nullable=false) 
		 * 
		 * ##FormLabel  Sys Unterfamilie Info 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Unterfamilie_info</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Unterfamilie_info; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getSysUnterfamilieId() {
			return $this->Sys_Unterfamilie_id;
		}

		public function getSysUnterfamilieFamilieId() {
			return $this->Sys_Unterfamilie_Familie_id;
		}

		public function getSysUnterfamilieName() {
			return $this->Sys_Unterfamilie_name;
		}

		public function getSysUnterfamilieInfoURL() {
			return $this->Sys_Unterfamilie_info_URL;
		}

		public function getSysUnterfamilieImgURL() {
			return $this->Sys_Unterfamilie_img_URL;
		}

		public function getSysUnterfamilieImgText() {
			return $this->Sys_Unterfamilie_img_text;
		}

		public function getSysUnterfamilieInfo() {
			return $this->Sys_Unterfamilie_info;
		}


		public function setSysUnterfamilieId($Sys_Unterfamilie_id) {
			$this->Sys_Unterfamilie_id = $Sys_Unterfamilie_id;
			return $this;
		}

		public function setSysUnterfamilieFamilieId($Sys_Unterfamilie_Familie_id) {
			$this->Sys_Unterfamilie_Familie_id = $Sys_Unterfamilie_Familie_id;
			return $this;
		}

		public function setSysUnterfamilieName($Sys_Unterfamilie_name) {
			$this->Sys_Unterfamilie_name = $Sys_Unterfamilie_name;
			return $this;
		}

		public function setSysUnterfamilieInfoURL($Sys_Unterfamilie_info_URL) {
			$this->Sys_Unterfamilie_info_URL = $Sys_Unterfamilie_info_URL;
			return $this;
		}

		public function setSysUnterfamilieImgURL($Sys_Unterfamilie_img_URL) {
			$this->Sys_Unterfamilie_img_URL = $Sys_Unterfamilie_img_URL;
			return $this;
		}

		public function setSysUnterfamilieImgText($Sys_Unterfamilie_img_text) {
			$this->Sys_Unterfamilie_img_text = $Sys_Unterfamilie_img_text;
			return $this;
		}

		public function setSysUnterfamilieInfo($Sys_Unterfamilie_info) {
			$this->Sys_Unterfamilie_info = $Sys_Unterfamilie_info;
			return $this;
		}




	} 
