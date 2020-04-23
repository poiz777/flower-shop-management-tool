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
	 * InhaltDaten
	 * @Table(name="Inhalt_daten")
	 * @Entity(repositoryClass="App\Entity\Repo\InhaltDatenRepo")
	 **/
	class InhaltDaten { 

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
		 * @Id InhaltDaten
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Inhalt Daten Id 
		 * ##FormFieldHint <span class='pz-hint'>Inhalt_daten_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Inhalt_daten_id; 

		/**
		 * @var string
		 * @Column(name="Inhalt_daten_name", type="string", length=60, nullable=false) 
		 * 
		 * ##FormLabel  Inhalt Daten Name 
		 * ##FormFieldHint <span class='pz-hint'>Inhalt_daten_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Inhalt_daten_name; 

		/**
		 * @var int
		 * @Column(name="Inhalt_daten_Template_element_id", type="smallint", length=5, nullable=false) 
		 * 
		 * ##FormLabel  Inhalt Daten Template Element Id 
		 * ##FormFieldHint <span class='pz-hint'>Inhalt_daten_Template_element_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Inhalt_daten_Template_element_id; 

		/**
		 * @var int
		 * @Column(name="Inhalt_daten_class_id", type="smallint", length=5, nullable=false) 
		 * 
		 * ##FormLabel  Inhalt Daten Class Id 
		 * ##FormFieldHint <span class='pz-hint'>Inhalt_daten_class_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Inhalt_daten_class_id; 

		/**
		 * @var string
		 * @Column(name="Inhalt_daten_content", type="text", nullable=false) 
		 * 
		 * ##FormLabel  Inhalt Daten Content 
		 * ##FormFieldHint <span class='pz-hint'>Inhalt_daten_content</span>
		 * ##FormInputType textarea
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy HTML 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\EditorEnhanced
		 */
		protected $Inhalt_daten_content; 

		/**
		 * @var string
		 * @Column(name="Inhalt_daten_attr_1_wert", type="string", length=60, nullable=false) 
		 * 
		 * ##FormLabel  Inhalt Daten Attr 1 Wert 
		 * ##FormFieldHint <span class='pz-hint'>Inhalt_daten_attr_1_wert</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Inhalt_daten_attr_1_wert; 

		/**
		 * @var string
		 * @Column(name="Inhalt_daten_attr_2_wert", type="string", length=60, nullable=false) 
		 * 
		 * ##FormLabel  Inhalt Daten Attr 2 Wert 
		 * ##FormFieldHint <span class='pz-hint'>Inhalt_daten_attr_2_wert</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Inhalt_daten_attr_2_wert; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getInhaltDatenId() {
			return $this->Inhalt_daten_id;
		}

		public function getInhaltDatenName() {
			return $this->Inhalt_daten_name;
		}

		public function getInhaltDatenTemplateElementId() {
			return $this->Inhalt_daten_Template_element_id;
		}

		public function getInhaltDatenClassId() {
			return $this->Inhalt_daten_class_id;
		}

		public function getInhaltDatenContent() {
			return $this->Inhalt_daten_content;
		}

		public function getInhaltDatenAttr1Wert() {
			return $this->Inhalt_daten_attr_1_wert;
		}

		public function getInhaltDatenAttr2Wert() {
			return $this->Inhalt_daten_attr_2_wert;
		}


		public function setInhaltDatenId($Inhalt_daten_id) {
			$this->Inhalt_daten_id = $Inhalt_daten_id;
			return $this;
		}

		public function setInhaltDatenName($Inhalt_daten_name) {
			$this->Inhalt_daten_name = $Inhalt_daten_name;
			return $this;
		}

		public function setInhaltDatenTemplateElementId($Inhalt_daten_Template_element_id) {
			$this->Inhalt_daten_Template_element_id = $Inhalt_daten_Template_element_id;
			return $this;
		}

		public function setInhaltDatenClassId($Inhalt_daten_class_id) {
			$this->Inhalt_daten_class_id = $Inhalt_daten_class_id;
			return $this;
		}

		public function setInhaltDatenContent($Inhalt_daten_content) {
			$this->Inhalt_daten_content = $Inhalt_daten_content;
			return $this;
		}

		public function setInhaltDatenAttr1Wert($Inhalt_daten_attr_1_wert) {
			$this->Inhalt_daten_attr_1_wert = $Inhalt_daten_attr_1_wert;
			return $this;
		}

		public function setInhaltDatenAttr2Wert($Inhalt_daten_attr_2_wert) {
			$this->Inhalt_daten_attr_2_wert = $Inhalt_daten_attr_2_wert;
			return $this;
		}




	} 
