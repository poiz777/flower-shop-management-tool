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
	 * NaviBottomUserShow
	 * @Table(name="Navi_bottom_user_show")
	 * @Entity(repositoryClass="App\Entity\Repo\NaviBottomUserShowRepo")
	 **/
	class NaviBottomUserShow { 

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
		 * @Id NaviBottomUserShow
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Navi Bottom User Show Id 
		 * ##FormFieldHint <span class='pz-hint'>Navi_bottom_user_show_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_bottom_user_show_id; 

		/**
		 * @var int
		 * @Column(name="Navi_bottom_user_show_user_id", type="integer", length=6, nullable=false) 
		 * 
		 * ##FormLabel  Navi Bottom User Show User Id 
		 * ##FormFieldHint <span class='pz-hint'>Navi_bottom_user_show_user_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_bottom_user_show_user_id; 

		/**
		 * @var int
		 * @Column(name="Navi_bottom_user_show_nav_bottom", type="integer", length=6, nullable=false) 
		 * 
		 * ##FormLabel  Navi Bottom User Show Nav Bottom 
		 * ##FormFieldHint <span class='pz-hint'>Navi_bottom_user_show_nav_bottom</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_bottom_user_show_nav_bottom; 

		/**
		 * @var int
		 * @Column(name="Navi_bottom_user_show_nav_bottom_flag", type="smallint", length=2, nullable=false) 
		 * 
		 * ##FormLabel  Navi Bottom User Show Nav Bottom Flag 
		 * ##FormFieldHint <span class='pz-hint'>Navi_bottom_user_show_nav_bottom_flag</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_bottom_user_show_nav_bottom_flag; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getNaviBottomUserShowId() {
			return $this->Navi_bottom_user_show_id;
		}

		public function getNaviBottomUserShowUserId() {
			return $this->Navi_bottom_user_show_user_id;
		}

		public function getNaviBottomUserShowNavBottom() {
			return $this->Navi_bottom_user_show_nav_bottom;
		}

		public function getNaviBottomUserShowNavBottomFlag() {
			return $this->Navi_bottom_user_show_nav_bottom_flag;
		}


		public function setNaviBottomUserShowId($Navi_bottom_user_show_id) {
			$this->Navi_bottom_user_show_id = $Navi_bottom_user_show_id;
			return $this;
		}

		public function setNaviBottomUserShowUserId($Navi_bottom_user_show_user_id) {
			$this->Navi_bottom_user_show_user_id = $Navi_bottom_user_show_user_id;
			return $this;
		}

		public function setNaviBottomUserShowNavBottom($Navi_bottom_user_show_nav_bottom) {
			$this->Navi_bottom_user_show_nav_bottom = $Navi_bottom_user_show_nav_bottom;
			return $this;
		}

		public function setNaviBottomUserShowNavBottomFlag($Navi_bottom_user_show_nav_bottom_flag) {
			$this->Navi_bottom_user_show_nav_bottom_flag = $Navi_bottom_user_show_nav_bottom_flag;
			return $this;
		}




	} 
