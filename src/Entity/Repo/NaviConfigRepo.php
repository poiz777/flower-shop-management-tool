<?php 

	namespace  App\Entity\Repo;

	use Doctrine\ORM\EntityRepository;
	use Doctrine\ORM\EntityManagerInterface;

	use Doctrine\ORM\Mapping\ClassMetadata;

	/**
	 * NaviConfigRepo
	 * Repository Class automatically generated by Poiz Doctrine Mediator.
	 * You may add additional Methods to your Repository as well...
	 **/
	class NaviConfigRepo extends EntityRepository { 


		/**
		 * @var EntityManagerInterface
		 */
		protected $eMan;



		public function __construct(EntityManagerInterface $em, ClassMetadata $class){
			parent::__construct($em, $class); 
			$this->eMan			= $em; 

		}


		public function findUnique($config=[], $ordering=[]){
			//todo
		}



	}
