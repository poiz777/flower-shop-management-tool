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
	 * WebsiteSeiten
	 * @Table(name="Website_seiten")
	 * @Entity(repositoryClass="App\Entity\Repo\WebsiteSeitenRepo")
	 **/
	class WebsiteSeiten { 

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
		 * @Id WebsiteSeiten
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel  Website Seiten Id 
		 * ##FormFieldHint <span class='pz-hint'>Website_seiten_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $Website_seiten_id; 

		/**
		 * @var string
		 * @Column(name="Website_seiten_name", type="string", length=30, nullable=false) 
		 * 
		 * ##FormLabel  Website Seiten Name 
		 * ##FormFieldHint <span class='pz-hint'>Website_seiten_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $Website_seiten_name; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getWebsiteSeitenId() {
			return $this->Website_seiten_id;
		}

		public function getWebsiteSeitenName() {
			return $this->Website_seiten_name;
		}


		public function setWebsiteSeitenId($Website_seiten_id) {
			$this->Website_seiten_id = $Website_seiten_id;
			return $this;
		}

		public function setWebsiteSeitenName($Website_seiten_name) {
			$this->Website_seiten_name = $Website_seiten_name;
			return $this;
		}




	} 
