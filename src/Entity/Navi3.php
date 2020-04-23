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
	 * Navi3
	 * @Table(name="Navi_3")
	 * @Entity(repositoryClass="App\Entity\Repo\Navi3Repo")
	 **/
	class Navi3 { 

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
		 * @Id Navi3
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Navi 3 Id 
		 * ##FormFieldHint <span class='pz-hint'>Navi_3_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_3_id; 

		/**
		 * @var int
		 * @Column(name="Navi_3_Nav_2_id", type="smallint", length=6, nullable=false) 
		 * 
		 * ##FormLabel  Navi 3 Nav 2 Id 
		 * ##FormFieldHint <span class='pz-hint'>Navi_3_Nav_2_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_3_Nav_2_id; 

		/**
		 * @var int
		 * @Column(name="Navi_3_order", type="integer", length=2, nullable=false) 
		 * 
		 * ##FormLabel  Navi 3 Order 
		 * ##FormFieldHint <span class='pz-hint'>Navi_3_order</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_3_order; 

		/**
		 * @var int
		 * @Column(name="Navi_3_vis", type="smallint", length=2, nullable=false, options={"default":"1"}) 
		 * 
		 * ##FormLabel  Navi 3 Vis 
		 * ##FormFieldHint <span class='pz-hint'>Navi_3_vis</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_3_vis; 

		/**
		 * @var string
		 * @Column(name="Navi_3_name", type="string", length=25, nullable=false) 
		 * 
		 * ##FormLabel  Navi 3 Name 
		 * ##FormFieldHint <span class='pz-hint'>Navi_3_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Navi_3_name; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getNavi3Id() {
			return $this->Navi_3_id;
		}

		public function getNavi3Nav2Id() {
			return $this->Navi_3_Nav_2_id;
		}

		public function getNavi3Order() {
			return $this->Navi_3_order;
		}

		public function getNavi3Vis() {
			return $this->Navi_3_vis;
		}

		public function getNavi3Name() {
			return $this->Navi_3_name;
		}


		public function setNavi3Id($Navi_3_id) {
			$this->Navi_3_id = $Navi_3_id;
			return $this;
		}

		public function setNavi3Nav2Id($Navi_3_Nav_2_id) {
			$this->Navi_3_Nav_2_id = $Navi_3_Nav_2_id;
			return $this;
		}

		public function setNavi3Order($Navi_3_order) {
			$this->Navi_3_order = $Navi_3_order;
			return $this;
		}

		public function setNavi3Vis($Navi_3_vis) {
			$this->Navi_3_vis = $Navi_3_vis;
			return $this;
		}

		public function setNavi3Name($Navi_3_name) {
			$this->Navi_3_name = $Navi_3_name;
			return $this;
		}




	} 
