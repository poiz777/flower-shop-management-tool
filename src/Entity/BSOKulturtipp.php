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
	 * BSOKulturtipp
	 * @Table(name="BSO_Kulturtipp")
	 * @Entity(repositoryClass="App\Entity\Repo\BSOKulturtippRepo")
	 **/
	class BSOKulturtipp { 

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
		 * @Id BSOKulturtipp
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  B S O Kulturtipp Id 
		 * ##FormFieldHint <span class='pz-hint'>BSO_Kulturtipp_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $BSO_Kulturtipp_id; 

		/**
		 * @var string
		 * @Column(name="BSO_Kulturtipp_konzertart", type="string", length=50, nullable=false) 
		 * 
		 * ##FormLabel  B S O Kulturtipp Konzertart 
		 * ##FormFieldHint <span class='pz-hint'>BSO_Kulturtipp_konzertart</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $BSO_Kulturtipp_konzertart; 

		/**
		 * @var string
		 * @Column(name="BSO_Kulturtipp_daten", type="string", length=50, nullable=false) 
		 * 
		 * ##FormLabel  B S O Kulturtipp Daten 
		 * ##FormFieldHint <span class='pz-hint'>BSO_Kulturtipp_daten</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $BSO_Kulturtipp_daten; 

		/**
		 * @var string
		 * @Column(name="BSO_Kulturtipp_spieler", type="string", length=50, nullable=false) 
		 * 
		 * ##FormLabel  B S O Kulturtipp Spieler 
		 * ##FormFieldHint <span class='pz-hint'>BSO_Kulturtipp_spieler</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $BSO_Kulturtipp_spieler; 

		/**
		 * @var string
		 * @Column(name="BSO_Kulturtipp_programm", type="string", length=50, nullable=false) 
		 * 
		 * ##FormLabel  B S O Kulturtipp Programm 
		 * ##FormFieldHint <span class='pz-hint'>BSO_Kulturtipp_programm</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $BSO_Kulturtipp_programm; 

		/**
		 * @var string
		 * @Column(name="BSO_Kulturtipp_link_BSO", type="string", length=400, nullable=false) 
		 * 
		 * ##FormLabel  B S O Kulturtipp Link B S O 
		 * ##FormFieldHint <span class='pz-hint'>BSO_Kulturtipp_link_BSO</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $BSO_Kulturtipp_link_BSO; 

		/**
		 * @var string
		 * @Column(name="BSO_Kulturtipp_link_iTunes", type="string", length=800, nullable=false) 
		 * 
		 * ##FormLabel  B S O Kulturtipp Link I Tunes 
		 * ##FormFieldHint <span class='pz-hint'>BSO_Kulturtipp_link_iTunes</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $BSO_Kulturtipp_link_iTunes; 

		/**
		 * @var \DateTime
		 * @Column(name="BSO_Kulturtipp_datum_ein", type="datetime", nullable=false, options={"default":"0000-00-00 00:00:00"}) 
		 * 
		 * ##FormLabel  B S O Kulturtipp Datum Ein 
		 * ##FormFieldHint <span class='pz-hint'>BSO_Kulturtipp_datum_ein</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy DATETIME 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $BSO_Kulturtipp_datum_ein; 

		/**
		 * @var \DateTime
		 * @Column(name="BSO_Kulturtipp_datum_aus", type="datetime", nullable=false, options={"default":"0000-00-00 00:00:00"}) 
		 * 
		 * ##FormLabel  B S O Kulturtipp Datum Aus 
		 * ##FormFieldHint <span class='pz-hint'>BSO_Kulturtipp_datum_aus</span>
		 * ##FormInputType datetime
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy DATETIME 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\DatePicker
		 */
		protected $BSO_Kulturtipp_datum_aus; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getBSOKulturtippId() {
			return $this->BSO_Kulturtipp_id;
		}

		public function getBSOKulturtippKonzertart() {
			return $this->BSO_Kulturtipp_konzertart;
		}

		public function getBSOKulturtippDaten() {
			return $this->BSO_Kulturtipp_daten;
		}

		public function getBSOKulturtippSpieler() {
			return $this->BSO_Kulturtipp_spieler;
		}

		public function getBSOKulturtippProgramm() {
			return $this->BSO_Kulturtipp_programm;
		}

		public function getBSOKulturtippLinkBSO() {
			return $this->BSO_Kulturtipp_link_BSO;
		}

		public function getBSOKulturtippLinkITunes() {
			return $this->BSO_Kulturtipp_link_iTunes;
		}

		public function getBSOKulturtippDatumEin() {
			return $this->BSO_Kulturtipp_datum_ein;
		}

		public function getBSOKulturtippDatumAus() {
			return $this->BSO_Kulturtipp_datum_aus;
		}


		public function setBSOKulturtippId($BSO_Kulturtipp_id) {
			$this->BSO_Kulturtipp_id = $BSO_Kulturtipp_id;
			return $this;
		}

		public function setBSOKulturtippKonzertart($BSO_Kulturtipp_konzertart) {
			$this->BSO_Kulturtipp_konzertart = $BSO_Kulturtipp_konzertart;
			return $this;
		}

		public function setBSOKulturtippDaten($BSO_Kulturtipp_daten) {
			$this->BSO_Kulturtipp_daten = $BSO_Kulturtipp_daten;
			return $this;
		}

		public function setBSOKulturtippSpieler($BSO_Kulturtipp_spieler) {
			$this->BSO_Kulturtipp_spieler = $BSO_Kulturtipp_spieler;
			return $this;
		}

		public function setBSOKulturtippProgramm($BSO_Kulturtipp_programm) {
			$this->BSO_Kulturtipp_programm = $BSO_Kulturtipp_programm;
			return $this;
		}

		public function setBSOKulturtippLinkBSO($BSO_Kulturtipp_link_BSO) {
			$this->BSO_Kulturtipp_link_BSO = $BSO_Kulturtipp_link_BSO;
			return $this;
		}

		public function setBSOKulturtippLinkITunes($BSO_Kulturtipp_link_iTunes) {
			$this->BSO_Kulturtipp_link_iTunes = $BSO_Kulturtipp_link_iTunes;
			return $this;
		}

		public function setBSOKulturtippDatumEin($BSO_Kulturtipp_datum_ein) {
			$this->BSO_Kulturtipp_datum_ein = $BSO_Kulturtipp_datum_ein;
			return $this;
		}

		public function setBSOKulturtippDatumAus($BSO_Kulturtipp_datum_aus) {
			$this->BSO_Kulturtipp_datum_aus = $BSO_Kulturtipp_datum_aus;
			return $this;
		}




	} 
