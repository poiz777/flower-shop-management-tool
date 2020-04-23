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
	 * ProdukteQuanitaet
	 * @Table(name="produkte_quanitaet")
	 * @Entity(repositoryClass="App\Entity\Repo\ProdukteQuanitaetRepo")
	 **/
	class ProdukteQuanitaet { 

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
		 * @Id ProdukteQuanitaet
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel Produktequantitaetid 
		 * ##FormFieldHint <span class='pz-hint'>produktequantitaetid</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $produktequantitaetid; 

		/**
		 * @var string
		 * @Column(name="quantitaet", type="string", length=20, nullable=false) 
		 * 
		 * ##FormLabel Quantitaet 
		 * ##FormFieldHint <span class='pz-hint'>quantitaet</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $quantitaet; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getProduktequantitaetid() {
			return $this->produktequantitaetid;
		}

		public function getQuantitaet() {
			return $this->quantitaet;
		}


		public function setProduktequantitaetid($produktequantitaetid) {
			$this->produktequantitaetid = $produktequantitaetid;
			return $this;
		}

		public function setQuantitaet($quantitaet) {
			$this->quantitaet = $quantitaet;
			return $this;
		}




	} 
