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
	 * InhaltContainer
	 * @Table(name="Inhalt_container")
	 * @Entity(repositoryClass="App\Entity\Repo\InhaltContainerRepo")
	 **/
	class InhaltContainer { 

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
		 * @Id InhaltContainer
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Inhalt Container Id 
		 * ##FormFieldHint <span class='pz-hint'>Inhalt_container_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Inhalt_container_id; 

		/**
		 * @var int
		 * @Column(name="Inhalt_container_Template_id", type="smallint", length=5, nullable=false) 
		 * 
		 * ##FormLabel  Inhalt Container Template Id 
		 * ##FormFieldHint <span class='pz-hint'>Inhalt_container_Template_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Inhalt_container_Template_id; 

		/**
		 * @var string
		 * @Column(name="Inhalt_container_name", type="string", length=40, nullable=false) 
		 * 
		 * ##FormLabel  Inhalt Container Name 
		 * ##FormFieldHint <span class='pz-hint'>Inhalt_container_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Inhalt_container_name; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getInhaltContainerId() {
			return $this->Inhalt_container_id;
		}

		public function getInhaltContainerTemplateId() {
			return $this->Inhalt_container_Template_id;
		}

		public function getInhaltContainerName() {
			return $this->Inhalt_container_name;
		}


		public function setInhaltContainerId($Inhalt_container_id) {
			$this->Inhalt_container_id = $Inhalt_container_id;
			return $this;
		}

		public function setInhaltContainerTemplateId($Inhalt_container_Template_id) {
			$this->Inhalt_container_Template_id = $Inhalt_container_Template_id;
			return $this;
		}

		public function setInhaltContainerName($Inhalt_container_name) {
			$this->Inhalt_container_name = $Inhalt_container_name;
			return $this;
		}




	} 
