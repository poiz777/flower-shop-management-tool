<?php 

	namespace App\Forms;

	use App\Entity\KnowledgeEintrag;
	use App\Entity\KnowledgeKategorie;
	use App\Entity\Personen;
	use App\Entity\TicketPrio;
	use App\Entity\TicketStatus;
	use App\Entity\TicketTyp;
	use App\Helpers\Date\RequestBridge;
	use Doctrine\ORM\Mapping\Column;
	use Doctrine\ORM\EntityManagerInterface;
	use App\Helpers\Traits\EntityFieldMapperTrait;
	use App\Helpers\Traits\FormObjectLexer;

	/**
	 * CoWorkerEntryEntity
	 **/
	class CoWorkerEntryEntity {
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
		 * --FormLabel Kunden ID
		 * --FormFieldHint <span class='pz-hint'>Client ID</span>
		 * --FormInputType number
		 * --FormInputRequired 0
		 * --FormPlaceholder 0
		 * --FormInputOptions NULL
		 * --FormValidationStrategy NUM
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $kundenid;

		/**
		 * @var string
		 *
		 * ##FormLabel Vorname
		 * ##FormFieldHint <span class='pz-hint'>Mitarbeiter Vorname</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0
		 * ##FormPlaceholder Vorname des Mitarbeiters
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy NON_EMPTY
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $vorname;

		/**
		 * @var string
		 *
		 * ##FormLabel Name
		 * ##FormFieldHint <span class='pz-hint'>Mitarbeiter Name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0
		 * ##FormPlaceholder Nachname des Mitarbeiters
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy NON_EMPTY
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $name;
		
		/**
		 * @var string
		 *
		 * ##FormLabel Strasse
		 * ##FormFieldHint <span class='pz-hint'>Strasse</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0
		 * ##FormPlaceholder Beispielstrasse
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Strasse;
		
		/**
		 * @var string
		 *
		 * ##FormLabel Strassennummer
		 * ##FormFieldHint <span class='pz-hint'>Strassennummer</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0
		 * ##FormPlaceholder 33
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Strassennummer;
		
		/**
		 * @var string
		 *
		 * ##FormLabel PLZ
		 * ##FormFieldHint <span class='pz-hint'>Postleitzahl</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0
		 * ##FormPlaceholder 3000
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $PLZ;
		
		/**
		 * @var string
		 *
		 * ##FormLabel Ort
		 * ##FormFieldHint <span class='pz-hint'>Ort</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0
		 * ##FormPlaceholder Bern
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Ort;
		
		/**
		 * @var string
		 *
		 * ##FormLabel Telefon
		 * ##FormFieldHint <span class='pz-hint'>Telefon</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0
		 * ##FormPlaceholder 031 333 44 55
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Telefon;
		
		/**
		 * @var string
		 *
		 * ##FormLabel Handy
		 * ##FormFieldHint <span class='pz-hint'>Handy</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0
		 * ##FormPlaceholder 079 333 44 55
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Handy;
		
		/**
		 * @var string
		 *
		 * ##FormLabel E-Mail
		 * ##FormFieldHint <span class='pz-hint'>E-Mailadresse</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0
		 * ##FormPlaceholder muster@meier.ch
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $EMail;
		
		/**
		 * @var \DateTime
		 *
		 * ##FormLabel Gebürtsdatum
		 * ##FormFieldHint <span class='pz-hint'>Gebürtsdatum</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0
		 * ##FormPlaceholder 01.01.1970
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy DATE
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $geb_datum;
		
		/**
		 * @var string
		 *
		 * --FormLabel Passwort
		 * --FormFieldHint <span class='pz-hint'><span class="fa fa-eye pull-right pz-view-raw-pass-toggle" id="pz-view-raw-pass-toggle"></span></span>
		 * --FormInputType text
		 * --FormInputRequired 0
		 * --FormInputOptions NULL
		 * --FormValidationStrategy MISC
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Password
		 */
		protected $Passwort;
		
		/**
		 * @var string
		 *
		 * ##FormLabel Bemerkungen
		 * ##FormFieldHint <span class='pz-hint'>Bemerkungen</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0
		 * ##FormPlaceholder Bemerkungen
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\EditorEnhanced
		 */
		protected $Bemerkungen;
		
		/**
		 * @var \App\Forms\CoWorkerEntryEntity
		 */
		protected static $instance;


		public function __construct(){
			# global $kernel;
			# $session        = $kernel->getContainer()->get('session');
			# $melSession     = $session->get(RequestBridge::SessionNameSpace);
			# $this->ticket_MA_verantwortung  = isset($melSession['department']) ? $melSession['department'] : $this->ticket_MA_verantwortung;
			$this->geb_datum = new \DateTime();
			$this->initializeEntityBank();
			static::$instance = $this;
		}
		
		/**
		 * @return int
		 */
		public function getKundenid() {
			return $this->kundenid;
		}
		
		/**
		 * @return string
		 */
		public function getVorname() {
			return $this->vorname;
		}
		
		/**
		 * @return string
		 */
		public function getName() {
			return $this->name;
		}
		
		/**
		 * @return string
		 */
		public function getStrasse() {
			return $this->Strasse;
		}
		
		/**
		 * @return string
		 */
		public function getStrassennummer() {
			return $this->Strassennummer;
		}
		
		/**
		 * @return string
		 */
		public function getPLZ() {
			return $this->PLZ;
		}
		
		/**
		 * @return string
		 */
		public function getOrt() {
			return $this->Ort;
		}
		
		/**
		 * @return string
		 */
		public function getTelefon() {
			return $this->Telefon;
		}
		
		/**
		 * @return string
		 */
		public function getHandy() {
			return $this->Handy;
		}
		
		/**
		 * @return string
		 */
		public function getEMail(){
			return $this->EMail;
		}
		
		/**
		 * @return \DateTime
		 */
		public function getGebDatum() {
			return $this->geb_datum;
		}
		
		/**
		 * @return string
		 */
		public function getPasswort() {
			return $this->Passwort;
		}
		
		/**
		 * @return string
		 */
		public function getBemerkungen(){
			return $this->Bemerkungen;
		}
		
		/**
		 * @param int $kundenid
		 *
		 * @return CoWorkerEntryEntity
		 */
		public function setKundenid($kundenid ): CoWorkerEntryEntity {
			$this->kundenid = $kundenid;
			
			return $this;
		}
		
		/**
		 * @param string $vorname
		 *
		 * @return CoWorkerEntryEntity
		 */
		public function setVorname($vorname ): CoWorkerEntryEntity {
			$this->vorname = $vorname;
			
			return $this;
		}
		
		/**
		 * @param string $name
		 *
		 * @return CoWorkerEntryEntity
		 */
		public function setName($name): CoWorkerEntryEntity {
			$this->name = $name;
			
			return $this;
		}
		
		/**
		 * @param string $Strasse
		 *
		 * @return CoWorkerEntryEntity
		 */
		public function setStrasse( $Strasse ): CoWorkerEntryEntity {
			$this->Strasse = $Strasse;
			
			return $this;
		}
		
		/**
		 * @param string $Strassennummer
		 *
		 * @return CoWorkerEntryEntity
		 */
		public function setStrassennummer( $Strassennummer ): CoWorkerEntryEntity {
			$this->Strassennummer = $Strassennummer;
			
			return $this;
		}
		
		/**
		 * @param string $PLZ
		 *
		 * @return CoWorkerEntryEntity
		 */
		public function setPLZ( $PLZ ): CoWorkerEntryEntity {
			$this->PLZ = $PLZ;
			
			return $this;
		}
		
		/**
		 * @param string $Ort
		 *
		 * @return CoWorkerEntryEntity
		 */
		public function setOrt( $Ort ): CoWorkerEntryEntity {
			$this->Ort = $Ort;
			
			return $this;
		}
		
		/**
		 * @param string $Telefon
		 *
		 * @return CoWorkerEntryEntity
		 */
		public function setTelefon($Telefon ): CoWorkerEntryEntity {
			$this->Telefon = $Telefon;
			
			return $this;
		}
		
		/**
		 * @param string $Handy
		 *
		 * @return CoWorkerEntryEntity
		 */
		public function setHandy($Handy ): CoWorkerEntryEntity {
			$this->Handy = $Handy;
			
			return $this;
		}
		
		/**
		 * @param string $EMail
		 *
		 * @return CoWorkerEntryEntity
		 */
		public function setEMail($EMail ): CoWorkerEntryEntity {
			$this->EMail = $EMail;
			
			return $this;
		}
		
		/**
		 * @param \DateTime $geb_datum
		 *
		 * @return CoWorkerEntryEntity
		 */
		public function setGebDatum( $geb_datum ): CoWorkerEntryEntity {
			$this->geb_datum = $geb_datum;
			
			return $this;
		}
		
		/**
		 * @param string $Passwort
		 *
		 * @return CoWorkerEntryEntity
		 */
		public function setPasswort( $Passwort ): CoWorkerEntryEntity {
			$this->Passwort = $Passwort;
			
			return $this;
		}
		
		/**
		 * @param string $Bemerkungen
		 *
		 * @return CoWorkerEntryEntity
		 */
		public function setBemerkungen( $Bemerkungen ): CoWorkerEntryEntity {
			$this->Bemerkungen = $Bemerkungen;
			
			return $this;
		}

		
		
		
	}
	