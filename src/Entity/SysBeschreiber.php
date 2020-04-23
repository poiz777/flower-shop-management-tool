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
	 * SysBeschreiber
	 * @Table(name="Sys_Beschreiber")
	 * @Entity(repositoryClass="App\Entity\Repo\SysBeschreiberRepo")
	 **/
	class SysBeschreiber { 

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
		 * @Id SysBeschreiber
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Sys Beschreiber Id 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Beschreiber_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Sys_Beschreiber_id; 

		/**
		 * @var string
		 * @Column(name="Sys_Beschreiber_name", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Beschreiber Name 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Beschreiber_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Beschreiber_name; 

		/**
		 * @var string
		 * @Column(name="Sys_Beschreiber_kuerzel", type="string", length=100, nullable=false) 
		 * 
		 * ##FormLabel  Sys Beschreiber Kuerzel 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Beschreiber_kuerzel</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Beschreiber_kuerzel; 

		/**
		 * @var string
		 * @Column(name="Sys_Beschreiber_info_URL", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Beschreiber Info U R L 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Beschreiber_info_URL</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Beschreiber_info_URL; 

		/**
		 * @var string
		 * @Column(name="Sys_Beschreiber_img_URL", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Beschreiber Img U R L 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Beschreiber_img_URL</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Beschreiber_img_URL; 

		/**
		 * @var string
		 * @Column(name="Sys_Beschreiber_img_text", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Sys Beschreiber Img Text 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Beschreiber_img_text</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Beschreiber_img_text; 

		/**
		 * @var string
		 * @Column(name="Sys_Beschreiber_info", type="string", length=2000, nullable=false) 
		 * 
		 * ##FormLabel  Sys Beschreiber Info 
		 * ##FormFieldHint <span class='pz-hint'>Sys_Beschreiber_info</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Sys_Beschreiber_info; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getSysBeschreiberId() {
			return $this->Sys_Beschreiber_id;
		}

		public function getSysBeschreiberName() {
			return $this->Sys_Beschreiber_name;
		}

		public function getSysBeschreiberKuerzel() {
			return $this->Sys_Beschreiber_kuerzel;
		}

		public function getSysBeschreiberInfoURL() {
			return $this->Sys_Beschreiber_info_URL;
		}

		public function getSysBeschreiberImgURL() {
			return $this->Sys_Beschreiber_img_URL;
		}

		public function getSysBeschreiberImgText() {
			return $this->Sys_Beschreiber_img_text;
		}

		public function getSysBeschreiberInfo() {
			return $this->Sys_Beschreiber_info;
		}


		public function setSysBeschreiberId($Sys_Beschreiber_id) {
			$this->Sys_Beschreiber_id = $Sys_Beschreiber_id;
			return $this;
		}

		public function setSysBeschreiberName($Sys_Beschreiber_name) {
			$this->Sys_Beschreiber_name = $Sys_Beschreiber_name;
			return $this;
		}

		public function setSysBeschreiberKuerzel($Sys_Beschreiber_kuerzel) {
			$this->Sys_Beschreiber_kuerzel = $Sys_Beschreiber_kuerzel;
			return $this;
		}

		public function setSysBeschreiberInfoURL($Sys_Beschreiber_info_URL) {
			$this->Sys_Beschreiber_info_URL = $Sys_Beschreiber_info_URL;
			return $this;
		}

		public function setSysBeschreiberImgURL($Sys_Beschreiber_img_URL) {
			$this->Sys_Beschreiber_img_URL = $Sys_Beschreiber_img_URL;
			return $this;
		}

		public function setSysBeschreiberImgText($Sys_Beschreiber_img_text) {
			$this->Sys_Beschreiber_img_text = $Sys_Beschreiber_img_text;
			return $this;
		}

		public function setSysBeschreiberInfo($Sys_Beschreiber_info) {
			$this->Sys_Beschreiber_info = $Sys_Beschreiber_info;
			return $this;
		}




	} 
