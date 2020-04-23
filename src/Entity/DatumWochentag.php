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
	 * DatumWochentag
	 * @Table(name="datum_wochentag")
	 * @Entity(repositoryClass="App\Entity\Repo\DatumWochentagRepo")
	 **/
	class DatumWochentag { 

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
		 * @Id DatumWochentag
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel Datum Wochentag Id 
		 * ##FormFieldHint <span class='pz-hint'>datum_wochentag_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $datum_wochentag_id; 

		/**
		 * @var string
		 * @Column(name="datum_wochentag_name", type="string", length=15, nullable=false) 
		 * 
		 * ##FormLabel Datum Wochentag Name 
		 * ##FormFieldHint <span class='pz-hint'>datum_wochentag_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $datum_wochentag_name; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getDatumWochentagId() {
			return $this->datum_wochentag_id;
		}

		public function getDatumWochentagName() {
			return $this->datum_wochentag_name;
		}


		public function setDatumWochentagId($datum_wochentag_id) {
			$this->datum_wochentag_id = $datum_wochentag_id;
			return $this;
		}

		public function setDatumWochentagName($datum_wochentag_name) {
			$this->datum_wochentag_name = $datum_wochentag_name;
			return $this;
		}




	} 
