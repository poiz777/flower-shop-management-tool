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
	 * Kreditoren
	 * @Table(name="Kreditoren")
	 * @Entity(repositoryClass="App\Entity\Repo\KreditorenRepo")
	 **/
	class Kreditoren { 

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
		 * @Id Kreditoren
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Kreditoren Id 
		 * ##FormFieldHint <span class='pz-hint'>Kreditoren_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Kreditoren_id; 

		/**
		 * @var int
		 * @Column(name="Kreditoren_status", type="smallint", length=3, nullable=false) 
		 * 
		 * ##FormLabel  Kreditoren Status 
		 * ##FormFieldHint <span class='pz-hint'>Kreditoren_status</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Kreditoren_status; 

		/**
		 * @var string
		 * @Column(name="Kreditoren_Datum_bill", type="date", nullable=true)
		 * 
		 * ##FormLabel  Kreditoren Datum Bill 
		 * ##FormFieldHint <span class='pz-hint'>Kreditoren_Datum_bill</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy DATETIME 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $Kreditoren_Datum_bill; 

		/**
		 * @var string
		 * @Column(name="Kreditoren_Datum_bez", type="date", nullable=true)
		 * 
		 * ##FormLabel  Kreditoren Datum Bez 
		 * ##FormFieldHint <span class='pz-hint'>Kreditoren_Datum_bez</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy DATETIME 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $Kreditoren_Datum_bez; 

		/**
		 * @var int
		 * @Column(name="Kreditoren_kunde", type="integer", length=6, nullable=false) 
		 * 
		 * ##FormLabel  Kreditoren Kunde 
		 * ##FormFieldHint <span class='pz-hint'>Kreditoren_kunde</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Kreditoren_kunde; 

		/**
		 * @var double
		 * @Column(name="Kreditoren_betrag_bill", type="text", length=10, nullable=false) 
		 * 
		 * ##FormLabel  Kreditoren Betrag Bill 
		 * ##FormFieldHint <span class='pz-hint'>Kreditoren_betrag_bill</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Kreditoren_betrag_bill; 

		/**
		 * @var double
		 * @Column(name="Kreditoren_betrag_bez", type="text", length=10, nullable=false) 
		 * 
		 * ##FormLabel  Kreditoren Betrag Bez 
		 * ##FormFieldHint <span class='pz-hint'>Kreditoren_betrag_bez</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Kreditoren_betrag_bez; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getKreditorenId() {
			return $this->Kreditoren_id;
		}

		public function getKreditorenStatus() {
			return $this->Kreditoren_status;
		}

		public function getKreditorenDatumBill() {
			return $this->Kreditoren_Datum_bill;
		}

		public function getKreditorenDatumBez() {
			return $this->Kreditoren_Datum_bez;
		}

		public function getKreditorenKunde() {
			return $this->Kreditoren_kunde;
		}

		public function getKreditorenBetragBill() {
			return $this->Kreditoren_betrag_bill;
		}

		public function getKreditorenBetragBez() {
			return $this->Kreditoren_betrag_bez;
		}


		public function setKreditorenId($Kreditoren_id) {
			$this->Kreditoren_id = $Kreditoren_id;
			return $this;
		}

		public function setKreditorenStatus($Kreditoren_status) {
			$this->Kreditoren_status = $Kreditoren_status;
			return $this;
		}

		public function setKreditorenDatumBill($Kreditoren_Datum_bill) {
			$this->Kreditoren_Datum_bill = $Kreditoren_Datum_bill;
			return $this;
		}

		public function setKreditorenDatumBez($Kreditoren_Datum_bez) {
			$this->Kreditoren_Datum_bez = $Kreditoren_Datum_bez;
			return $this;
		}

		public function setKreditorenKunde($Kreditoren_kunde) {
			$this->Kreditoren_kunde = $Kreditoren_kunde;
			return $this;
		}

		public function setKreditorenBetragBill($Kreditoren_betrag_bill) {
			$this->Kreditoren_betrag_bill = $Kreditoren_betrag_bill;
			return $this;
		}

		public function setKreditorenBetragBez($Kreditoren_betrag_bez) {
			$this->Kreditoren_betrag_bez = $Kreditoren_betrag_bez;
			return $this;
		}

	} 
