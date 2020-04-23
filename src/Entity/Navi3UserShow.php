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
	 * Navi3UserShow
	 * @Table(name="Navi_3_user_show")
	 * @Entity(repositoryClass="App\Entity\Repo\Navi3UserShowRepo")
	 **/
	class Navi3UserShow { 

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
		 * @Id Navi3UserShow
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Navi 3 User Show Id 
		 * ##FormFieldHint <span class='pz-hint'>Navi_3_user_show_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_3_user_show_id; 

		/**
		 * @var int
		 * @Column(name="Navi_3_user_show_user_id", type="integer", length=6, nullable=false) 
		 * 
		 * ##FormLabel  Navi 3 User Show User Id 
		 * ##FormFieldHint <span class='pz-hint'>Navi_3_user_show_user_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_3_user_show_user_id; 

		/**
		 * @var int
		 * @Column(name="Navi_3_user_show_nav3", type="integer", length=6, nullable=false) 
		 * 
		 * ##FormLabel  Navi 3 User Show Nav3 
		 * ##FormFieldHint <span class='pz-hint'>Navi_3_user_show_nav3</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_3_user_show_nav3; 

		/**
		 * @var int
		 * @Column(name="Navi_3_user_show_nav3_flag", type="smallint", length=2, nullable=false) 
		 * 
		 * ##FormLabel  Navi 3 User Show Nav3 Flag 
		 * ##FormFieldHint <span class='pz-hint'>Navi_3_user_show_nav3_flag</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navi_3_user_show_nav3_flag; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getNavi3UserShowId() {
			return $this->Navi_3_user_show_id;
		}

		public function getNavi3UserShowUserId() {
			return $this->Navi_3_user_show_user_id;
		}

		public function getNavi3UserShowNav3() {
			return $this->Navi_3_user_show_nav3;
		}

		public function getNavi3UserShowNav3Flag() {
			return $this->Navi_3_user_show_nav3_flag;
		}


		public function setNavi3UserShowId($Navi_3_user_show_id) {
			$this->Navi_3_user_show_id = $Navi_3_user_show_id;
			return $this;
		}

		public function setNavi3UserShowUserId($Navi_3_user_show_user_id) {
			$this->Navi_3_user_show_user_id = $Navi_3_user_show_user_id;
			return $this;
		}

		public function setNavi3UserShowNav3($Navi_3_user_show_nav3) {
			$this->Navi_3_user_show_nav3 = $Navi_3_user_show_nav3;
			return $this;
		}

		public function setNavi3UserShowNav3Flag($Navi_3_user_show_nav3_flag) {
			$this->Navi_3_user_show_nav3_flag = $Navi_3_user_show_nav3_flag;
			return $this;
		}




	} 
