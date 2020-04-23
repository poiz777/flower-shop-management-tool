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
	 * BestellungenPosten
	 * @Table(name="Bestellungen_posten")
	 * @Entity(repositoryClass="App\Entity\Repo\BestellungenPostenRepo")
	 **/
	class BestellungenPosten { 

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
		 * @Id BestellungenPosten
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Bestellungen Posten Id 
		 * ##FormFieldHint <span class='pz-hint'>Bestellungen_posten_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Bestellungen_posten_id; 

		/**
		 * @var int
		 * @Column(name="Bestellungen_posten_Bestellungen_id", type="integer", length=6, nullable=false) 
		 * 
		 * ##FormLabel  Bestellungen Posten Bestellungen Id 
		 * ##FormFieldHint <span class='pz-hint'>Bestellungen_posten_Bestellungen_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Bestellungen_posten_Bestellungen_id; 

		/**
		 * @var int
		 * @Column(name="Bestellungen_posten_Ticket_id", type="integer", length=6, nullable=false) 
		 * 
		 * ##FormLabel  Bestellungen Posten Ticket Id 
		 * ##FormFieldHint <span class='pz-hint'>Bestellungen_posten_Ticket_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Bestellungen_posten_Ticket_id; 

		/**
		 * @var int
		 * @Column(name="Bestellungen_posten_Anzahl", type="integer", length=8, nullable=false) 
		 * 
		 * ##FormLabel  Bestellungen Posten Anzahl 
		 * ##FormFieldHint <span class='pz-hint'>Bestellungen_posten_Anzahl</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Bestellungen_posten_Anzahl; 

		/**
		 * @var int
		 * @Column(name="Bestellungen_posten_Anzahl_bestellt", type="integer", length=8, nullable=false) 
		 * 
		 * ##FormLabel  Bestellungen Posten Anzahl Bestellt 
		 * ##FormFieldHint <span class='pz-hint'>Bestellungen_posten_Anzahl_bestellt</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Bestellungen_posten_Anzahl_bestellt; 

		/**
		 * @var int
		 * @Column(name="Bestellungen_posten_Produkt_id", type="smallint", length=5, nullable=false) 
		 * 
		 * ##FormLabel  Bestellungen Posten Produkt Id 
		 * ##FormFieldHint <span class='pz-hint'>Bestellungen_posten_Produkt_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Bestellungen_posten_Produkt_id; 

		/**
		 * @var string
		 * @Column(name="Bestellungen_posten_Bemerkungen", type="text", nullable=false) 
		 * 
		 * ##FormLabel  Bestellungen Posten Bemerkungen 
		 * ##FormFieldHint <span class='pz-hint'>Bestellungen_posten_Bemerkungen</span>
		 * ##FormInputType textarea
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy HTML 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\EditorEnhanced
		 */
		protected $Bestellungen_posten_Bemerkungen; 

		/**
		 * @var string
		 * @Column(name="Bestellungen_posten_Bemerkungen_bestellt", type="text", nullable=false) 
		 * 
		 * ##FormLabel  Bestellungen Posten Bemerkungen Bestellt 
		 * ##FormFieldHint <span class='pz-hint'>Bestellungen_posten_Bemerkungen_bestellt</span>
		 * ##FormInputType textarea
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy HTML 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\EditorEnhanced
		 */
		protected $Bestellungen_posten_Bemerkungen_bestellt; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getBestellungenPostenId() {
			return $this->Bestellungen_posten_id;
		}

		public function getBestellungenPostenBestellungenId() {
			return $this->Bestellungen_posten_Bestellungen_id;
		}

		public function getBestellungenPostenTicketId() {
			return $this->Bestellungen_posten_Ticket_id;
		}

		public function getBestellungenPostenAnzahl() {
			return $this->Bestellungen_posten_Anzahl;
		}

		public function getBestellungenPostenAnzahlBestellt() {
			return $this->Bestellungen_posten_Anzahl_bestellt;
		}

		public function getBestellungenPostenProduktId() {
			return $this->Bestellungen_posten_Produkt_id;
		}

		public function getBestellungenPostenBemerkungen() {
			return $this->Bestellungen_posten_Bemerkungen;
		}

		public function getBestellungenPostenBemerkungenBestellt() {
			return $this->Bestellungen_posten_Bemerkungen_bestellt;
		}


		public function setBestellungenPostenId($Bestellungen_posten_id) {
			$this->Bestellungen_posten_id = $Bestellungen_posten_id;
			return $this;
		}

		public function setBestellungenPostenBestellungenId($Bestellungen_posten_Bestellungen_id) {
			$this->Bestellungen_posten_Bestellungen_id = $Bestellungen_posten_Bestellungen_id;
			return $this;
		}

		public function setBestellungenPostenTicketId($Bestellungen_posten_Ticket_id) {
			$this->Bestellungen_posten_Ticket_id = $Bestellungen_posten_Ticket_id;
			return $this;
		}

		public function setBestellungenPostenAnzahl($Bestellungen_posten_Anzahl) {
			$this->Bestellungen_posten_Anzahl = $Bestellungen_posten_Anzahl;
			return $this;
		}

		public function setBestellungenPostenAnzahlBestellt($Bestellungen_posten_Anzahl_bestellt) {
			$this->Bestellungen_posten_Anzahl_bestellt = $Bestellungen_posten_Anzahl_bestellt;
			return $this;
		}

		public function setBestellungenPostenProduktId($Bestellungen_posten_Produkt_id) {
			$this->Bestellungen_posten_Produkt_id = $Bestellungen_posten_Produkt_id;
			return $this;
		}

		public function setBestellungenPostenBemerkungen($Bestellungen_posten_Bemerkungen) {
			$this->Bestellungen_posten_Bemerkungen = $Bestellungen_posten_Bemerkungen;
			return $this;
		}

		public function setBestellungenPostenBemerkungenBestellt($Bestellungen_posten_Bemerkungen_bestellt) {
			$this->Bestellungen_posten_Bemerkungen_bestellt = $Bestellungen_posten_Bemerkungen_bestellt;
			return $this;
		}




	} 
