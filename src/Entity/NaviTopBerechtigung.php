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
	 * NaviTopBerechtigung
	 * @Table(name="Navi_top_berechtigung")
	 * @Entity(repositoryClass="App\Entity\Repo\NaviTopBerechtigungRepo")
	 **/
	class NaviTopBerechtigung { 

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
		 * @Id NaviTopBerechtigung
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Navi Top Berechtigung Id 
		 * ##FormFieldHint <span class='pz-hint'>Navi_top_berechtigung_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_top_berechtigung_id; 

		/**
		 * @var int
		 * @Column(name="Navi_top_berechtigung_config_id", type="integer", length=5, nullable=false) 
		 * 
		 * ##FormLabel  Navi Top Berechtigung Config Id 
		 * ##FormFieldHint <span class='pz-hint'>Navi_top_berechtigung_config_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_top_berechtigung_config_id; 

		/**
		 * @var int
		 * @Column(name="Navi_top_berechtigung_nav_id", type="smallint", length=3, nullable=false) 
		 * 
		 * ##FormLabel  Navi Top Berechtigung Nav Id 
		 * ##FormFieldHint <span class='pz-hint'>Navi_top_berechtigung_nav_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_top_berechtigung_nav_id; 

		/**
		 * @var int
		 * @Column(name="Navi_top_berechtigung_flag", type="smallint", length=2, nullable=false) 
		 * 
		 * ##FormLabel  Navi Top Berechtigung Flag 
		 * ##FormFieldHint <span class='pz-hint'>Navi_top_berechtigung_flag</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_top_berechtigung_flag; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getNaviTopBerechtigungId() {
			return $this->Navi_top_berechtigung_id;
		}

		public function getNaviTopBerechtigungConfigId() {
			return $this->Navi_top_berechtigung_config_id;
		}

		public function getNaviTopBerechtigungNavId() {
			return $this->Navi_top_berechtigung_nav_id;
		}

		public function getNaviTopBerechtigungFlag() {
			return $this->Navi_top_berechtigung_flag;
		}


		public function setNaviTopBerechtigungId($Navi_top_berechtigung_id) {
			$this->Navi_top_berechtigung_id = $Navi_top_berechtigung_id;
			return $this;
		}

		public function setNaviTopBerechtigungConfigId($Navi_top_berechtigung_config_id) {
			$this->Navi_top_berechtigung_config_id = $Navi_top_berechtigung_config_id;
			return $this;
		}

		public function setNaviTopBerechtigungNavId($Navi_top_berechtigung_nav_id) {
			$this->Navi_top_berechtigung_nav_id = $Navi_top_berechtigung_nav_id;
			return $this;
		}

		public function setNaviTopBerechtigungFlag($Navi_top_berechtigung_flag) {
			$this->Navi_top_berechtigung_flag = $Navi_top_berechtigung_flag;
			return $this;
		}




	} 
