<?php
    
    
    namespace App\Poiz\Worker;
    
    
    class RaySenAl implements \Countable, \ArrayAccess, \Iterator {
        private $bank;
        private $flatBank;
        private $position = 0;
        private static $instances = [];
    
        /**
         * RaySenAl constructor.
         *
         * @param $bank
         */
        private function __construct( $bank = []) {
            $this->bank     = $bank;
            $this->flatBank = array_values($bank);
            $this->position = 0;
        }
    
    
        public function offsetExists( $offset ) {
            return isset($this->bank[$offset]);
        }
    
        public function offsetGet( $offset ) {
           if (isset($this->bank[$offset])) {
               return $this->bank[$offset];
           } else {
               throw new \Exception("Offset {$offset} does not exist");
           }
        }
    
        public function offsetSet( $offset, $value ) {
            $this->bank[$offset]    = $value;
            $this->flatBank[]       = $value;
        }
    
        public function offsetUnset( $offset ) {
            if (isset($this->bank[$offset])) {
                unset($this->bank[$offset]);
            }
        }
    
        public function count() {
            return sizeof($this->bank);
        }
    
        public function current() {
            // TODO: Implement current() method.
            return $this->flatBank[$this->position];
        }
    
        public function next() {
            ++$this->position;
        }
    
        public function key() {
            return $this->position;
        }
    
        public function valid() {
            return isset($this->flatBank[$this->position]);
        }
    
        public function rewind() {
            --$this->position;
            $this->position = $this->position < 0 ? 0 : $this->position;
        }
    
        /**
         * @param $val
         *
         * @return array
         */
        public function findByValue($val) {
            return self::findInArrayRecursive($this->bank, $val);
        }
    
        /**
         * @param string $dotPath
         *
         * @return array
         */
        public function dotFind($dotPath="") {
            return self::fetchDataFromArrayDotSyntax($this->bank, $dotPath);
        }
    
    
        public function dotSet($data, $dotPath="") {
            return self::setDataOnArrayKeyDotSyntax($this->bank, $data, $dotPath);
        }
    
    
        public static function findInArrayRecursive($array, $val, &$rayKeyMap=[], &$rayReturns=[]){
            $returnData =  [];
            foreach ($array as $key=>$value){
                if(is_array($value)){
                    $rayKeyMap[] = $key;
                    return static::findInArrayRecursive($value, $val, $rayKeyMap, $rayReturns);
                }
                if($val == $value){
                    $rayKeyMap[]  = $key;
                    $rayReturns[] = $rayKeyMap;
                    array_pop($rayKeyMap);
                }
            }
            if($rayReturns){
                $returnData =  [];
                foreach($rayReturns as $iKey=>$rayKeys){
                    $returnData[] = implode(".", $rayKeys);
                }
            }
            return $returnData;
        }
    
        public static function fetchDataFromArrayDotSyntax($array, $dotPath=""){
            if(!$dotPath) return $array;
            $parts      = explode(".", $dotPath);
            $arrayClone = $array;
            foreach($parts as $iKey=>$part){
                try{
                    if(is_object($arrayClone)){
                        $arrayClone  = $arrayClone->{$part};
                    }else{
                        $arrayClone = isset($arrayClone[$part]) ? $arrayClone[$part] : false;
                    }
                }catch (\Exception $e){
                    $arrayClone =  $arrayClone->{$part};
                }
            }
            return $arrayClone;
        }
    
        public static function setDataOnArrayKeyDotSyntax(&$array, $data, $dotPath=""){
            if(!$dotPath || !$array) return false;
            $parts      = explode(".", $dotPath);
            foreach ($parts as $iKey=>$part){
                if(isset($array[$part])){
                
                }
            }
        }
    
        public static function setDataOnArrayKeyDotSyntax2(&$array, $data, $dotPath=""){
            if(!$dotPath) return $array;
            $parts      = explode(".", $dotPath);
            $arrayClone = $array;
            foreach($parts as $iKey=>$part){
                $isLast = $iKey == (count($parts) - 1);
                if(array_key_exists($part, $array)){
                    if(is_array($array[$part])){
                        $dotPath = implode(".", array_slice($parts, $iKey+1));
                        return self::setDataOnArrayKeyDotSyntax($array[$part], $data, $dotPath);
                    }else{
                        $array[$part] = $data;
                    }
                }
                $array[$part] = $data;
            }
            return $arrayClone;
        }
        
        public static function make($bank){
            $bankKey    = md5(serialize($bank));
            $newSelf    = new self($bank);
            static::$instances[$bankKey] = &$newSelf;
            return static::$instances[$bankKey];
        }
        
        public static function getInstances(){
            return static::$instances;
        }
        
        public static function deleteInstance($bank){
            $bankKey    = md5(serialize($bank));
            unset(static::$instances[$bankKey]);
            return static::$instances;
        }
    }
