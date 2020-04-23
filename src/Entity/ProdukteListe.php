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
	 * ProdukteListe
	 * @Table(name="produkte_liste")
	 * @Entity(repositoryClass="App\Entity\Repo\ProdukteListeRepo")
	 **/
	class ProdukteListe { 

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
		 * @Id ProdukteListe
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel Produktelisteid 
		 * ##FormFieldHint <span class='pz-hint'>produktelisteid</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $produktelisteid; 

		/**
		 * @var int
		 * @Column(name="produktelisteprodukt", type="smallint", length=4, nullable=false) 
		 * 
		 * ##FormLabel Produktelisteprodukt 
		 * ##FormFieldHint <span class='pz-hint'>produktelisteprodukt</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $produktelisteprodukt; 

		/**
		 * @var float
		 * @Column(name="preis", type="text", length=4, nullable=false, options={"default":"0.00"}) 
		 * 
		 * ##FormLabel Preis 
		 * ##FormFieldHint <span class='pz-hint'>preis</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $preis; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getProduktelisteid() {
			return $this->produktelisteid;
		}

		public function getProduktelisteprodukt() {
			return $this->produktelisteprodukt;
		}

		public function getPreis() {
			return $this->preis;
		}


		public function setProduktelisteid($produktelisteid) {
			$this->produktelisteid = $produktelisteid;
			return $this;
		}

		public function setProduktelisteprodukt($produktelisteprodukt) {
			$this->produktelisteprodukt = $produktelisteprodukt;
			return $this;
		}

		public function setPreis($preis) {
			$this->preis = $preis;
			return $this;
		}




	} 
