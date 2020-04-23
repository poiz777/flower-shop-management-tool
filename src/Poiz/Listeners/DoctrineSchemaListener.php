<?php
    /**
     * Created by PhpStorm.
     * User: poiz
     * Date: 18.11.19
     * Time: 20:03
     */
    
    namespace App\Poiz\Listeners;


    use Doctrine\Common\EventSubscriber;
    use Doctrine\DBAL\Event\SchemaColumnDefinitionEventArgs;
    use Doctrine\DBAL\Event\SchemaIndexDefinitionEventArgs;
    use Doctrine\DBAL\Events;

    /**
     * The orders.generated_zip column and orders.index_zip index have been created
     * with a manually crafted migration as Doctrine does not support generated
     * columns. This listener prevents migrations from wanting to remove the field
     * and index.
     */
    class DoctrineSchemaListener implements EventSubscriber
    {
        public function onSchemaColumnDefinition(SchemaColumnDefinitionEventArgs $eventArgs)
        {
            if ('orders' === $eventArgs->getTable()) {
                if ('generated_zip' === $eventArgs->getTableColumn()['Field']) {
                    $eventArgs->preventDefault();
                }
            }
        }
    
        public function onSchemaIndexDefinition(SchemaIndexDefinitionEventArgs $eventArgs)
        {
            if ('orders' === $eventArgs->getTable()
                && 'index_zip' === $eventArgs->getTableIndex()['name']
            ) {
                $eventArgs->preventDefault();
            }
        }
    
        /**
         * Returns an array of events this subscriber wants to listen to.
         *
         * @return string[]
         */
        public function getSubscribedEvents()
        {
            return [
                Events::onSchemaColumnDefinition,
                Events::onSchemaIndexDefinition,
            ];
        }
    }
