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
	 * Navi1Berechtigung
	 * @Table(name="Navi_1_berechtigung")
	 * @Entity(repositoryClass="App\Entity\Repo\Navi1BerechtigungRepo")
	 **/
	class Navi1Berechtigung { 

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
		 * @Id Navi1Berechtigung
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Navi 1 Berechtigung Id 
		 * ##FormFieldHint <span class='pz-hint'>Navi_1_berechtigung_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_1_berechtigung_id; 

		/**
		 * @var int
		 * @Column(name="Navi_1_berechtigung_config_id", type="integer", length=5, nullable=false) 
		 * 
		 * ##FormLabel  Navi 1 Berechtigung Config Id 
		 * ##FormFieldHint <span class='pz-hint'>Navi_1_berechtigung_config_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_1_berechtigung_config_id; 

		/**
		 * @var int
		 * @Column(name="Navi_1_berechtigung_nav_id", type="smallint", length=3, nullable=false) 
		 * 
		 * ##FormLabel  Navi 1 Berechtigung Nav Id 
		 * ##FormFieldHint <span class='pz-hint'>Navi_1_berechtigung_nav_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_1_berechtigung_nav_id; 

		/**
		 * @var int
		 * @Column(name="Navi_1_berechtigung_flag", type="smallint", length=2, nullable=false) 
		 * 
		 * ##FormLabel  Navi 1 Berechtigung Flag 
		 * ##FormFieldHint <span class='pz-hint'>Navi_1_berechtigung_flag</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_1_berechtigung_flag; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getNavi1BerechtigungId() {
			return $this->Navi_1_berechtigung_id;
		}

		public function getNavi1BerechtigungConfigId() {
			return $this->Navi_1_berechtigung_config_id;
		}

		public function getNavi1BerechtigungNavId() {
			return $this->Navi_1_berechtigung_nav_id;
		}

		public function getNavi1BerechtigungFlag() {
			return $this->Navi_1_berechtigung_flag;
		}


		public function setNavi1BerechtigungId($Navi_1_berechtigung_id) {
			$this->Navi_1_berechtigung_id = $Navi_1_berechtigung_id;
			return $this;
		}

		public function setNavi1BerechtigungConfigId($Navi_1_berechtigung_config_id) {
			$this->Navi_1_berechtigung_config_id = $Navi_1_berechtigung_config_id;
			return $this;
		}

		public function setNavi1BerechtigungNavId($Navi_1_berechtigung_nav_id) {
			$this->Navi_1_berechtigung_nav_id = $Navi_1_berechtigung_nav_id;
			return $this;
		}

		public function setNavi1BerechtigungFlag($Navi_1_berechtigung_flag) {
			$this->Navi_1_berechtigung_flag = $Navi_1_berechtigung_flag;
			return $this;
		}




	} 
