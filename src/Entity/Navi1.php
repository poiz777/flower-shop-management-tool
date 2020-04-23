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
	 * Navi1
	 * @Table(name="Navi_1")
	 * @Entity(repositoryClass="App\Entity\Repo\Navi1Repo")
	 **/
	class Navi1 { 

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
		 * @Id Navi1
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Navi 1 Id 
		 * ##FormFieldHint <span class='pz-hint'>Navi_1_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_1_id; 

		/**
		 * @var int
		 * @Column(name="Navi_1_order", type="integer", length=2, nullable=false) 
		 * 
		 * ##FormLabel  Navi 1 Order 
		 * ##FormFieldHint <span class='pz-hint'>Navi_1_order</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_1_order; 

		/**
		 * @var int
		 * @Column(name="Navi_1_vis", type="smallint", length=2, nullable=false, options={"default":"1"}) 
		 * 
		 * ##FormLabel  Navi 1 Vis 
		 * ##FormFieldHint <span class='pz-hint'>Navi_1_vis</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_1_vis; 

		/**
		 * @var string
		 * @Column(name="Navi_1_name", type="string", length=25, nullable=false) 
		 * 
		 * ##FormLabel  Navi 1 Name 
		 * ##FormFieldHint <span class='pz-hint'>Navi_1_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Navi_1_name; 

		/**
		 * @var string
		 * @Column(name="Navi_1_img", type="string", length=30, nullable=false) 
		 * 
		 * ##FormLabel  Navi 1 Img 
		 * ##FormFieldHint <span class='pz-hint'>Navi_1_img</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Navi_1_img; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getNavi1Id() {
			return $this->Navi_1_id;
		}

		public function getNavi1Order() {
			return $this->Navi_1_order;
		}

		public function getNavi1Vis() {
			return $this->Navi_1_vis;
		}

		public function getNavi1Name() {
			return $this->Navi_1_name;
		}

		public function getNavi1Img() {
			return $this->Navi_1_img;
		}


		public function setNavi1Id($Navi_1_id) {
			$this->Navi_1_id = $Navi_1_id;
			return $this;
		}

		public function setNavi1Order($Navi_1_order) {
			$this->Navi_1_order = $Navi_1_order;
			return $this;
		}

		public function setNavi1Vis($Navi_1_vis) {
			$this->Navi_1_vis = $Navi_1_vis;
			return $this;
		}

		public function setNavi1Name($Navi_1_name) {
			$this->Navi_1_name = $Navi_1_name;
			return $this;
		}

		public function setNavi1Img($Navi_1_img) {
			$this->Navi_1_img = $Navi_1_img;
			return $this;
		}




	} 
