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
	 * VerkaufStatus
	 * @Table(name="verkauf_status")
	 * @Entity(repositoryClass="App\Entity\Repo\VerkaufStatusRepo")
	 **/
	class VerkaufStatus { 

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
		 * @Id VerkaufStatus
		 * @Column(type="integer")
		 * 
		 * ##FormLabel Verkauf Status Id 
		 * ##FormFieldHint <span class='pz-hint'>verkauf_status_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $verkauf_status_id; 

		/**
		 * @var string
		 * @Column(name="verkauf_status_name", type="string", length=30, nullable=false) 
		 * 
		 * ##FormLabel Verkauf Status Name 
		 * ##FormFieldHint <span class='pz-hint'>verkauf_status_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $verkauf_status_name; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getVerkaufStatusId() {
			return $this->verkauf_status_id;
		}

		public function getVerkaufStatusName() {
			return $this->verkauf_status_name;
		}


		public function setVerkaufStatusId($verkauf_status_id) {
			$this->verkauf_status_id = $verkauf_status_id;
			return $this;
		}

		public function setVerkaufStatusName($verkauf_status_name) {
			$this->verkauf_status_name = $verkauf_status_name;
			return $this;
		}




	} 
