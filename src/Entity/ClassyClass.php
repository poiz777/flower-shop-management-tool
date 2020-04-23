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
	 * Class
	 * @Table(name="ClassyClass")
	 * @Entity(repositoryClass="App\Entity\Repo\ClassyClassRepo")
	 **/
	class ClassyClass {

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
		 * @Id Class
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Class Id 
		 * ##FormFieldHint <span class='pz-hint'>Class_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Class_id; 

		/**
		 * @var string
		 * @Column(name="Class_name", type="string", length=20, nullable=false) 
		 * 
		 * ##FormLabel  Class Name 
		 * ##FormFieldHint <span class='pz-hint'>Class_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Class_name; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getClassId() {
			return $this->Class_id;
		}

		public function getClassName() {
			return $this->Class_name;
		}


		public function setClassId($Class_id) {
			$this->Class_id = $Class_id;
			return $this;
		}

		public function setClassName($Class_name) {
			$this->Class_name = $Class_name;
			return $this;
		}




	} 
