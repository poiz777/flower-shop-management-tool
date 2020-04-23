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
	 * ProdukteProduzent
	 * @Table(name="produkte_produzent")
	 * @Entity(repositoryClass="App\Entity\Repo\ProdukteProduzentRepo")
	 **/
	class ProdukteProduzent { 

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
		 * @Id ProdukteProduzent
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel Produkte Produzent Id 
		 * ##FormFieldHint <span class='pz-hint'>produkte_produzent_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $produkte_produzent_id; 

		/**
		 * @var int
		 * @Column(name="produkte_produzent_produkt", type="smallint", length=5, nullable=false) 
		 * 
		 * ##FormLabel Produkte Produzent Produkt 
		 * ##FormFieldHint <span class='pz-hint'>produkte_produzent_produkt</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $produkte_produzent_produkt; 

		/**
		 * @var int
		 * @Column(name="produkte_produzent_produzent", type="smallint", length=5, nullable=false) 
		 * 
		 * ##FormLabel Produkte Produzent Produzent 
		 * ##FormFieldHint <span class='pz-hint'>produkte_produzent_produzent</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $produkte_produzent_produzent; 

		/**
		 * @var string
		 * @Column(name="produkte_produzent_bemerkungen", type="string", length=50000, nullable=false) 
		 * 
		 * ##FormLabel Produkte Produzent Bemerkungen 
		 * ##FormFieldHint <span class='pz-hint'>produkte_produzent_bemerkungen</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $produkte_produzent_bemerkungen; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getProdukteProduzentId() {
			return $this->produkte_produzent_id;
		}

		public function getProdukteProduzentProdukt() {
			return $this->produkte_produzent_produkt;
		}

		public function getProdukteProduzentProduzent() {
			return $this->produkte_produzent_produzent;
		}

		public function getProdukteProduzentBemerkungen() {
			return $this->produkte_produzent_bemerkungen;
		}


		public function setProdukteProduzentId($produkte_produzent_id) {
			$this->produkte_produzent_id = $produkte_produzent_id;
			return $this;
		}

		public function setProdukteProduzentProdukt($produkte_produzent_produkt) {
			$this->produkte_produzent_produkt = $produkte_produzent_produkt;
			return $this;
		}

		public function setProdukteProduzentProduzent($produkte_produzent_produzent) {
			$this->produkte_produzent_produzent = $produkte_produzent_produzent;
			return $this;
		}

		public function setProdukteProduzentBemerkungen($produkte_produzent_bemerkungen) {
			$this->produkte_produzent_bemerkungen = $produkte_produzent_bemerkungen;
			return $this;
		}




	} 
