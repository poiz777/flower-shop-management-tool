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
	 * Navi1UserShow
	 * @Table(name="Navi_1_user_show")
	 * @Entity(repositoryClass="App\Entity\Repo\Navi1UserShowRepo")
	 **/
	class Navi1UserShow { 

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
		 * @Id Navi1UserShow
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Navi 1 User Show Id 
		 * ##FormFieldHint <span class='pz-hint'>Navi_1_user_show_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_1_user_show_id; 

		/**
		 * @var int
		 * @Column(name="Navi_1_user_show_user_id", type="integer", length=6, nullable=false) 
		 * 
		 * ##FormLabel  Navi 1 User Show User Id 
		 * ##FormFieldHint <span class='pz-hint'>Navi_1_user_show_user_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_1_user_show_user_id; 

		/**
		 * @var int
		 * @Column(name="Navi_1_user_show_nav1", type="integer", length=6, nullable=false) 
		 * 
		 * ##FormLabel  Navi 1 User Show Nav1 
		 * ##FormFieldHint <span class='pz-hint'>Navi_1_user_show_nav1</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_1_user_show_nav1; 

		/**
		 * @var int
		 * @Column(name="Navi_1_user_show_nav1_flag", type="smallint", length=2, nullable=false) 
		 * 
		 * ##FormLabel  Navi 1 User Show Nav1 Flag 
		 * ##FormFieldHint <span class='pz-hint'>Navi_1_user_show_nav1_flag</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_1_user_show_nav1_flag; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getNavi1UserShowId() {
			return $this->Navi_1_user_show_id;
		}

		public function getNavi1UserShowUserId() {
			return $this->Navi_1_user_show_user_id;
		}

		public function getNavi1UserShowNav1() {
			return $this->Navi_1_user_show_nav1;
		}

		public function getNavi1UserShowNav1Flag() {
			return $this->Navi_1_user_show_nav1_flag;
		}


		public function setNavi1UserShowId($Navi_1_user_show_id) {
			$this->Navi_1_user_show_id = $Navi_1_user_show_id;
			return $this;
		}

		public function setNavi1UserShowUserId($Navi_1_user_show_user_id) {
			$this->Navi_1_user_show_user_id = $Navi_1_user_show_user_id;
			return $this;
		}

		public function setNavi1UserShowNav1($Navi_1_user_show_nav1) {
			$this->Navi_1_user_show_nav1 = $Navi_1_user_show_nav1;
			return $this;
		}

		public function setNavi1UserShowNav1Flag($Navi_1_user_show_nav1_flag) {
			$this->Navi_1_user_show_nav1_flag = $Navi_1_user_show_nav1_flag;
			return $this;
		}




	} 
