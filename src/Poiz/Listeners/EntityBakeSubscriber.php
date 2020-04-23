<?php
    /**
     * Created by PhpStorm.
     * User: poiz
     * Date: 18.11.19
     * Time: 20:20
     */
    
    namespace App\Poiz\Listeners;
    
    
    use App\Poiz\Entity\Issue;
    use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
    use Doctrine\ORM\Event\PreFlushEventArgs;
    use Doctrine\ORM\Events;
    use Doctrine\Common\EventSubscriber;
    use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

    class EntityBakeSubscriber implements EventSubscriber{
        
        public function getSubscribedEvents() {
            return [
                // Events::postUpdate,
                Events::prePersist,
                Events::preUpdate,
                Events::preFlush,
                Events::loadClassMetadata,
            ];
        }
        
        public function loadClassMetadata(LoadClassMetadataEventArgs $classMetadata) {
            // dump($classMetadata->getClassMetadata()->fieldMappings);
            // perhaps you only want to act on some "Product" entity
            if ($classMetadata->getClassMetadata() ) {
            }
        }
        
        public function prePersist( LifecycleEventArgs $args ) {
            $entityManager = $args->getObjectManager();
            $entity        = $args->getObject();
            
            // perhaps you only want to act on some "Product" entity
            if ( $entity instanceof Issue ) {
                // TODO -- EITHER BUILD UP THE GENERATED FIELDS OR BYPASS THEM ALTOGETHER
                // do something with the Product
                // dump($entity);
            }
        }
        
        public function preUpdate( LifecycleEventArgs $args ) {
            $entityManager = $args->getObjectManager();
            $entity        = $args->getObject();
            
            // perhaps you only want to act on some "Product" entity
            if ( $entity instanceof Issue ) {
                // TODO -- EITHER BUILD UP THE GENERATED FIELDS OR BYPASS THEM ALTOGETHER
                // do something with the Product
                // dump($entity);
            }
        }
        
        public function preFlush( PreFlushEventArgs $args ) {
            $em = $args->getEntityManager();
        }
    }
