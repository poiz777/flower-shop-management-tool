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
	 * KnowledgeEintrag
	 * @Table(name="knowledge_eintrag")
	 * @Entity(repositoryClass="App\Entity\Repo\KnowledgeEintragRepo")
	 **/
	class KnowledgeEintrag {
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
		 * @Id KnowledgeEintrag
		 * @Column(type="integer", name="knowledge_eintragID")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * --FormLabel Knowledge Eintrag ID
		 * --FormFieldHint <span class='pz-hint'>knowledge_eintragID</span>
		 * --FormInputType number
		 * --FormInputRequired 0 
		 * --FormPlaceholder 0 
		 * --FormInputOptions NULL 
		 * --FormValidationStrategy NUM 
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $knowledge_eintragID;
		
		/**
		 * @var int
		 * @Column(name="knowledge_eintrag_katID", type="smallint", length=6, nullable=false) 
		 * 
		 * ##FormLabel Kategorie
		 * ##FormFieldHint <span class='pz-hint'>KnowledgeEintrag Kategorie</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0
		 * ##FormPlaceholder Kategorie wählen
		 * ##FormValidationStrategy NUM
		 * ##FormInputOptions App\Entity\KnowledgeEintrag::fetchKnowledgeCategoriesAsOptions
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $knowledge_eintrag_katID;
		
		/**
		 * @var string
		 * @Column(name="knowledge_eintragfrage", type="string", length=100, nullable=false)
		 *
		 * ##FormLabel Wissen Eintragfrage
		 * ##FormFieldHint <span class='pz-hint'>Knowledge Eintragfrage</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0
		 * ##FormPlaceholder Abotour...
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $knowledge_eintragfrage;

		/**
		 * @var \Datetime
		 * @Column(name="knowledge_eintragdatum", type="datetime", nullable=false)
		 * 
		 * ##FormLabel Knowledge Eintragdatum 
		 * ##FormFieldHint <span class='pz-hint'>knowledge_eintragdatum</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 01.01.2222
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy DATETIME 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $knowledge_eintragdatum;
		
		/**
		 * @var int
		 * @Column(name="knowledge_berechtigung", type="smallint", length=6, nullable=false)
		 *
		 * --FormLabel Knowledge Berechtigung
		 * --FormFieldHint <span class='pz-hint'>knowledge_berechtigung</span>
		 * --FormInputType number
		 * --FormInputRequired 0
		 * --FormPlaceholder 0
		 * --FormValidationStrategy NUM
		 * --FormInputOptions App\Entity\KnowledgeEintrag::fetchKnowledgeRightsAsOptions
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $knowledge_berechtigung=0;
		
		
		/**
		 * @var string
		 * @Column(name="knowledge_eintragantwort", type="text", nullable=false) 
		 * 
		 * ##FormLabel Knowledge Eintragantwort 
		 * ##FormFieldHint <span class='pz-hint'>knowledge_eintragantwort</span>
		 * ##FormInputType textarea
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder ...
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy HTML 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\EditorEnhanced
		 */
		protected $knowledge_eintragantwort;
		
		
		/**
		 * @var \App\Entity\KnowledgeEintrag
		 */
		protected static $instance;

		public function __construct(){
			$this->knowledge_eintragdatum = new \DateTime();
			$this->initializeEntityBank();
			static::$instance = $this;
		}


		public function getKnowledgeEintragID() {
			return $this->knowledge_eintragID;
		}

		public function getKnowledgeBerechtigung() {
			return $this->knowledge_berechtigung;
		}

		public function getKnowledgeEintragKatID() {
			return $this->knowledge_eintrag_katID;
		}

		public function getKnowledgeEintragdatum() {
			return $this->knowledge_eintragdatum;
		}

		public function getKnowledgeEintragfrage() {
			return $this->knowledge_eintragfrage;
		}

		public function getKnowledgeEintragantwort() {
			return $this->knowledge_eintragantwort;
		}


		public function setKnowledgeEintragID($knowledge_eintragID) {
			$this->knowledge_eintragID = $knowledge_eintragID;
			return $this;
		}

		public function setKnowledgeBerechtigung($knowledge_berechtigung) {
			$this->knowledge_berechtigung = $knowledge_berechtigung;
			return $this;
		}

		public function setKnowledgeEintragKatID($knowledge_eintrag_katID) {
			$this->knowledge_eintrag_katID = $knowledge_eintrag_katID;
			return $this;
		}

		public function setKnowledgeEintragdatum($knowledge_eintragdatum) {
			$this->knowledge_eintragdatum = $knowledge_eintragdatum;
			return $this;
		}

		public function setKnowledgeEintragfrage($knowledge_eintragfrage) {
			$this->knowledge_eintragfrage = $knowledge_eintragfrage;
			return $this;
		}

		public function setKnowledgeEintragantwort($knowledge_eintragantwort) {
			$this->knowledge_eintragantwort = $knowledge_eintragantwort;
			return $this;
		}




	} 
