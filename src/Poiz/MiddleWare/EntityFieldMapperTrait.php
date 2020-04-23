<?php

    namespace App\Poiz\MiddleWare;
    
    use App\Poiz\Entity\Client;
    use App\Poiz\Entity\Project;
    use Doctrine\ORM\Mapping as ORM;

    trait EntityFieldMapperTrait {

        /**
         * @var array
         */
        private $classProps = [];

        /**
         * @var array
         */
        private $entityBank = [];
    
        /**
         * @return bool
         */
        public function isDeleted() {
            return $this->deleted;
        }
    
        /**
         * @return bool
         */
        public function getDeleted() {
            return $this->deleted;
        }
    
        /**
         * @param bool $deleted
         */
        public function setDeleted($deleted) {
            $this->deleted = $deleted;
        }
    
    
        /**
         * Gibt Lesbaren Objektnamen zurück.
         * Muss von Erben überschrieben werden.
         *
         * @return string Lesbarer Objektname
         */
        public function __toString() {
            return json_encode(array_merge(['className' => get_class($this)], $this->toArray(true)));
        }

        public function toArray($addClassName=false, $bypassedFields=[]) {
            $bypassedFields = array_merge(['entityBank', 'classProps'], $bypassedFields);
            $returnArray    = $addClassName ? ['className' => get_class($this)] : [];
            foreach( get_object_vars($this) as $property=>$value){
                if($bypassedFields && in_array($property, $bypassedFields)){ continue; }
                if(!property_exists(get_class($this), $property)){ continue; }
                $prop   = new \ReflectionProperty(get_class($this), $property);
                // IF THE PROPERTY TYPE IS MULTILINGUAL-STRING JUST RETURN THE JSON DECODED VALUE
                $propType   = array_filter( explode("\n", $prop->getDocComment() ), function($val){ return stristr($val, "@var"); });
                $propType   = current(array_map(function($val){ return trim(preg_replace("#\*\s*?@var\s*#", '', $val)); }, $propType));

                if($propType === 'MultilingualString'){
                    $returnArray[$property] = json_decode($value);
                }else{
                    $get    = $this->siftGetterMethod($property);
                    if($get) { $returnArray[$property] = $this->{$get}(); }
                }
            }
            return $returnArray;
        }

        public function toShallowArray() {
            return array_merge(['className' => get_class($this)], get_object_vars($this));
        }

        public function map($arrayOrObject) {
            foreach($arrayOrObject as $property=>$value){
                $value  = is_object($value) ? $value : ( (strtolower($value) == 'true') ? true : (strtolower($value) == 'false' ? false : $value) );
                if(property_exists($this, $property)){
                    $set    = $this->siftSetterMethod($property);
                    if(is_string($set)) {
                        $this->{$set}($value);
                    }
                }
            }
            return $this;
        }

        protected function siftSetterMethod($property){
            $classMethods   = (new \ReflectionClass($this))->getMethods(\ReflectionMethod::IS_PUBLIC);
            // CYCLE THROUGH THE CLASS METHODS AND SIFT OUT THE SETTER METHOD.
            /** @var \ReflectionMethod $classMethod */
            foreach($classMethods as $classMethod){
                if( preg_match("#^set#", $classMethod->getName()) &&
                    stristr($classMethod->getName(), $property)){
                    return $classMethod->name;
                }
            }
            return false;
        }

        protected function siftGetterMethod($property){
            $classMethods   = (new \ReflectionClass($this))->getMethods(\ReflectionMethod::IS_PUBLIC);
            // CYCLE THROUGH THE CLASS METHODS AND SIFT OUT THE SETTER METHOD.
            /** @var \ReflectionMethod $classMethod */
            foreach($classMethods as $classMethod){
                $getterSansAccessor = preg_replace(["#^is#", "#^get#"], '', strtolower($classMethod->getName()));
                if( (preg_match("#^is#", $classMethod->getName()) ||
                        preg_match("#^get#", $classMethod->getName()) ) &&
                    ($getterSansAccessor === strtolower($property))){
                    return $classMethod->name;
                }
            }
            return false;
        }

        protected function siftGetSetMethod($property, $type="get"){
            // WITHOUT A FILTER EG: `\ReflectionMethod::IS_PUBLIC`, YOU'D GET STATIC METHODS AS WELL...
            $classMethods   = (new \ReflectionClass($this))->getMethods();
            // CYCLE THROUGH THE CLASS METHODS AND SIFT OUT THE SETTER METHOD.
            /** @var \ReflectionMethod $classMethod */
            foreach($classMethods as $classMethod){
                if(strtolower($type === "get")) {
                    $getterSansAccessor = preg_replace( [
                        "#^is#",
                        "#^get#"
                    ], '', strtolower( $classMethod->getName() ) );
                    if ( preg_match( "#(^is|^get)#", $classMethod->getName() ) &&
                        ( $getterSansAccessor === strtolower( $property ) ) ) {
                        if ( $classMethod->isStatic() ) {
                            return [
                                'method' => $classMethod->name,
                                'static' => true
                            ];
                        }
                        return $classMethod->name;
                    }
                }else if(strtolower($type === "set")){
                    $setterSansAccessor = preg_replace( "#^set#", '', strtolower( $classMethod->getName() ) );
                    if( preg_match("#(^set)#", $classMethod->getName()) &&
                        ( $setterSansAccessor === strtolower( $property ) ) ) {
                        if ( $classMethod->isStatic() ) {
                            return [
                                'method' => $classMethod->name,
                                'static' => true
                            ];
                        }
                        return $classMethod->name;
                    }
                }
            }
            return false;
        }

		public function __get($name) {
            try{
    
                if(property_exists($this, $name)){
                    return $this->$name;
                }else{
                    if(isset($this->entityBank) && $this->entityBank){
                        if(array_key_exists($name, $this->entityBank)){
                            return $this->entityBank[$name];
                        }
                    }
                }
            }catch(\Exception $e){
		    	return null;
            }
			return null;
		}

		public function __set($name, $value) {
			if(property_exists($this, $name)){
				$this->$name     = $value;
				if($name == 'entityBank'){
					if(!empty($value)){
						$this->autoSetClassProps($value);
					}
				}else{
					$this->entityBank[$name]	= $value;
				}
			}else{
				$this->entityBank[$name]		= $value;
			}
			return $this;
		}

		public function objectToArrayRecursive($object, &$return_array=null){
			if(!is_object($object) || empty($object)) return null;
			$return_array = (!$return_array) ? [] : $return_array;
			foreach($object as $key=>$val){
				if(is_object($val)){
					$return_array[$key] = [];
					$this->objectToArrayRecursive($val, $return_array[$key]);
				}else{
					$return_array[$key]		= $val;
				}
			}
			return $return_array;
		}

		public function arrayToObjectRecursive($array, &$objReturn=null){
			if(!is_array($array) || empty($array)) return null;
			$objReturn = (!$objReturn) ? new \stdClass() : $objReturn;
			foreach($array as $key=>$val){
				if(is_array($val)){
					$objReturn->$key = new \stdClass();
					$this->arrayToObjectRecursive($val, $objReturn->$key);
				}else{
					$objReturn->$key		= $val;
				}
			}
			return $objReturn;
		}

		public function recursiveArrayFind($key, $data){
			if(array_key_exists($key, $data)){
				return $data[$key];
			}else{
				if(is_array($data)){
					foreach($data as $k=>$value){
						if($k == $key){
							return $value;
						}else if(is_array($value)){
							return $this->recursiveArrayFind($key, $value);
						}
					}
				}
			}
			return null;
		}

		public function generateRandomHash($length = 6) {
			$characters     = '0123456789ABCDEF';
			$randomString   = '';

			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, strlen($characters) - 1)];
			}

			return $randomString;
		}
    
        public static function getClientOptions(){
            /**@var \App\Poiz\Entity\Client $client */
            /**@var \App\Poiz\Entity\Contact $clientContact */
            $eMan       = app('Doctrine\ORM\EntityManagerInterface');
            $clients    = $eMan->getRepository(Client::class)->findAll();
            $clientOpts = [];
        
            foreach($clients as $client){
                $clientContact = current($client->getContacts());
            #   $clientOpts[$clientContact->getId()]   = $clientContact->getFullName();
                $clientOpts[$clientContact->getId()]   = $clientContact->getCompanyName()   . " -- [ " .
                                                         $clientContact->getFullName()      . " ]" ;
            }
            if($clientOpts){
                uasort($clientOpts, function($prev, $next){
                    return $prev > $next;
                });
            }
        
            return ['' => 'Please Choose Owner/Client'] + $clientOpts;
        }
    
        public static function getProjectsOptions(){
            /**@var \App\Poiz\Entity\Project $project */
            /**@var \App\Poiz\Entity\Contact $projectContact */
            $eMan           = app('Doctrine\ORM\EntityManagerInterface');
            $projects       = $eMan->getRepository(Project::class)->findAll();
            $projectsOpts   = [];
        
            foreach($projects as $project){
                $projectsOpts[$project->getId()]   = $project->getProjectTitle()   . " -- [ " .
                                                     $project->getId()      . " ]" ;
            }
            uasort($projectsOpts, function($prev, $next){
                return $prev > $next;
            });
        
            return ['' => 'Please Choose Project to associate this Issue with.'] + $projectsOpts;
        }
    
        public static function getToggleSwitchOptions(){
            return [
                0 => 'No',
                1 => 'Yes',
            ];
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
                $arrayClone = isset($arrayClone[$part]) ? $arrayClone[$part] : false;
            }
            return $arrayClone;
        }
    }
