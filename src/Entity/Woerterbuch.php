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
	 * Woerterbuch
	 * @Table(name="woerterbuch")
	 * @Entity(repositoryClass="App\Entity\Repo\WoerterbuchRepo")
	 **/
	class Woerterbuch { 

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
		 * @Id Woerterbuch
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel Wbuchid 
		 * ##FormFieldHint <span class='pz-hint'>wbuchid</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $wbuchid; 

		/**
		 * @var string
		 * @Column(name="wbuchwort", type="string", length=30, nullable=false) 
		 * 
		 * ##FormLabel Wbuchwort 
		 * ##FormFieldHint <span class='pz-hint'>wbuchwort</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $wbuchwort; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getWbuchid() {
			return $this->wbuchid;
		}

		public function getWbuchwort() {
			return $this->wbuchwort;
		}


		public function setWbuchid($wbuchid) {
			$this->wbuchid = $wbuchid;
			return $this;
		}

		public function setWbuchwort($wbuchwort) {
			$this->wbuchwort = $wbuchwort;
			return $this;
		}




	} 
