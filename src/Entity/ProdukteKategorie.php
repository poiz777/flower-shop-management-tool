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
	 * ProdukteKategorie
	 * @Table(name="produkte_kategorie")
	 * @Entity(repositoryClass="App\Entity\Repo\ProdukteKategorieRepo")
	 **/
	class ProdukteKategorie {
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
		 * @Id ProdukteKategorie
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel Produktekategorieid 
		 * ##FormFieldHint <span class='pz-hint'>produktekategorieid</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $produktekategorieid; 

		/**
		 * @var string
		 * @Column(name="kat_name", type="string", length=30, nullable=false) 
		 * 
		 * ##FormLabel Kat Name 
		 * ##FormFieldHint <span class='pz-hint'>kat_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $kat_name; 

		/**
		 * @var string
		 * @Column(name="kat_name_it", type="string", length=20, nullable=false) 
		 * 
		 * ##FormLabel Kat Name It 
		 * ##FormFieldHint <span class='pz-hint'>kat_name_it</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $kat_name_it; 

		/**
		 * @var int
		 * @Column(name="produktekategorie_BH_Konto", type="smallint", length=4, nullable=false) 
		 * 
		 * ##FormLabel Produktekategorie B H Konto 
		 * ##FormFieldHint <span class='pz-hint'>produktekategorie_BH_Konto</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $produktekategorie_BH_Konto;
		
		
		/**
		 * @var \App\Entity\ProdukteKategorie
		 */
		protected static $instance;

		public function __construct(){
			$this->initializeEntityBank();
			static::$instance = $this;
		}


		public function getProduktekategorieid() {
			return $this->produktekategorieid;
		}

		public function getKatName() {
			return $this->kat_name;
		}

		public function getKatNameIt() {
			return $this->kat_name_it;
		}

		public function getProduktekategorieBHKonto() {
			return $this->produktekategorie_BH_Konto;
		}


		public function setProduktekategorieid($produktekategorieid) {
			$this->produktekategorieid = $produktekategorieid;
			return $this;
		}

		public function setKatName($kat_name) {
			$this->kat_name = $kat_name;
			return $this;
		}

		public function setKatNameIt($kat_name_it) {
			$this->kat_name_it = $kat_name_it;
			return $this;
		}

		public function setProduktekategorieBHKonto($produktekategorie_BH_Konto) {
			$this->produktekategorie_BH_Konto = $produktekategorie_BH_Konto;
			return $this;
		}




	} 
