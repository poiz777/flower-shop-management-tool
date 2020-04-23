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
	 * Bestellungen
	 * @Table(name="Bestellungen")
	 * @Entity(repositoryClass="App\Entity\Repo\BestellungenRepo")
	 **/
	class Bestellungen { 

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
		 * @Id Bestellungen
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Bestellung Id 
		 * ##FormFieldHint <span class='pz-hint'>Bestellung_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Bestellung_id; 

		/**
		 * @var string
		 * @Column(name="Bestellung_titel", type="string", length=40, nullable=false) 
		 * 
		 * ##FormLabel  Bestellung Titel 
		 * ##FormFieldHint <span class='pz-hint'>Bestellung_titel</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Bestellung_titel; 

		/**
		 * @var int
		 * @Column(name="Bestellung_status", type="smallint", length=3, nullable=false) 
		 * 
		 * ##FormLabel  Bestellung Status 
		 * ##FormFieldHint <span class='pz-hint'>Bestellung_status</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Bestellung_status; 

		/**
		 * @var \Date
		 * @Column(name="Bestellung_datum_send", type="date", nullable=false, options={"default":"0000-00-00"}) 
		 * 
		 * ##FormLabel  Bestellung Datum Send 
		 * ##FormFieldHint <span class='pz-hint'>Bestellung_datum_send</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy DATETIME 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $Bestellung_datum_send; 

		/**
		 * @var \Date
		 * @Column(name="Bestellung_datum_get", type="date", nullable=false, options={"default":"0000-00-00"}) 
		 * 
		 * ##FormLabel  Bestellung Datum Get 
		 * ##FormFieldHint <span class='pz-hint'>Bestellung_datum_get</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy DATETIME 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $Bestellung_datum_get; 

		/**
		 * @var int
		 * @Column(name="Bestellung_lieferant_id", type="integer", length=6, nullable=false) 
		 * 
		 * ##FormLabel  Bestellung Lieferant Id 
		 * ##FormFieldHint <span class='pz-hint'>Bestellung_lieferant_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Bestellung_lieferant_id; 

		/**
		 * @var string
		 * @Column(name="Bestellung_bemerkungen", type="string", length=300, nullable=false) 
		 * 
		 * ##FormLabel  Bestellung Bemerkungen 
		 * ##FormFieldHint <span class='pz-hint'>Bestellung_bemerkungen</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Bestellung_bemerkungen; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getBestellungId() {
			return $this->Bestellung_id;
		}

		public function getBestellungTitel() {
			return $this->Bestellung_titel;
		}

		public function getBestellungStatus() {
			return $this->Bestellung_status;
		}

		public function getBestellungDatumSend() {
			return $this->Bestellung_datum_send;
		}

		public function getBestellungDatumGet() {
			return $this->Bestellung_datum_get;
		}

		public function getBestellungLieferantId() {
			return $this->Bestellung_lieferant_id;
		}

		public function getBestellungBemerkungen() {
			return $this->Bestellung_bemerkungen;
		}


		public function setBestellungId($Bestellung_id) {
			$this->Bestellung_id = $Bestellung_id;
			return $this;
		}

		public function setBestellungTitel($Bestellung_titel) {
			$this->Bestellung_titel = $Bestellung_titel;
			return $this;
		}

		public function setBestellungStatus($Bestellung_status) {
			$this->Bestellung_status = $Bestellung_status;
			return $this;
		}

		public function setBestellungDatumSend($Bestellung_datum_send) {
			$this->Bestellung_datum_send = $Bestellung_datum_send;
			return $this;
		}

		public function setBestellungDatumGet($Bestellung_datum_get) {
			$this->Bestellung_datum_get = $Bestellung_datum_get;
			return $this;
		}

		public function setBestellungLieferantId($Bestellung_lieferant_id) {
			$this->Bestellung_lieferant_id = $Bestellung_lieferant_id;
			return $this;
		}

		public function setBestellungBemerkungen($Bestellung_bemerkungen) {
			$this->Bestellung_bemerkungen = $Bestellung_bemerkungen;
			return $this;
		}




	} 
