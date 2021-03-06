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
	 * KreditorenStatus
	 * @Table(name="Kreditoren_status")
	 * @Entity(repositoryClass="App\Entity\Repo\KreditorenStatusRepo")
	 **/
	class KreditorenStatus { 

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
		 * @Id KreditorenStatus
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Kreditoren Status Id 
		 * ##FormFieldHint <span class='pz-hint'>Kreditoren_status_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Kreditoren_status_id; 

		/**
		 * @var string
		 * @Column(name="Kreditoren_status_name", type="string", length=25, nullable=false) 
		 * 
		 * ##FormLabel  Kreditoren Status Name 
		 * ##FormFieldHint <span class='pz-hint'>Kreditoren_status_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Kreditoren_status_name; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getKreditorenStatusId() {
			return $this->Kreditoren_status_id;
		}

		public function getKreditorenStatusName() {
			return $this->Kreditoren_status_name;
		}


		public function setKreditorenStatusId($Kreditoren_status_id) {
			$this->Kreditoren_status_id = $Kreditoren_status_id;
			return $this;
		}

		public function setKreditorenStatusName($Kreditoren_status_name) {
			$this->Kreditoren_status_name = $Kreditoren_status_name;
			return $this;
		}




	} 
