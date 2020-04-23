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
	 * RechnungStatus
	 * @Table(name="Rechnung_status")
	 * @Entity(repositoryClass="App\Entity\Repo\RechnungStatusRepo")
	 **/
	class RechnungStatus { 

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
		 * @Id RechnungStatus
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Rechnung Status Id 
		 * ##FormFieldHint <span class='pz-hint'>Rechnung_status_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Rechnung_status_id; 

		/**
		 * @var string
		 * @Column(name="Rechnung_status_name", type="string", length=25, nullable=false) 
		 * 
		 * ##FormLabel  Rechnung Status Name 
		 * ##FormFieldHint <span class='pz-hint'>Rechnung_status_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Rechnung_status_name; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getRechnungStatusId() {
			return $this->Rechnung_status_id;
		}

		public function getRechnungStatusName() {
			return $this->Rechnung_status_name;
		}


		public function setRechnungStatusId($Rechnung_status_id) {
			$this->Rechnung_status_id = $Rechnung_status_id;
			return $this;
		}

		public function setRechnungStatusName($Rechnung_status_name) {
			$this->Rechnung_status_name = $Rechnung_status_name;
			return $this;
		}




	} 
