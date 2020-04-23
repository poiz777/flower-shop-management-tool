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
	 * VersandArten
	 * @Table(name="versand_arten")
	 * @Entity(repositoryClass="App\Entity\Repo\VersandArtenRepo")
	 **/
	class VersandArten { 

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
		 * @Id VersandArten
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel Versand Arten Id 
		 * ##FormFieldHint <span class='pz-hint'>versand_arten_id</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $versand_arten_id; 

		/**
		 * @var string
		 * @Column(name="versand_arten_name", type="string", length=30, nullable=false) 
		 * 
		 * ##FormLabel Versand Arten Name 
		 * ##FormFieldHint <span class='pz-hint'>versand_arten_name</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $versand_arten_name; 

		/**
		 * @var int
		 * @Column(name="versand_arten_preis", type="integer", length=5, nullable=false) 
		 * 
		 * ##FormLabel Versand Arten Preis 
		 * ##FormFieldHint <span class='pz-hint'>versand_arten_preis</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $versand_arten_preis; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getVersandArtenId() {
			return $this->versand_arten_id;
		}

		public function getVersandArtenName() {
			return $this->versand_arten_name;
		}

		public function getVersandArtenPreis() {
			return $this->versand_arten_preis;
		}


		public function setVersandArtenId($versand_arten_id) {
			$this->versand_arten_id = $versand_arten_id;
			return $this;
		}

		public function setVersandArtenName($versand_arten_name) {
			$this->versand_arten_name = $versand_arten_name;
			return $this;
		}

		public function setVersandArtenPreis($versand_arten_preis) {
			$this->versand_arten_preis = $versand_arten_preis;
			return $this;
		}




	} 
