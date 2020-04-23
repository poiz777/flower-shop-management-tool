<?php
	
	namespace App\Entity;
	
	use App\Poiz\HTML\Widgets\FormHelpers\PzDate;
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
	 * Personen
	 * @Table(name="personen")
	 * @Entity(repositoryClass="App\Entity\Repo\PersonenRepo")
	 **/
	class Personen {
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
		 * @Id Personen
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 *
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
		 * @Column(name="Firma", type="string", length=500, nullable=true)
		 *
		 * ##FormLabel Firma
		 * ##FormFieldHint <span class='pz-hint'>The name of the Client's Company</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0
		 * ##FormPlaceholder Firmenname
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\EditorEnhanced
		 */
		protected $Firma;
		
		/**
		 * @var int
		 * @Column(name="Kategorie", type="smallint", length=3, nullable=false, options={"default":"1"})
		 *
		 * ##FormLabel Kategorie
		 * ##FormFieldHint <span class='pz-hint'>Kategorie</span>
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
		 * @Column(name="name", type="string", length=30, nullable=false)
		 *
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
		 * @Column(name="vorname", type="string", length=20, nullable=false)
		 *
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
		 * @Column(name="Geschlecht", type="smallint", length=2, nullable=false)
		 *
		 * --FormLabel  Geschlecht
		 * --FormFieldHint <span class='pz-hint'>Geschlecht</span>
		 * --FormInputType number
		 * --FormInputRequired 0
		 * --FormPlaceholder Männlich oder Weiblich
		 * --FormInputOptions App\Entity\Personen::FetchGeschlechtAsOptions
		 * --FormValidationStrategy NUM
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $Geschlecht = 3;
		
		/**
		 * @var int
		 * @Column(name="Ansprechform", type="smallint", length=2, nullable=false)
		 *
		 * --FormLabel  Ansprechform
		 * --FormFieldHint <span class='pz-hint'>Ansprechform</span>
		 * --FormInputType number
		 * --FormInputRequired 0
		 * --FormPlaceholder Herr
		 * --FormValidationStrategy NUM
		 * --FormInputOptions App\Entity\Personen::FetchAnsprechformAsOptions
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $Ansprechform = 1;
		
		/**
		 * @var \DateTime
		 * @Column(name="geb_datum", type="date", nullable=false, options={"default":"1970-01-01"})
		 *
		 * --FormLabel Gebürtsdatum
		 * --FormFieldHint <span class='pz-hint'>Gebürtsdatum</span>
		 * --FormInputType datetime
		 * --FormInputRequired 0
		 * --FormPlaceholder 01.01.1970
		 * --FormInputOptions NULL
		 * --FormValidationStrategy MISC
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $geb_datum;
		
		/**
		 * @var string
		 * @Column(name="Strasse", type="string", length=50, nullable=false)
		 *
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
		 * @Column(name="Strassennummer", type="string", length=20, nullable=false)
		 *
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
		 * @Column(name="PLZ", type="string", length=5, nullable=false)
		 *
		 * ##FormLabel  PLZ
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
		 * @Column(name="Ort", type="string", length=40, nullable=false)
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
		 * @Column(name="Telefon", type="string", length=18, nullable=false)
		 *
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
		 * @Column(name="Handy", type="string", length=18, nullable=false)
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
		 * @Column(name="EMail", type="string", length=40, nullable=false)
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
		 * @Column(name="Website", type="string", length=300, nullable=true)
		 *
		 * ##FormLabel  Website
		 * ##FormFieldHint <span class='pz-hint'>Website</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0
		 * ##FormPlaceholder beispiel.ch
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Website;
		
		/**
		 * @var string
		 * @Column(name="Passwort", type="string", length=30, nullable=false)
		 *
		 * --FormLabel  Passwort
		 * --FormFieldHint <span class='pz-hint'><span class="fa fa-eye pull-right pz-view-raw-pass-toggle" id="pz-view-raw-pass-toggle"></span></span>
		 * --FormInputType password
		 * --FormInputRequired 0
		 * --FormInputOptions NULL
		 * --FormValidationStrategy MISC
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Password
		 */
		protected $Passwort = 'NULL';
		
		/**
		 * @var int
		 * @Column(name="RFMR", type="integer", length=7, nullable=true)
		 *
		 * --FormLabel  RFMR
		 * --FormFieldHint <span class='pz-hint'>RFMR???</span>
		 * --FormInputType number
		 * --FormInputRequired 0
		 * --FormPlaceholder 1234567
		 * --FormInputOptions NULL
		 * --FormValidationStrategy NUM
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $RFMR;
		
		/**
		 * @var int
		 * @Column(name="RFMR_deb", type="integer", length=7, nullable=false)
		 *
		 * --FormLabel  RFMR Deb???
		 * --FormFieldHint <span class='pz-hint'>RFMR_deb</span>
		 * --FormInputType number
		 * --FormInputRequired 0
		 * --FormPlaceholder 123456
		 * --FormInputOptions NULL
		 * --FormValidationStrategy NUM
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $RFMR_deb="NULL";
		
		/**
		 * @var \DateTime
		 * @Column(name="reg_datum", type="date", nullable=false, options={"default":"1970-01-01"})
		 *
		 * ##FormLabel Reg Datum
		 * ##FormFieldHint <span class='pz-hint'>reg_datum</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy DATE
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $reg_datum;
		
		/**
		 * @var int
		 * @Column(name="Newsletter", type="smallint", length=3, nullable=true)
		 *
		 *  --FormLabel  Newsletter
		 *  --FormFieldHint <span class='pz-hint'>Newsletter</span>
		 *  --FormInputType number
		 *  --FormInputSwitchConfig App\Entity\Personen::FetchSwitchConfig
		 *  --FormInputRequired 0
		 *  --FormInputOptions NULL
		 *  --FormValidationStrategy NUM
		 *  --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\ToggleSwitch
		 */
		protected $Newsletter = 0;
		
		/**
		 * @var int
		 * @Column(name="Kasse_sichtbar", type="smallint", length=3, nullable=false)
		 *
		 *  -- FormLabel  Kasse Sichtbar
		 *  -- FormFieldHint <span class='pz-hint'>Kasse_sichtbar</span>
		 *  -- FormInputType number
		 *  -- FormInputRequired 0
		 *  -- FormInputOptions NULL
		 *  -- FormValidationStrategy NUM
		 *  -- FormInputSwitchConfig App\Entity\Personen::FetchSwitchConfig
		 *  -- FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\ToggleSwitch
		 */
		protected $Kasse_sichtbar = 1;
		
		/**
		 * @var int
		 * @Column(name="Navigation", type="smallint", length=3, nullable=false)
		 *
		 *  -- FormLabel  Navigation
		 *  -- FormFieldHint <span class='pz-hint'>Navigation</span>
		 *  -- FormInputType number
		 *  -- FormInputRequired 0
		 *  -- FormPlaceholder 100
		 *  -- FormInputOptions NULL
		 *  -- FormValidationStrategy NUM
		 *  -- FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Navigation = 1;
		
		/**
		 * @var int
		 * @Column(name="PF_Kategorie", type="smallint", length=2, nullable=false)
		 *
		 * --FormLabel  PF Kategorie
		 * --FormFieldHint <span class='pz-hint'>PF Kategorie</span>
		 * --FormInputType number
		 * --FormInputRequired 0
		 * --FormPlaceholder PF Kategorie - Use Drop Down here
		 * --FormValidationStrategy NUM
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $PF_Kategorie=0;
		
		/**
		 * @var string
		 * @Column(name="PF_Bereich", type="string", length=20, nullable=false)
		 *
		 * --FormLabel  PF Bereich
		 * --FormFieldHint <span class='pz-hint'>PF_Bereich</span>
		 * --FormInputType text
		 * --FormInputRequired 0
		 * --FormPlaceholder 0
		 * --FormInputOptions NULL
		 * --FormValidationStrategy MISC
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $PF_Bereich = " ";
		
		/**
		 * @var string
		 * @Column(name="PF_Bezeichnung", type="string", length=80, nullable=false)
		 *
		 * --FormLabel  P F Bezeichnung
		 * --FormFieldHint <span class='pz-hint'>PF_Bezeichnung</span>
		 * --FormInputType text
		 * --FormInputRequired 0
		 * --FormPlaceholder 0
		 * --FormInputOptions NULL
		 * --FormValidationStrategy MISC
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\TextArea
		 */
		protected $PF_Bezeichnung = " ";
		
		/**
		 * @var int
		 * @Column(name="PF_Personalnummer", type="integer", length=16, nullable=false)
		 *
		 * --FormLabel  P F Personalnummer
		 * --FormFieldHint <span class='pz-hint'>PF_Personalnummer</span>
		 * --FormInputType number
		 * --FormInputRequired 0
		 * --FormPlaceholder 0
		 * --FormInputOptions NULL
		 * --FormValidationStrategy NUM
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $PF_Personalnummer = 0;
		
		
		/**
		 * @var string
		 * @Column(name="Bemerkungen", type="string", length=10000, nullable=false)
		 *
		 * ##FormLabel  Bemerkungen
		 * ##FormFieldHint <span class='pz-hint'>Bemerkungen</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0
		 * ##FormPlaceholder 0
		 * ##FormInputOptions NULL
		 * ##FormValidationStrategy MISC
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\EditorEnhanced
		 */
		protected $Bemerkungen;
		
		/**
		 * @var int
		 * @Column(name="deleted", type="integer", length=1, options={"default": 0})
		 *
		 * --FormLabel Gelöscht?
		 * --FormFieldHint <span class='pz-hint'>Sollte dieser Eintrag als gelöscht markiert werden?</span>
		 * --FormInputType text
		 * --FormInputRequired 0
		 * --FormPlaceholder 0
		 * --FormValidationStrategy MISC
		 * --FormInputOptions App\Entity\Personen::fetchTicketYesNoOptions
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $deleted = 0;
		
		/**
		 * @var int
		 * @Column(name="hidden", type="integer", length=1,  options={"default": 0})
		 *
		 * --FormLabel Versteckt?
		 * --FormFieldHint <span class='pz-hint'>Sollte dieser Eintrag als versteckt markiert sein?</span>
		 * --FormInputType select
		 * --FormInputRequired 0
		 * --FormPlaceholder 0
		 * --FormValidationStrategy MISC
		 * --FormInputOptions App\Entity\Personen::fetchTicketYesNoOptions
		 * --FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DropDownEnhanced
		 */
		protected $hidden = 0;
		
		
		
		/**
		 * @var array
		 */
		private $mrMrs          = [];
		
		/**
		 * @var array
		 */
		private $formOfAddress  = [];
		
		/**
		 * @var \App\Entity\Personen
		 */
		protected static $instance;
		
		protected static $toggleConfig = [
			'magnification'     => 1.5,
			'switchKnobState'   => '0',
			'switchOffOnClass'  => 'pz-col-off',
			'switchKnobClass'   => 'pz-bad',];
		
		public function __construct(){
			$this->geb_datum  = new \DateTime("1970-01-01 00:00:00");
			$this->reg_datum  = new \DateTime();
			$this->initializeEntityBank();
			static::$instance = $this;
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
		
		public function getBemerkungen() {
			return $this->Bemerkungen;
		}
		
		public function getRFMR() {
			return $this->RFMR;
		}
		
		public function getRFMRDeb() {
			return $this->RFMR_deb;
		}
		
		public function getRegDatum() {
			return $this->reg_datum;
		}
		
		public function getNewsletter() {
			return $this->Newsletter;
		}
		
		public function getKasseSichtbar() {
			return $this->Kasse_sichtbar;
		}
		
		public function getNavigation() {
			return $this->Navigation;
		}
		
		public function getPFKategorie() {
			return $this->PF_Kategorie;
		}
		
		public function getPFBereich() {
			return $this->PF_Bereich;
		}
		
		public function getPFBezeichnung() {
			return $this->PF_Bezeichnung;
		}
		
		public function getPFPersonalnummer() {
			return $this->PF_Personalnummer;
		}
		
		public function getHidden(){
			return $this->hidden;
		}
		
		public function getDeleted(){
			return $this->deleted;
		}
		
		public function getMrMrs(){
			return $this->mrMrs;
		}
		
		public function getFormOfAddress(){
			return $this->formOfAddress;
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
		
		public function setGebDatum($geb_datum) {
			$replaced = is_string($geb_datum) ? preg_replace("#(\d)(T)(\d)#", "$1 $2", $geb_datum) : $geb_datum;
			$this->geb_datum = is_string($geb_datum) ? new \DateTime($replaced)  : $geb_datum;
			if(!$this->geb_datum){
				$this->geb_datum = new \DateTime("1970-01-01 00:00:00");
			}
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
		
		public function setPasswort($Passwort) {
			$this->Passwort = $Passwort;
			return $this;
		}
		
		public function setBemerkungen($Bemerkungen) {
			$this->Bemerkungen    = !$Bemerkungen ? 'Keiner Bemerkungen...' : $Bemerkungen;
			return $this;
		}
		
		public function setRFMR($RFMR) {
			$this->RFMR = $RFMR;
			return $this;
		}
		
		public function setRFMRDeb($RFMR_deb) {
			$this->RFMR_deb = $RFMR_deb;
			return $this;
		}
		
		public function setRegDatum($reg_datum) {
			$replaced        = is_string($reg_datum) ? preg_replace("#(\d)(T)(\d)#", "$1 $2", $reg_datum) : $reg_datum;
			# $replaced        = is_string($reg_datum) ? preg_replace("#(T\d*$)#", "", $reg_datum) : $reg_datum;
			$this->reg_datum = is_string($reg_datum) ? new \DateTime($replaced)  : $reg_datum;
			return $this;
		}
		
		public function setNewsletter($Newsletter) {
			$this->Newsletter = $Newsletter;
			static::$toggleConfig = [
				'magnification'     => $this->Newsletter ? 1.5 : 2.5,
				'switchKnobState'   => $this->Newsletter ? '1' : '0',
				'switchOffOnClass'  => $this->Newsletter ? 'pz-col-on' : 'pz-col-off',
				'switchKnobClass'   => $this->Newsletter ? 'pz-good' : 'pz-bad',];
			return $this;
		}
		
		public function setKasseSichtbar($Kasse_sichtbar) {
			$this->Kasse_sichtbar = $Kasse_sichtbar;
			return $this;
		}
		
		public function setNavigation($Navigation) {
			$this->Navigation = $Navigation;
			return $this;
		}
		
		public function setPFKategorie($PF_Kategorie) {
			$this->PF_Kategorie = $PF_Kategorie;
			return $this;
		}
		
		public function setPFBereich($PF_Bereich) {
			$this->PF_Bereich = $PF_Bereich;
			return $this;
		}
		
		public function setPFBezeichnung($PF_Bezeichnung) {
			$this->PF_Bezeichnung    = !$PF_Bezeichnung ? 'Kein PF_Bezeichnung...' : $PF_Bezeichnung;
			return $this;
		}
		
		public function setPFPersonalnummer($PF_Personalnummer) {
			$this->PF_Personalnummer = $PF_Personalnummer;
			return $this;
		}
		
		public function setHidden($hidden){
			$this->hidden = $hidden;
			return $this;
		}
		
		public function setDeleted($deleted){
			$this->deleted = $deleted;
			return $this;
		}
		
		
		public function setMrMrs($mrMrs){
			$this->mrMrs = $mrMrs;
			return $this;
		}
		
		public function setFormOrAddress($formOfAddress){
			$this->formOfAddress = $formOfAddress;
			return $this;
		}
		
		
	}
