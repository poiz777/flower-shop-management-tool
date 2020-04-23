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
	 * PersonenKategorie
	 * @Table(name="personen_kategorie")
	 * @Entity(repositoryClass="App\Entity\Repo\PersonenKategorieRepo")
	 **/
	class PersonenKategorie { 

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
		 * @Id PersonenKategorie
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel Personen Kategorie Id 
		 * ##FormFieldHint <span class='pz-hint'>personen_kategorie_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $personen_kategorie_id; 

		/**
		 * @var string
		 * @Column(name="personen_kategorie_name", type="string", length=30, nullable=false) 
		 * 
		 * ##FormLabel Personen Kategorie Name 
		 * ##FormFieldHint <span class='pz-hint'>personen_kategorie_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $personen_kategorie_name; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getPersonenKategorieId() {
			return $this->personen_kategorie_id;
		}

		public function getPersonenKategorieName() {
			return $this->personen_kategorie_name;
		}


		public function setPersonenKategorieId($personen_kategorie_id) {
			$this->personen_kategorie_id = $personen_kategorie_id;
			return $this;
		}

		public function setPersonenKategorieName($personen_kategorie_name) {
			$this->personen_kategorie_name = $personen_kategorie_name;
			return $this;
		}




	} 
