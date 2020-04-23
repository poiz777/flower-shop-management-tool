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
	 * VersandTermin
	 * @Table(name="versand_termin")
	 * @Entity(repositoryClass="App\Entity\Repo\VersandTerminRepo")
	 **/
	class VersandTermin { 

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
		 * @Id VersandTermin
		 * @Column(type="integer")
		 * 
		 * ##FormLabel Versand Termin Id 
		 * ##FormFieldHint <span class='pz-hint'>versand_termin_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $versand_termin_id; 

		/**
		 * @var int
		 * @Column(name="versand_termin_datum_aktuell_id", type="smallint", length=2, nullable=false) 
		 * 
		 * ##FormLabel Versand Termin Datum Aktuell Id 
		 * ##FormFieldHint <span class='pz-hint'>versand_termin_datum_aktuell_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $versand_termin_datum_aktuell_id; 

		/**
		 * @var int
		 * @Column(name="versand_termin_versand_art_id", type="smallint", length=2, nullable=false) 
		 * 
		 * ##FormLabel Versand Termin Versand Art Id 
		 * ##FormFieldHint <span class='pz-hint'>versand_termin_versand_art_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $versand_termin_versand_art_id; 

		/**
		 * @var int
		 * @Column(name="versand_termin_wochentag", type="smallint", length=2, nullable=false) 
		 * 
		 * ##FormLabel Versand Termin Wochentag 
		 * ##FormFieldHint <span class='pz-hint'>versand_termin_wochentag</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $versand_termin_wochentag; 

		/**
		 * @var int
		 * @Column(name="versand_termin_flag", type="smallint", length=2, nullable=false) 
		 * 
		 * ##FormLabel Versand Termin Flag 
		 * ##FormFieldHint <span class='pz-hint'>versand_termin_flag</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $versand_termin_flag; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getVersandTerminId() {
			return $this->versand_termin_id;
		}

		public function getVersandTerminDatumAktuellId() {
			return $this->versand_termin_datum_aktuell_id;
		}

		public function getVersandTerminVersandArtId() {
			return $this->versand_termin_versand_art_id;
		}

		public function getVersandTerminWochentag() {
			return $this->versand_termin_wochentag;
		}

		public function getVersandTerminFlag() {
			return $this->versand_termin_flag;
		}


		public function setVersandTerminId($versand_termin_id) {
			$this->versand_termin_id = $versand_termin_id;
			return $this;
		}

		public function setVersandTerminDatumAktuellId($versand_termin_datum_aktuell_id) {
			$this->versand_termin_datum_aktuell_id = $versand_termin_datum_aktuell_id;
			return $this;
		}

		public function setVersandTerminVersandArtId($versand_termin_versand_art_id) {
			$this->versand_termin_versand_art_id = $versand_termin_versand_art_id;
			return $this;
		}

		public function setVersandTerminWochentag($versand_termin_wochentag) {
			$this->versand_termin_wochentag = $versand_termin_wochentag;
			return $this;
		}

		public function setVersandTerminFlag($versand_termin_flag) {
			$this->versand_termin_flag = $versand_termin_flag;
			return $this;
		}




	} 
