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
	 * Arbeitszeit
	 * @Table(name="Arbeitszeit")
	 * @Entity(repositoryClass="App\Entity\Repo\ArbeitszeitRepo")
	 **/
	class Arbeitszeit {
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
		 * @Id Arbeitszeit
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * --FormLabel  Arbeitszeit Id
		 * --FormFieldHint <span class='pz-hint'>Arbeitszeit_id</span>
		 * --FormInputType number
		 * --FormInputRequired 0
		 * --FormPlaceholder 0
		 * --FormInputOptions NULL
		 * --FormValidationStrategy NUM
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Arbeitszeit_id;
		
		/**
		 * @var int
		 * @Column(name="Arbeitszeit_ma", type="smallint", length=4, nullable=false)
		 *
		 * ##FormLabel Mitarbeiter
		 * ##FormFieldHint <span class='pz-hint'>Der aktuelle Mitarbeiter...</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormPlaceholder Mitarbeiter wählen
		 * ##FormInputOptions App\Entity\Arbeitszeit::fetchCoWorkers
		 * ##FormValidationStrategy NUM
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $Arbeitszeit_ma;
		
		/**
		 * @var \DateTime
		 * @Column(name="Arbeitszeit_date", type="datetime", nullable=false)
		 * 
		 * ##FormLabel Datum
		 * ##FormFieldHint <span class='pz-hint'>Arbeitszeiteintrag Datum</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputReadOnly 1
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy DATETIME
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $Arbeitszeit_date;

		/**
		 * @var double
		 * @Column(name="Arbeitszeit_std_mg", type="text", length=10, nullable=true) 
		 * 
		 * ##FormLabel Stunden Münstergasse
		 * ##FormFieldHint <span class='pz-hint'>Stunden Münstergasse</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL
		 * ##FormInputStep 0.25
		 * ##FormInputMin 0
		 * ##FormInputMax 24
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Arbeitszeit_std_mg=0;

		/**
		 * @var double
		 * @Column(name="Arbeitszeit_std_hg", type="text", length=10, nullable=true) 
		 * 
		 * ##FormLabel Stunden Hirschengraben
		 * ##FormFieldHint <span class='pz-hint'>Stunden Hirschengraben</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormInputStep 0.25
		 * ##FormInputMin 0
		 * ##FormInputMax 24
		 * ##FormValidationStrategy NUM
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Arbeitszeit_std_hg=0;

		/**
		 * @var double
		 * @Column(name="Arbeitszeit_std_extern", type="text", length=10, nullable=true) 
		 * 
		 * ##FormLabel Stunden Extern
		 * ##FormFieldHint <span class='pz-hint'>Stunden Extern</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL
		 * ##FormInputStep 0.25
		 * ##FormInputMin 0
		 * ##FormInputMax 24
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Arbeitszeit_std_extern=0;

		/**
		 * @var double
		 * @Column(name="Arbeitszeit_std_total", type="text", length=10, nullable=true) 
		 * 
		 * --FormLabel  Arbeitszeit Std Total
		 * --FormFieldHint <span class='pz-hint'>Arbeitszeit_std_total</span>
		 * --FormInputType number
		 * --FormInputRequired 0
		 * --FormPlaceholder 0
		 * --FormInputOptions NULL
		 * --FormValidationStrategy NUM
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Arbeitszeit_std_total=0;

		/**
		 * @var string
		 * @Column(name="Arbeitszeit_kommentar", type="text", nullable=false) 
		 * 
		 * ##FormLabel  Arbeitszeit Kommentar 
		 * ##FormFieldHint <span class='pz-hint'>Relevanter Kommentare...</span>
		 * ##FormInputType textarea
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder Kommentar...
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy HTML 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\TextArea
		 */
		protected $Arbeitszeit_kommentar;
		
		
		protected static $instance;

		public function __construct(){
			$this->initializeEntityBank();
			$this->Arbeitszeit_date = new \DateTime();
		}


		public function getArbeitszeitId() {
			return $this->Arbeitszeit_id;
		}

		public function getArbeitszeitDate() {
			return $this->Arbeitszeit_date;
		}

		public function getArbeitszeitMa() {
			return $this->Arbeitszeit_ma;
		}

		public function getArbeitszeitStdMg() {
			return $this->Arbeitszeit_std_mg;
		}

		public function getArbeitszeitStdHg() {
			return $this->Arbeitszeit_std_hg;
		}

		public function getArbeitszeitStdExtern() {
			return $this->Arbeitszeit_std_extern;
		}

		public function getArbeitszeitStdTotal() {
			return $this->Arbeitszeit_std_total;
		}

		public function getArbeitszeitKommentar() {
			return $this->Arbeitszeit_kommentar;
		}


		public function setArbeitszeitId($Arbeitszeit_id) {
			$this->Arbeitszeit_id = $Arbeitszeit_id;
			return $this;
		}

		public function setArbeitszeitDate($Arbeitszeit_date) {
			$this->Arbeitszeit_date = $Arbeitszeit_date;
			return $this;
		}

		public function setArbeitszeitMa($Arbeitszeit_ma) {
			$this->Arbeitszeit_ma = $Arbeitszeit_ma;
			return $this;
		}

		public function setArbeitszeitStdMg($Arbeitszeit_std_mg) {
			$this->Arbeitszeit_std_mg = $Arbeitszeit_std_mg;
			return $this;
		}

		public function setArbeitszeitStdHg($Arbeitszeit_std_hg) {
			$this->Arbeitszeit_std_hg = $Arbeitszeit_std_hg;
			return $this;
		}

		public function setArbeitszeitStdExtern($Arbeitszeit_std_extern) {
			$this->Arbeitszeit_std_extern = $Arbeitszeit_std_extern;
			return $this;
		}

		public function setArbeitszeitStdTotal($Arbeitszeit_std_total) {
			$this->Arbeitszeit_std_total = $Arbeitszeit_std_total;
			return $this;
		}

		public function setArbeitszeitKommentar($Arbeitszeit_kommentar) {
			$this->Arbeitszeit_kommentar = $Arbeitszeit_kommentar;
			return $this;
		}

		public function getCoWorkerByID($id) {
			/** @var \Doctrine\ORM\EntityManager $entityManager */
			/** @var \App\Entity\Personen $coWorker */
			global $kernel;
			$entityManager  = $kernel->getContainer()->get('doctrine.orm.entity_manager');
			$strCoWorker    = [];
			$coWorker       = $entityManager->getRepository(Personen::class)-> find($id);
			if($coWorker){
				$strCoWorker = $coWorker->getVorname() . " " . $coWorker->getName();
			}
			return $strCoWorker;
		}


	} 
