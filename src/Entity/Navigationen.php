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
	 * Navigationen
	 * @Table(name="Navigationen")
	 * @Entity(repositoryClass="App\Entity\Repo\NavigationenRepo")
	 **/
	class Navigationen { 

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
		 * @Id Navigationen
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Navigationen Id 
		 * ##FormFieldHint <span class='pz-hint'>Navigationen_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navigationen_id; 

		/**
		 * @var string
		 * @Column(name="Navigationen_name", type="string", length=20, nullable=false) 
		 * 
		 * ##FormLabel  Navigationen Name 
		 * ##FormFieldHint <span class='pz-hint'>Navigationen_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Navigationen_name; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getNavigationenId() {
			return $this->Navigationen_id;
		}

		public function getNavigationenName() {
			return $this->Navigationen_name;
		}


		public function setNavigationenId($Navigationen_id) {
			$this->Navigationen_id = $Navigationen_id;
			return $this;
		}

		public function setNavigationenName($Navigationen_name) {
			$this->Navigationen_name = $Navigationen_name;
			return $this;
		}




	} 
