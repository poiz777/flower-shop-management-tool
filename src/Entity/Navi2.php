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
	 * Navi2
	 * @Table(name="Navi_2")
	 * @Entity(repositoryClass="App\Entity\Repo\Navi2Repo")
	 **/
	class Navi2 { 

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
		 * @Id Navi2
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Navi 2 Id 
		 * ##FormFieldHint <span class='pz-hint'>Navi_2_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_2_id; 

		/**
		 * @var int
		 * @Column(name="Navi_2_Nav_1_id", type="smallint", length=6, nullable=false) 
		 * 
		 * ##FormLabel  Navi 2 Nav 1 Id 
		 * ##FormFieldHint <span class='pz-hint'>Navi_2_Nav_1_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_2_Nav_1_id; 

		/**
		 * @var int
		 * @Column(name="Navi_2_order", type="integer", length=2, nullable=false) 
		 * 
		 * ##FormLabel  Navi 2 Order 
		 * ##FormFieldHint <span class='pz-hint'>Navi_2_order</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_2_order; 

		/**
		 * @var int
		 * @Column(name="Navi_2_vis", type="smallint", length=2, nullable=false, options={"default":"1"}) 
		 * 
		 * ##FormLabel  Navi 2 Vis 
		 * ##FormFieldHint <span class='pz-hint'>Navi_2_vis</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_2_vis; 

		/**
		 * @var string
		 * @Column(name="Navi_2_name", type="string", length=25, nullable=false) 
		 * 
		 * ##FormLabel  Navi 2 Name 
		 * ##FormFieldHint <span class='pz-hint'>Navi_2_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Navi_2_name; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getNavi2Id() {
			return $this->Navi_2_id;
		}

		public function getNavi2Nav1Id() {
			return $this->Navi_2_Nav_1_id;
		}

		public function getNavi2Order() {
			return $this->Navi_2_order;
		}

		public function getNavi2Vis() {
			return $this->Navi_2_vis;
		}

		public function getNavi2Name() {
			return $this->Navi_2_name;
		}


		public function setNavi2Id($Navi_2_id) {
			$this->Navi_2_id = $Navi_2_id;
			return $this;
		}

		public function setNavi2Nav1Id($Navi_2_Nav_1_id) {
			$this->Navi_2_Nav_1_id = $Navi_2_Nav_1_id;
			return $this;
		}

		public function setNavi2Order($Navi_2_order) {
			$this->Navi_2_order = $Navi_2_order;
			return $this;
		}

		public function setNavi2Vis($Navi_2_vis) {
			$this->Navi_2_vis = $Navi_2_vis;
			return $this;
		}

		public function setNavi2Name($Navi_2_name) {
			$this->Navi_2_name = $Navi_2_name;
			return $this;
		}




	} 
