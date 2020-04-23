<?php
    /**
     * Created by PhpStorm.
     * User: poiz
     * Date: 21.07.19
     * Time: 13:00
     */
    
    namespace App\Poiz\MiddleWare;

    use Doctrine\ORM\EntityManager;

    class E_MAN {
        /**
         * @var EntityManager
         */
        protected static $entityManager;
    
        /**
         * @return mixed
         */
        public static function getEntityManager() {
            return self::$entityManager;
        }
    
        /**
         * @param EntityManager $entityManager
         */
        public static function setEntityManager(EntityManager $entityManager) {
            self::$entityManager = $entityManager;
        }
    }
