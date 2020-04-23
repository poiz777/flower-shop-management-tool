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
	 * Navi2UserShow
	 * @Table(name="Navi_2_user_show")
	 * @Entity(repositoryClass="App\Entity\Repo\Navi2UserShowRepo")
	 **/
	class Navi2UserShow { 

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
		 * @Id Navi2UserShow
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Navi 2 User Show Id 
		 * ##FormFieldHint <span class='pz-hint'>Navi_2_user_show_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_2_user_show_id; 

		/**
		 * @var int
		 * @Column(name="Navi_2_user_show_user_id", type="integer", length=6, nullable=false) 
		 * 
		 * ##FormLabel  Navi 2 User Show User Id 
		 * ##FormFieldHint <span class='pz-hint'>Navi_2_user_show_user_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_2_user_show_user_id; 

		/**
		 * @var int
		 * @Column(name="Navi_2_user_show_nav2", type="integer", length=6, nullable=false) 
		 * 
		 * ##FormLabel  Navi 2 User Show Nav2 
		 * ##FormFieldHint <span class='pz-hint'>Navi_2_user_show_nav2</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_2_user_show_nav2; 

		/**
		 * @var int
		 * @Column(name="Navi_2_user_show_nav2_flag", type="smallint", length=2, nullable=false) 
		 * 
		 * ##FormLabel  Navi 2 User Show Nav2 Flag 
		 * ##FormFieldHint <span class='pz-hint'>Navi_2_user_show_nav2_flag</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_2_user_show_nav2_flag; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getNavi2UserShowId() {
			return $this->Navi_2_user_show_id;
		}

		public function getNavi2UserShowUserId() {
			return $this->Navi_2_user_show_user_id;
		}

		public function getNavi2UserShowNav2() {
			return $this->Navi_2_user_show_nav2;
		}

		public function getNavi2UserShowNav2Flag() {
			return $this->Navi_2_user_show_nav2_flag;
		}


		public function setNavi2UserShowId($Navi_2_user_show_id) {
			$this->Navi_2_user_show_id = $Navi_2_user_show_id;
			return $this;
		}

		public function setNavi2UserShowUserId($Navi_2_user_show_user_id) {
			$this->Navi_2_user_show_user_id = $Navi_2_user_show_user_id;
			return $this;
		}

		public function setNavi2UserShowNav2($Navi_2_user_show_nav2) {
			$this->Navi_2_user_show_nav2 = $Navi_2_user_show_nav2;
			return $this;
		}

		public function setNavi2UserShowNav2Flag($Navi_2_user_show_nav2_flag) {
			$this->Navi_2_user_show_nav2_flag = $Navi_2_user_show_nav2_flag;
			return $this;
		}




	} 
