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
	 * NaviTop
	 * @Table(name="Navi_top")
	 * @Entity(repositoryClass="App\Entity\Repo\NaviTopRepo")
	 **/
	class NaviTop { 

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
		 * @Id NaviTop
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Navi Top Id 
		 * ##FormFieldHint <span class='pz-hint'>Navi_top_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_top_id; 

		/**
		 * @var int
		 * @Column(name="Navi_top_order", type="integer", length=2, nullable=false) 
		 * 
		 * ##FormLabel  Navi Top Order 
		 * ##FormFieldHint <span class='pz-hint'>Navi_top_order</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_top_order; 

		/**
		 * @var int
		 * @Column(name="Navi_top_vis", type="smallint", length=2, nullable=false, options={"default":"1"}) 
		 * 
		 * ##FormLabel  Navi Top Vis 
		 * ##FormFieldHint <span class='pz-hint'>Navi_top_vis</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_top_vis; 

		/**
		 * @var string
		 * @Column(name="Navi_top_name", type="string", length=25, nullable=false) 
		 * 
		 * ##FormLabel  Navi Top Name 
		 * ##FormFieldHint <span class='pz-hint'>Navi_top_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Navi_top_name; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getNaviTopId() {
			return $this->Navi_top_id;
		}

		public function getNaviTopOrder() {
			return $this->Navi_top_order;
		}

		public function getNaviTopVis() {
			return $this->Navi_top_vis;
		}

		public function getNaviTopName() {
			return $this->Navi_top_name;
		}


		public function setNaviTopId($Navi_top_id) {
			$this->Navi_top_id = $Navi_top_id;
			return $this;
		}

		public function setNaviTopOrder($Navi_top_order) {
			$this->Navi_top_order = $Navi_top_order;
			return $this;
		}

		public function setNaviTopVis($Navi_top_vis) {
			$this->Navi_top_vis = $Navi_top_vis;
			return $this;
		}

		public function setNaviTopName($Navi_top_name) {
			$this->Navi_top_name = $Navi_top_name;
			return $this;
		}




	} 
