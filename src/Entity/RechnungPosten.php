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
	 * RechnungPosten
	 * @Table(name="Rechnung_posten")
	 * @Entity(repositoryClass="App\Entity\Repo\RechnungPostenRepo")
	 **/
	class RechnungPosten {
		use EntityFieldMapperTrait;
		use FormObjectLexer;
		
		
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
		 * @Id RechnungPosten
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * --FormLabel  Rechnung Posten Id
		 * --FormFieldHint <span class='pz-hint'>Rechnung_posten_id</span>
		 * --FormInputType number
		 * --FormInputRequired 0
		 * --FormPlaceholder 0
		 * --FormInputOptions NULL
		 * --FormValidationStrategy NUM
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Rechnung_posten_id; 

		/**
		 * @var int
		 * @Column(name="Rechnung_posten_Rechnung_id", type="integer", length=6, nullable=false) 
		 * 
		 * ##FormLabel  Rechnung Posten Rechnung Id 
		 * ##FormFieldHint <span class='pz-hint'>Rechnung_posten_Rechnung_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Rechnung_posten_Rechnung_id; 

		/**
		 * @var int
		 * @Column(name="Rechnung_posten_BH_Journal_id", type="integer", length=6, nullable=false) 
		 * 
		 * ##FormLabel  Rechnung Posten B H Journal Id 
		 * ##FormFieldHint <span class='pz-hint'>Rechnung_posten_BH_Journal_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Rechnung_posten_BH_Journal_id;
		
		
		/**
		 * @var \App\Entity\RechnungPosten
		 */
		protected static $instance;

		public function __construct(){
			$this->initializeEntityBank();
			static::$instance = $this;
		}


		public function getRechnungPostenId() {
			return $this->Rechnung_posten_id;
		}

		public function getRechnungPostenRechnungId() {
			return $this->Rechnung_posten_Rechnung_id;
		}

		public function getRechnungPostenBHJournalId() {
			return $this->Rechnung_posten_BH_Journal_id;
		}


		public function setRechnungPostenId($Rechnung_posten_id) {
			$this->Rechnung_posten_id = $Rechnung_posten_id;
			return $this;
		}

		public function setRechnungPostenRechnungId($Rechnung_posten_Rechnung_id) {
			$this->Rechnung_posten_Rechnung_id = $Rechnung_posten_Rechnung_id;
			return $this;
		}

		public function setRechnungPostenBHJournalId($Rechnung_posten_BH_Journal_id) {
			$this->Rechnung_posten_BH_Journal_id = $Rechnung_posten_BH_Journal_id;
			return $this;
		}




	} 
