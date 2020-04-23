<?php
    /**
     * Created by PhpStorm.
     * User: poiz
     * Date: 18.11.19
     * Time: 20:20
     */
    
    namespace App\Poiz\Listeners;
    
    
    use App\Poiz\Entity\Issue;
    use Doctrine\ORM\Events;
    use Doctrine\Common\EventSubscriber;
    use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
    
    class EntityBakeListener {
        
        public function prePersist( LifecycleEventArgs $args ) {
            $entity        = $args->getObject();
            $entityManager = $args->getObjectManager();
            
            dump($entity);
            die;
            // perhaps you only want to act on some "Issue" entity
            if ( $entity instanceof Issue ) {
                // do something with the Product
            }
        }
    }
