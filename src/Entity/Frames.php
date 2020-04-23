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
	 * Frames
	 * @Table(name="Frames")
	 * @Entity(repositoryClass="App\Entity\Repo\FramesRepo")
	 **/
	class Frames { 

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
		 * @Id Frames
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Frames Id 
		 * ##FormFieldHint <span class='pz-hint'>Frames_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Frames_id; 

		/**
		 * @var string
		 * @Column(name="Frames_name", type="string", length=20, nullable=false) 
		 * 
		 * ##FormLabel  Frames Name 
		 * ##FormFieldHint <span class='pz-hint'>Frames_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Frames_name; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getFramesId() {
			return $this->Frames_id;
		}

		public function getFramesName() {
			return $this->Frames_name;
		}


		public function setFramesId($Frames_id) {
			$this->Frames_id = $Frames_id;
			return $this;
		}

		public function setFramesName($Frames_name) {
			$this->Frames_name = $Frames_name;
			return $this;
		}




	} 
