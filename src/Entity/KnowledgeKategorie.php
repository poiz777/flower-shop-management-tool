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
	 * KnowledgeKategorie
	 * @Table(name="knowledge_kategorie")
	 * @Entity(repositoryClass="App\Entity\Repo\KnowledgeKategorieRepo")
	 **/
	class KnowledgeKategorie {
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
		 * @Id KnowledgeKategorie
		 * @Column(type="integer", name="knowledge_kategorieID")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel Knowledge Kategorie ID
		 * ##FormFieldHint <span class='pz-hint'>knowledge_kategorieID</span>
		 * ##FormInputType number
		 * ##FormUseLabel 0
		 * ##FormAddLabel 0
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NONE
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Hidden
		 */
		protected $knowledge_kategorieID; 

		/**
		 * @var string
		 * @Column(name="knowledge_kategoriename", type="string", length=30, nullable=false) 
		 * 
		 * ##FormLabel Knowledge Kategoriename 
		 * ##FormFieldHint <span class='pz-hint'>knowledge_kategoriename</span>
		 * ##FormInputType text
		 * ##FormInputRequired 1
		 * ##FormPlaceholder Kategoriename
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $knowledge_kategoriename;
		
		
		/**
		 * @var \App\Entity\KnowledgeKategorie
		 */
		protected static $instance;
		

		public function __construct(){
			$this->initializeEntityBank();
			static::$instance = $this;
		}


		public function getKnowledgeKategorieID() {
			return $this->knowledge_kategorieID;
		}

		public function getKnowledgeKategoriename() {
			return $this->knowledge_kategoriename;
		}


		public function setKnowledgeKategorieID($knowledge_kategorieID) {
			$this->knowledge_kategorieID = $knowledge_kategorieID;
			return $this;
		}

		public function setKnowledgeKategoriename($knowledge_kategoriename) {
			$this->knowledge_kategoriename = $knowledge_kategoriename;
			return $this;
		}




	} 
