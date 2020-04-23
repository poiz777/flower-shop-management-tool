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
	 * NaviConfig
	 * @Table(name="Navi_config")
	 * @Entity(repositoryClass="App\Entity\Repo\NaviConfigRepo")
	 **/
	class NaviConfig { 

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
		 * @Id NaviConfig
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Navi Config Id 
		 * ##FormFieldHint <span class='pz-hint'>Navi_config_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_config_id; 

		/**
		 * @var string
		 * @Column(name="Navi_config_name", type="string", length=50, nullable=false) 
		 * 
		 * ##FormLabel  Navi Config Name 
		 * ##FormFieldHint <span class='pz-hint'>Navi_config_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Navi_config_name; 

		/**
		 * @var int
		 * @Column(name="Navi_config_order", type="smallint", length=3, nullable=false) 
		 * 
		 * ##FormLabel  Navi Config Order 
		 * ##FormFieldHint <span class='pz-hint'>Navi_config_order</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_config_order; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getNaviConfigId() {
			return $this->Navi_config_id;
		}

		public function getNaviConfigName() {
			return $this->Navi_config_name;
		}

		public function getNaviConfigOrder() {
			return $this->Navi_config_order;
		}


		public function setNaviConfigId($Navi_config_id) {
			$this->Navi_config_id = $Navi_config_id;
			return $this;
		}

		public function setNaviConfigName($Navi_config_name) {
			$this->Navi_config_name = $Navi_config_name;
			return $this;
		}

		public function setNaviConfigOrder($Navi_config_order) {
			$this->Navi_config_order = $Navi_config_order;
			return $this;
		}




	} 
