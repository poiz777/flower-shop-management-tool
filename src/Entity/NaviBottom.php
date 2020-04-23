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
	 * NaviBottom
	 * @Table(name="Navi_bottom")
	 * @Entity(repositoryClass="App\Entity\Repo\NaviBottomRepo")
	 **/
	class NaviBottom { 

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
		 * @Id NaviBottom
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Navi Bottom Id 
		 * ##FormFieldHint <span class='pz-hint'>Navi_bottom_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_bottom_id; 

		/**
		 * @var int
		 * @Column(name="Navi_bottom_order", type="integer", length=2, nullable=false) 
		 * 
		 * ##FormLabel  Navi Bottom Order 
		 * ##FormFieldHint <span class='pz-hint'>Navi_bottom_order</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_bottom_order; 

		/**
		 * @var int
		 * @Column(name="Navi_bottom_vis", type="smallint", length=2, nullable=false, options={"default":"1"}) 
		 * 
		 * ##FormLabel  Navi Bottom Vis 
		 * ##FormFieldHint <span class='pz-hint'>Navi_bottom_vis</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_bottom_vis; 

		/**
		 * @var string
		 * @Column(name="Navi_bottom_name", type="string", length=25, nullable=false) 
		 * 
		 * ##FormLabel  Navi Bottom Name 
		 * ##FormFieldHint <span class='pz-hint'>Navi_bottom_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Navi_bottom_name; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getNaviBottomId() {
			return $this->Navi_bottom_id;
		}

		public function getNaviBottomOrder() {
			return $this->Navi_bottom_order;
		}

		public function getNaviBottomVis() {
			return $this->Navi_bottom_vis;
		}

		public function getNaviBottomName() {
			return $this->Navi_bottom_name;
		}


		public function setNaviBottomId($Navi_bottom_id) {
			$this->Navi_bottom_id = $Navi_bottom_id;
			return $this;
		}

		public function setNaviBottomOrder($Navi_bottom_order) {
			$this->Navi_bottom_order = $Navi_bottom_order;
			return $this;
		}

		public function setNaviBottomVis($Navi_bottom_vis) {
			$this->Navi_bottom_vis = $Navi_bottom_vis;
			return $this;
		}

		public function setNaviBottomName($Navi_bottom_name) {
			$this->Navi_bottom_name = $Navi_bottom_name;
			return $this;
		}




	} 
