<?php
	
	
	namespace App\Poiz\Statics;
	
	
	use Symfony\Component\Security\Core\User\UserInterface;
	
	class ACLManager {
		public static $roleToActionMapper = [
			'ROLE_SUPER_ADMIN'  => [
				'READ_KNOWLEDGE_BASE',
			],
			'ROLE_ADMIN'  => [
				'READ_KNOWLEDGE_BASE',
			
			],
			'ROLE_WORKER'  => [
				'READ_KNOWLEDGE_BASE',
			
			],
			'ROLE_SPECIAL_GUEST'  => [
				'READ_KNOWLEDGE_BASE',
			
			],
			'ROLE_GUEST'  => [
				'READ_KNOWLEDGE_BASE',
			],
		];
		
		public static function canUser($performableAction, UserInterface $user){
			$userRoles = $user->getRoles();
			if($userRoles){
				foreach($userRoles as $userRole){
					if(in_array($performableAction, static::$roleToActionMapper[$userRole])){
						return true;
					}
				}
			}
			return false;
		}
	}