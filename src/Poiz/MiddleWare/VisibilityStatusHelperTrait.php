<?php

    namespace App\Poiz\MiddleWare;

    use Neos\Flow\Persistence\QueryInterface;

    /**
     * Trait VisibilityStatusHelperTrait
     * @package App\Poiz\MiddleWare
     *
     * THIS TRAIT EXPOSES SOME "NICE-TO HAVE" REPOSITORY METHODS FOR ENTITIES / MODELS
     * THAT CONTAIN VISIBILITY & STATUS RELATED FIELDS SUCH AS `hidden` AND `deleted`
     * WHY TRAIT? OBVIOUSLY, TO AVOID TIGHT COUPLING THAT WOULD BE INTRODUCED BY
     * ADOPTING INHERITANCE...
     */
    trait VisibilityStatusHelperTrait{

        public static $DEFAULT_SORT_FIELD   = 'bezeichnung';

        /**
         * FETCHES ONLY NONE-DELETED ENTRIES...
         * @return \Neos\Flow\Persistence\QueryResultInterface
         */
        public function fetchNoneDeletedEntries(){
            $query      = $this->createQuery();
            return $query->matching(
                $query->logicalAnd( $query->equals('deleted', 0) )
            )   ->setOrderings([static::$DEFAULT_SORT_FIELD => QueryInterface::ORDER_ASCENDING] )
                ->execute();
        }

        /**
         * FETCHES ONLY NONE-HIDDEN ENTRIES...
         * @return \Neos\Flow\Persistence\QueryResultInterface
         */
        public function fetchNoneHiddenEntries(){
            $query      = $this->createQuery();
            return $query->matching(
                $query->logicalAnd( $query->equals('hidden', 0) )
            )   ->setOrderings([static::$DEFAULT_SORT_FIELD => QueryInterface::ORDER_ASCENDING] )
                ->execute();
        }

        /**
         * nur Mischungen ausgeben
         */
        public function getMischungen() {
          $query = $this->createQuery();
          $resultate = $query->matching(
            $query->logicalAnd(
              $query->equals('deleted', 0),
              $query->greaterThan('gruppe.mischung', 0)
            )
          )
            ->setOrderings(['bezeichnung' => QueryInterface::ORDER_ASCENDING]
            )
            ->execute();
          return $resultate;
        }

        /**
         * Datensatz mit dieser SID holen
         *
         * @param integer $sid SID
         * @param Sorte $gruppe Gruppe
         */
        public function findBySid($sid, $gruppe) {
          $resultate = null;
          if ($sid && !is_null($gruppe)) {
            $query = $this->createQuery();
            $resultate = $query->matching(
              $query->logicalAnd(
                $query->equals('deleted', 0),
                $query->equals('sid', $sid),
                $query->equals('gruppe', $gruppe)
              )
            )
              ->execute();
          }
          return $resultate;
        }

        /**
         * maximale ID für SID innerhalb der Gruppe ermitteln
         *
         * @param Sorte $gruppe Gruppe
         * @return integer höchste numerische SID der Gruppe
         */
        public function getMaxSid($gruppe) {
          $maxsid = 0;
          $resultate = null;
          $query = $this->createQuery();
          $resultate = $query->matching(
            $query->logicalAnd(
              $query->equals('deleted', 0), $query->equals('gruppe', $gruppe)
            )
          )
            ->execute();
          foreach ($resultate as $resultat) {
            $sid = $resultat->getSid();
            if (!is_numeric($sid)) $sid = 0;
            if ($sid > $maxsid) $maxsid = $sid;
          }
          return $maxsid;
        }

    }