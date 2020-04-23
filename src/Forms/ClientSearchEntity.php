<?php 

	namespace App\Forms;

	use Doctrine\ORM\EntityManagerInterface;
	use App\Helpers\Traits\EntityFieldMapperTrait;
	use App\Helpers\Traits\FormObjectLexer;

	/**
	 * ClientSearchEntity
	 **/
	class ClientSearchEntity {
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
		 * --FormLabel Kundenid 
		 * --FormFieldHint <span class='pz-hint'>kundenid</span>
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
		 * ##FormLabel Firma
		 * ##FormFieldHint <span class='pz-hint'>The name of the Client's Company</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0
		 * ##FormPlaceholder Firmenname
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Firma;
		
		/**
		 * @var int
		 * ##FormLabel Kategorie
		 * ##FormFieldHint <span class='pz-hint'>Personen Kategorie</span>
		 * ##FormInputType  number
		 * ##FormInputRequired 0
		 * ##FormPlaceholder Privatkunde
		 * ##FormValidationStrategy NUM
		 * ##FormInputOptions App\Entity\Personen::FetchFunktionenAsOptions
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $Kategorie;


		/**
		 * @var string
		 * ##FormLabel Name 
		 * ##FormFieldHint <span class='pz-hint'>Familienname</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder  Meier
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $name; 

		/**
		 * @var string
		 * ##FormLabel Vorname 
		 * ##FormFieldHint <span class='pz-hint'>Vorname</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder Muster
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $vorname; 

		/**
		 * @var int
		 * ##FormLabel  Geschlecht 
		 * ##FormFieldHint <span class='pz-hint'>Geschlecht</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder Männlich oder Weiblich
		 * ##FormValidationStrategy NUM
		 * ##FormInputOptions App\Entity\Personen::FetchGeschlechtAsOptions
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $Geschlecht; 

		/**
		 * @var int
		 * ##FormLabel Ansprechform
		 * ##FormFieldHint <span class='pz-hint'>Ansprechform</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder Herr
		 * ##FormValidationStrategy NUM
		 * ##FormInputOptions App\Entity\Personen::FetchAnsprechformAsOptions
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $Ansprechform; 

		/**
		 * @var \DateTime
		 * ##FormLabel Geb Datum 
		 * ##FormFieldHint <span class='pz-hint'>geb_datum</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 01.01.1970
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy DATETIME 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $geb_datum;

		/**
		 * @var string
		 * ##FormLabel  Strasse 
		 * ##FormFieldHint <span class='pz-hint'>Strasse</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder Musterstrasse
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Strasse; 

		/**
		 * @var string
		 * ##FormLabel  Strassennummer 
		 * ##FormFieldHint <span class='pz-hint'>Strassennummer</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 100
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Strassennummer; 

		/**
		 * @var string
		 * ##FormLabel  Postleitzahl
		 * ##FormFieldHint <span class='pz-hint'>PLZ</span>
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
		 * ##FormLabel  Ort 
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
		 * ##FormLabel  Telefon 
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
		 * ##FormLabel  Handy 
		 * ##FormFieldHint <span class='pz-hint'>Handy</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder  079 222 33 44
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Handy; 

		/**
		 * @var string
		 * 
		 * ##FormLabel  E-Mail
		 * ##FormFieldHint <span class='pz-hint'>E-Mailadresse</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0
		 * ##FormPlaceholder muster.meier@beispiel.tld
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $EMail; 

		/**
		 * @var string
		 * 
		 * ##FormLabel Website
		 * ##FormFieldHint <span class='pz-hint'>Website</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder beispiel.ch
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Website; 
		

		/**
		 * @var int
		 * 
		 * ##FormLabel PF Personalnummer
		 * ##FormFieldHint <span class='pz-hint'>PF Personalnummer</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 100
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $PF_Personalnummer;
		
		/**
		 * @var int
		 *
		 * ##FormLabel  Newsletter
		 * ##FormFieldHint <span class='pz-hint'>Newsletter</span>
		 * ##FormInputType number
		 * ##FormInputSwitchConfig App\Entity\Personen::FetchSwitchConfig
		 * ##FormInputRequired 0
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy NUM
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\ToggleSwitch
		 */
		protected $Newsletter;
		
		protected static $instance;
		
		protected static $toggleConfig = [
			'magnification'     => 1.5,
			'switchKnobState'   => '0',
			'switchOffOnClass'  => 'pz-col-off',
			'switchKnobClass'   => 'pz-bad',];

		public function __construct(){
			$this->initializeEntityBank();
			$this->geb_datum = new \DateTime("1970-01-01 00:00:00");
		}


		public function getKundenid() {
			return $this->kundenid;
		}

		public function getKategorie() {
			return $this->Kategorie;
		}

		public function getFirma() {
			return $this->Firma;
		}

		public function getName() {
			return $this->name;
		}

		public function getVorname() {
			return $this->vorname;
		}

		public function getGeschlecht() {
			return $this->Geschlecht;
		}

		public function getAnsprechform() {
			return $this->Ansprechform;
		}

		public function getGebDatum() {
			return $this->geb_datum;
		}

		public function getStrasse() {
			return $this->Strasse;
		}

		public function getStrassennummer() {
			return $this->Strassennummer;
		}

		public function getPLZ() {
			return $this->PLZ;
		}

		public function getOrt() {
			return $this->Ort;
		}

		public function getTelefon() {
			return $this->Telefon;
		}

		public function getHandy() {
			return $this->Handy;
		}

		public function getEMail() {
			return $this->EMail;
		}

		public function getWebsite() {
			return $this->Website;
		}

		public function getPasswort() {
			return $this->Passwort;
		}
		
		

		public function setKundenid($kundenid) {
			$this->kundenid = $kundenid;
			return $this;
		}

		public function setKategorie($Kategorie) {
			$this->Kategorie = $Kategorie;
			return $this;
		}

		public function setFirma($Firma) {
			$this->Firma = $Firma;
			return $this;
		}

		public function setName($name) {
			$this->name = $name;
			return $this;
		}

		public function setVorname($vorname) {
			$this->vorname = $vorname;
			return $this;
		}

		public function setGeschlecht($Geschlecht) {
			$this->Geschlecht = $Geschlecht;
			return $this;
		}

		public function setAnsprechform($Ansprechform) {
			$this->Ansprechform = $Ansprechform;
			return $this;
		}

		public function setStrasse($Strasse) {
			$this->Strasse = $Strasse;
			return $this;
		}

		public function setStrassennummer($Strassennummer) {
			$this->Strassennummer = $Strassennummer;
			return $this;
		}

		public function setPLZ($PLZ) {
			$this->PLZ = $PLZ;
			return $this;
		}

		public function setOrt($Ort) {
			$this->Ort = $Ort;
			return $this;
		}

		public function setTelefon($Telefon) {
			$this->Telefon = $Telefon;
			return $this;
		}

		public function setHandy($Handy) {
			$this->Handy = $Handy;
			return $this;
		}

		public function setEMail($EMail) {
			$this->EMail = $EMail;
			return $this;
		}

		public function setWebsite($Website) {
			$this->Website    = !$Website ? 'Unbekannt...' : $Website;
			return $this;
		}
		
		/**
		 * @return int
		 */
		public function getNewsletter(): int {
			return $this->Newsletter;
		}
		
		/**
		 * @param int $Newsletter
		 *
		 * @return ClientSearchEntity
		 */
		public function setNewsletter( int $Newsletter ): ClientSearchEntity {
			$this->Newsletter = $Newsletter;
			
			return $this;
		}

		


	} 
