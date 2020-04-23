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
	 * Template
	 * @Table(name="Template")
	 * @Entity(repositoryClass="App\Entity\Repo\TemplateRepo")
	 **/
	class Template { 

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
		 * @Id Template
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Template Id 
		 * ##FormFieldHint <span class='pz-hint'>Template_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Template_id; 

		/**
		 * @var string
		 * @Column(name="Template_name", type="string", length=20, nullable=false) 
		 * 
		 * ##FormLabel  Template Name 
		 * ##FormFieldHint <span class='pz-hint'>Template_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Template_name; 

		/**
		 * @var string
		 * @Column(name="Template_div", type="string", length=20, nullable=false) 
		 * 
		 * ##FormLabel  Template Div 
		 * ##FormFieldHint <span class='pz-hint'>Template_div</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Template_div; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getTemplateId() {
			return $this->Template_id;
		}

		public function getTemplateName() {
			return $this->Template_name;
		}

		public function getTemplateDiv() {
			return $this->Template_div;
		}


		public function setTemplateId($Template_id) {
			$this->Template_id = $Template_id;
			return $this;
		}

		public function setTemplateName($Template_name) {
			$this->Template_name = $Template_name;
			return $this;
		}

		public function setTemplateDiv($Template_div) {
			$this->Template_div = $Template_div;
			return $this;
		}




	} 
