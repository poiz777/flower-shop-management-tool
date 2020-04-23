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
	 * ProdukteFarben
	 * @Table(name="produkte_farben")
	 * @Entity(repositoryClass="App\Entity\Repo\ProdukteFarbenRepo")
	 **/
	class ProdukteFarben { 

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
		 * @Id ProdukteFarben
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel Produktefarbenid 
		 * ##FormFieldHint <span class='pz-hint'>produktefarbenid</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $produktefarbenid; 

		/**
		 * @var string
		 * @Column(name="farbe", type="string", length=20, nullable=false) 
		 * 
		 * ##FormLabel Farbe 
		 * ##FormFieldHint <span class='pz-hint'>farbe</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $farbe; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getProduktefarbenid() {
			return $this->produktefarbenid;
		}

		public function getFarbe() {
			return $this->farbe;
		}


		public function setProduktefarbenid($produktefarbenid) {
			$this->produktefarbenid = $produktefarbenid;
			return $this;
		}

		public function setFarbe($farbe) {
			$this->farbe = $farbe;
			return $this;
		}




	} 
