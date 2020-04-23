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
	 * NaviTopUserShow
	 * @Table(name="Navi_top_user_show")
	 * @Entity(repositoryClass="App\Entity\Repo\NaviTopUserShowRepo")
	 **/
	class NaviTopUserShow { 

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
		 * @Id NaviTopUserShow
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Navi Top User Show Id 
		 * ##FormFieldHint <span class='pz-hint'>Navi_top_user_show_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_top_user_show_id; 

		/**
		 * @var int
		 * @Column(name="Navi_top_user_show_user_id", type="integer", length=6, nullable=false) 
		 * 
		 * ##FormLabel  Navi Top User Show User Id 
		 * ##FormFieldHint <span class='pz-hint'>Navi_top_user_show_user_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_top_user_show_user_id; 

		/**
		 * @var int
		 * @Column(name="Navi_top_user_show_nav_top", type="integer", length=6, nullable=false) 
		 * 
		 * ##FormLabel  Navi Top User Show Nav Top 
		 * ##FormFieldHint <span class='pz-hint'>Navi_top_user_show_nav_top</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_top_user_show_nav_top; 

		/**
		 * @var int
		 * @Column(name="Navi_top_user_show_nav_top_flag", type="smallint", length=2, nullable=false) 
		 * 
		 * ##FormLabel  Navi Top User Show Nav Top Flag 
		 * ##FormFieldHint <span class='pz-hint'>Navi_top_user_show_nav_top_flag</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_top_user_show_nav_top_flag; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getNaviTopUserShowId() {
			return $this->Navi_top_user_show_id;
		}

		public function getNaviTopUserShowUserId() {
			return $this->Navi_top_user_show_user_id;
		}

		public function getNaviTopUserShowNavTop() {
			return $this->Navi_top_user_show_nav_top;
		}

		public function getNaviTopUserShowNavTopFlag() {
			return $this->Navi_top_user_show_nav_top_flag;
		}


		public function setNaviTopUserShowId($Navi_top_user_show_id) {
			$this->Navi_top_user_show_id = $Navi_top_user_show_id;
			return $this;
		}

		public function setNaviTopUserShowUserId($Navi_top_user_show_user_id) {
			$this->Navi_top_user_show_user_id = $Navi_top_user_show_user_id;
			return $this;
		}

		public function setNaviTopUserShowNavTop($Navi_top_user_show_nav_top) {
			$this->Navi_top_user_show_nav_top = $Navi_top_user_show_nav_top;
			return $this;
		}

		public function setNaviTopUserShowNavTopFlag($Navi_top_user_show_nav_top_flag) {
			$this->Navi_top_user_show_nav_top_flag = $Navi_top_user_show_nav_top_flag;
			return $this;
		}




	} 
