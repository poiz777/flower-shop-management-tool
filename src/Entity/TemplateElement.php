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
	 * TemplateElement
	 * @Table(name="Template_element")
	 * @Entity(repositoryClass="App\Entity\Repo\TemplateElementRepo")
	 **/
	class TemplateElement { 

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
		 * @Id TemplateElement
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Template Element Id 
		 * ##FormFieldHint <span class='pz-hint'>Template_element_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Template_element_id; 

		/**
		 * @var string
		 * @Column(name="Template_element_name", type="string", length=20, nullable=false) 
		 * 
		 * ##FormLabel  Template Element Name 
		 * ##FormFieldHint <span class='pz-hint'>Template_element_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Template_element_name; 

		/**
		 * @var string
		 * @Column(name="Template_element_tag", type="string", length=30, nullable=false) 
		 * 
		 * ##FormLabel  Template Element Tag 
		 * ##FormFieldHint <span class='pz-hint'>Template_element_tag</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Template_element_tag; 

		/**
		 * @var string
		 * @Column(name="Template_element_attr_1", type="string", length=20, nullable=false) 
		 * 
		 * ##FormLabel  Template Element Attr 1 
		 * ##FormFieldHint <span class='pz-hint'>Template_element_attr_1</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Template_element_attr_1; 

		/**
		 * @var string
		 * @Column(name="Template_element_attr_2", type="string", length=20, nullable=false) 
		 * 
		 * ##FormLabel  Template Element Attr 2 
		 * ##FormFieldHint <span class='pz-hint'>Template_element_attr_2</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Template_element_attr_2; 

		/**
		 * @var string
		 * @Column(name="Template_element_include", type="string", length=200, nullable=false) 
		 * 
		 * ##FormLabel  Template Element Include 
		 * ##FormFieldHint <span class='pz-hint'>Template_element_include</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Template_element_include; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getTemplateElementId() {
			return $this->Template_element_id;
		}

		public function getTemplateElementName() {
			return $this->Template_element_name;
		}

		public function getTemplateElementTag() {
			return $this->Template_element_tag;
		}

		public function getTemplateElementAttr1() {
			return $this->Template_element_attr_1;
		}

		public function getTemplateElementAttr2() {
			return $this->Template_element_attr_2;
		}

		public function getTemplateElementInclude() {
			return $this->Template_element_include;
		}


		public function setTemplateElementId($Template_element_id) {
			$this->Template_element_id = $Template_element_id;
			return $this;
		}

		public function setTemplateElementName($Template_element_name) {
			$this->Template_element_name = $Template_element_name;
			return $this;
		}

		public function setTemplateElementTag($Template_element_tag) {
			$this->Template_element_tag = $Template_element_tag;
			return $this;
		}

		public function setTemplateElementAttr1($Template_element_attr_1) {
			$this->Template_element_attr_1 = $Template_element_attr_1;
			return $this;
		}

		public function setTemplateElementAttr2($Template_element_attr_2) {
			$this->Template_element_attr_2 = $Template_element_attr_2;
			return $this;
		}

		public function setTemplateElementInclude($Template_element_include) {
			$this->Template_element_include = $Template_element_include;
			return $this;
		}




	} 
