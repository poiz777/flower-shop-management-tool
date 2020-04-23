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
	 * DatumMonat
	 * @Table(name="datum_monat")
	 * @Entity(repositoryClass="App\Entity\Repo\DatumMonatRepo")
	 **/
	class DatumMonat { 

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
		 * @Id DatumMonat
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel Datum Monat Id 
		 * ##FormFieldHint <span class='pz-hint'>datum_monat_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $datum_monat_id; 

		/**
		 * @var string
		 * @Column(name="datum_monatsname", type="string", length=15, nullable=false) 
		 * 
		 * ##FormLabel Datum Monatsname 
		 * ##FormFieldHint <span class='pz-hint'>datum_monatsname</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $datum_monatsname; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getDatumMonatId() {
			return $this->datum_monat_id;
		}

		public function getDatumMonatsname() {
			return $this->datum_monatsname;
		}


		public function setDatumMonatId($datum_monat_id) {
			$this->datum_monat_id = $datum_monat_id;
			return $this;
		}

		public function setDatumMonatsname($datum_monatsname) {
			$this->datum_monatsname = $datum_monatsname;
			return $this;
		}




	} 
