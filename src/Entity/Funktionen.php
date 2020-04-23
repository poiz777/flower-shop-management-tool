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
	 * Funktionen
	 * @Table(name="Funktionen")
	 * @Entity(repositoryClass="App\Entity\Repo\FunktionenRepo")
	 **/
	class Funktionen { 

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
		 * @Id Funktionen
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Funktionen Id 
		 * ##FormFieldHint <span class='pz-hint'>Funktionen_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Funktionen_id; 

		/**
		 * @var string
		 * @Column(name="Funktionen_name", type="string", length=50, nullable=false) 
		 * 
		 * ##FormLabel  Funktionen Name 
		 * ##FormFieldHint <span class='pz-hint'>Funktionen_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Funktionen_name; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getFunktionenId() {
			return $this->Funktionen_id;
		}

		public function getFunktionenName() {
			return $this->Funktionen_name;
		}


		public function setFunktionenId($Funktionen_id) {
			$this->Funktionen_id = $Funktionen_id;
			return $this;
		}

		public function setFunktionenName($Funktionen_name) {
			$this->Funktionen_name = $Funktionen_name;
			return $this;
		}




	} 
