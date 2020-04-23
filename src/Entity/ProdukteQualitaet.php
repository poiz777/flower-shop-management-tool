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
	 * ProdukteQualitaet
	 * @Table(name="produkte_qualitaet")
	 * @Entity(repositoryClass="App\Entity\Repo\ProdukteQualitaetRepo")
	 **/
	class ProdukteQualitaet { 

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
		 * @Id ProdukteQualitaet
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel Produktequalitaetid 
		 * ##FormFieldHint <span class='pz-hint'>produktequalitaetid</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $produktequalitaetid; 

		/**
		 * @var string
		 * @Column(name="qualitaet", type="string", length=20, nullable=false) 
		 * 
		 * ##FormLabel Qualitaet 
		 * ##FormFieldHint <span class='pz-hint'>qualitaet</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $qualitaet; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getProduktequalitaetid() {
			return $this->produktequalitaetid;
		}

		public function getQualitaet() {
			return $this->qualitaet;
		}


		public function setProduktequalitaetid($produktequalitaetid) {
			$this->produktequalitaetid = $produktequalitaetid;
			return $this;
		}

		public function setQualitaet($qualitaet) {
			$this->qualitaet = $qualitaet;
			return $this;
		}




	} 
