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
	 * PostfinanceFunktion
	 * @Table(name="postfinance_funktion")
	 * @Entity(repositoryClass="App\Entity\Repo\PostfinanceFunktionRepo")
	 **/
	class PostfinanceFunktion { 

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
		 * @Id PostfinanceFunktion
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel Postfinance Funktionid 
		 * ##FormFieldHint <span class='pz-hint'>postfinance_funktionid</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $postfinance_funktionid; 

		/**
		 * @var string
		 * @Column(name="funktion_name", type="string", length=30, nullable=false) 
		 * 
		 * ##FormLabel Funktion Name 
		 * ##FormFieldHint <span class='pz-hint'>funktion_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $funktion_name; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getPostfinanceFunktionid() {
			return $this->postfinance_funktionid;
		}

		public function getFunktionName() {
			return $this->funktion_name;
		}


		public function setPostfinanceFunktionid($postfinance_funktionid) {
			$this->postfinance_funktionid = $postfinance_funktionid;
			return $this;
		}

		public function setFunktionName($funktion_name) {
			$this->funktion_name = $funktion_name;
			return $this;
		}




	} 
