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
	 * BestellungenStatus
	 * @Table(name="Bestellungen_status")
	 * @Entity(repositoryClass="App\Entity\Repo\BestellungenStatusRepo")
	 **/
	class BestellungenStatus { 

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
		 * @Id BestellungenStatus
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Bestellungen Status Id 
		 * ##FormFieldHint <span class='pz-hint'>Bestellungen_status_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Bestellungen_status_id; 

		/**
		 * @var string
		 * @Column(name="Bestellungen_status_name", type="string", length=25, nullable=false) 
		 * 
		 * ##FormLabel  Bestellungen Status Name 
		 * ##FormFieldHint <span class='pz-hint'>Bestellungen_status_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Bestellungen_status_name; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getBestellungenStatusId() {
			return $this->Bestellungen_status_id;
		}

		public function getBestellungenStatusName() {
			return $this->Bestellungen_status_name;
		}


		public function setBestellungenStatusId($Bestellungen_status_id) {
			$this->Bestellungen_status_id = $Bestellungen_status_id;
			return $this;
		}

		public function setBestellungenStatusName($Bestellungen_status_name) {
			$this->Bestellungen_status_name = $Bestellungen_status_name;
			return $this;
		}




	} 
