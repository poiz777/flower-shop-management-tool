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
	 * PostfinanceBereich
	 * @Table(name="postfinance_bereich")
	 * @Entity(repositoryClass="App\Entity\Repo\PostfinanceBereichRepo")
	 **/
	class PostfinanceBereich { 

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
		 * @Id PostfinanceBereich
		 * @Column(type="integer")
		 * @GeneratedValue(strategy="AUTO")
		 * 
		 * ##FormLabel Postfinance Bereichid 
		 * ##FormFieldHint <span class='pz-hint'>postfinance_bereichid</span>
		 * ##FormInputType number
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy NUM 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Number
		 */
		protected $postfinance_bereichid; 

		/**
		 * @var string
		 * @Column(name="bereichsname", type="string", length=20, nullable=false) 
		 * 
		 * ##FormLabel Bereichsname 
		 * ##FormFieldHint <span class='pz-hint'>bereichsname</span>
		 * ##FormInputType text
		 * ##FormInputRequired 0 
		 * ##FormPlaceholder 0 
		 * ##FormInputOptions NULL 
		 * ##FormValidationStrategy MISC 
		 * ##FormInputEntityClass App\Poiz\HTML\Widgets\FormElements\Text
		 */
		protected $bereichsname; 



		public function __construct(){
			$this->initializeEntityBank(); 
		}


		public function getPostfinanceBereichid() {
			return $this->postfinance_bereichid;
		}

		public function getBereichsname() {
			return $this->bereichsname;
		}


		public function setPostfinanceBereichid($postfinance_bereichid) {
			$this->postfinance_bereichid = $postfinance_bereichid;
			return $this;
		}

		public function setBereichsname($bereichsname) {
			$this->bereichsname = $bereichsname;
			return $this;
		}




	} 
