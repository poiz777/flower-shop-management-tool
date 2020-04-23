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
	 * VersandDatecode
	 * @Table(name="versand_datecode")
	 * @Entity(repositoryClass="App\Entity\Repo\VersandDatecodeRepo")
	 **/
	class VersandDatecode { 

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
		 * @Id VersandDatecode
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel Versand Datecode Id 
		 * ##FormFieldHint <span class='pz-hint'>versand_datecode_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $versand_datecode_id; 

		/**
		 * @var int
		 * @Column(name="versand_datecode_wochentag", type="smallint", length=2, nullable=false) 
		 * 
		 * ##FormLabel Versand Datecode Wochentag 
		 * ##FormFieldHint <span class='pz-hint'>versand_datecode_wochentag</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $versand_datecode_wochentag; 

		/**
		 * @var int
		 * @Column(name="versand_datecode_zeit_min", type="time", nullable=false, options={"default":"00:00:00"}) 
		 * 
		 * ##FormLabel Versand Datecode Zeit Min 
		 * ##FormFieldHint <span class='pz-hint'>versand_datecode_zeit_min</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy DATETIME 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Time
		 */
		protected $versand_datecode_zeit_min; 

		/**
		 * @var int
		 * @Column(name="versand_datecode_zeit_max", type="time", nullable=false, options={"default":"00:00:00"}) 
		 * 
		 * ##FormLabel Versand Datecode Zeit Max 
		 * ##FormFieldHint <span class='pz-hint'>versand_datecode_zeit_max</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy DATETIME 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Time
		 */
		protected $versand_datecode_zeit_max; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getVersandDatecodeId() {
			return $this->versand_datecode_id;
		}

		public function getVersandDatecodeWochentag() {
			return $this->versand_datecode_wochentag;
		}

		public function getVersandDatecodeZeitMin() {
			return $this->versand_datecode_zeit_min;
		}

		public function getVersandDatecodeZeitMax() {
			return $this->versand_datecode_zeit_max;
		}


		public function setVersandDatecodeId($versand_datecode_id) {
			$this->versand_datecode_id = $versand_datecode_id;
			return $this;
		}

		public function setVersandDatecodeWochentag($versand_datecode_wochentag) {
			$this->versand_datecode_wochentag = $versand_datecode_wochentag;
			return $this;
		}

		public function setVersandDatecodeZeitMin($versand_datecode_zeit_min) {
			$this->versand_datecode_zeit_min = $versand_datecode_zeit_min;
			return $this;
		}

		public function setVersandDatecodeZeitMax($versand_datecode_zeit_max) {
			$this->versand_datecode_zeit_max = $versand_datecode_zeit_max;
			return $this;
		}




	} 
