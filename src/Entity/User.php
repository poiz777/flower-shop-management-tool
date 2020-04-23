<?php
	/**
	 * Created by PhpStorm.
	 * User: poiz
	 * Date: 19/03/18
	 * Time: 17:34
	 */
	
	namespace App\Entity;
	
	use App\Helpers\Traits\EntityHelper;
	use Doctrine\Common\Collections\ArrayCollection;
	use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
	use Symfony\Component\Security\Core\Role\RoleHierarchy;
	use Symfony\Component\Security\Core\User\UserInterface;
	use Doctrine\ORM\Mapping as ORM;
	use Symfony\Component\Validator\Constraints as Assert;
	
	
	/**
	 * @ORM\Entity
	 * @ORM\Table(name="user")
	 * @UniqueEntity(fields={"email", "username"}, message="It looks like your
	 *                                already have an account!")
	 */
	class User implements UserInterface {
		use EntityHelper;
		/**
		 * @ORM\Id
		 * @ORM\GeneratedValue(strategy="AUTO")
		 * @ORM\Column(type="integer")
		 */
		private $id;
		
		/**
		 * @Assert\NotBlank()
		 * @Assert\Unique()
		 * @ORM\Column(type="string", name="username", unique=true)
		 */
		private $username = '';
		
		/**
		 * @Assert\NotBlank()
		 * @Assert\Email()
		 * @ORM\Column(type="string", name="email", unique=true)
		 */
		private $email = '';
		
		/**
		 * The encoded password
		 * @var string
		 *
		 * @ORM\Column(type="string", name="password")
		 */
		private $password;
		
		/**
		 * @Assert\NotBlank()
		 * @var string
		 *
		 * @ORM\Column(type="string", name="friendly_name")
		 */
		private $friendly_name = '';
		
		/**
		 * @var int
		 *
		 * @ORM\Column(type="integer", length=5, name="person_id")
		 */
		private $person_id = '';
		
		/**
		 * A non-persisted field that's used to create the encoded password.
		 * @Assert\NotBlank(groups={"Registration"})
		 *
		 * @var string
		 */
		private $plainPassword;
		
		/**
		 * @ORM\Column(type="json_array")
		 */
		private $roles = [];
		
		/**
		 * @var array;
		 */
		private $entityBank = [];
		
		
		/**
		 * @var string
		 */
		private $userNameField = 'username';
		
		// needed by the security system
		public function getUsername() {
			return ( $em = $this->{$this->userNameField} ) ? $em : 'email';
		}
		
		public function getRoles() {
			$roles = $this->roles;
			
			return $roles;
		}
		
		public function setRoles( $roles ) {
			$resRoles = [];
			if ( $roles instanceof ArrayCollection ) {
				foreach ( $roles as $role ) {
					$resRoles[] = $role->getName();
				}
			} else if ( is_array( $roles ) ) {
				foreach ( $roles as $role ) {
					$resRoles[] = $role;
				}
			}
			$this->roles = $resRoles;
		}
		
		public function getPassword() {
			return $this->password;
		}
		
		public function getSalt() {
			// leaving blank - I don't need/have a password!
		}
		
		public function eraseCredentials() {
			$this->plainPassword = null;
		}
		
		public function getEmail() {
			return $this->email;
		}
		
		public function setEmail( $email ) {
			$this->email = $email;
		}
		
		/**
		 * @return string
		 */
		public function getFriendlyName(): string {
			return $this->friendly_name;
		}
		
		/**
		 * @param string $friendly_name
		 */
		public function setFriendlyName( $friendly_name ) {
			$this->friendly_name = $friendly_name;
		}
		
		/**
		 * @return int
		 */
		public function getPersonId() {
			return $this->person_id;
		}
		
		/**
		 * @param int $person_id
		 */
		public function setPersonId( $person_id ) {
			$this->person_id = $person_id;
		}
		
		
		/**
		 * @return string
		 */
		public function getUserNameField() {
			return $this->userNameField;
		}
		
		/**
		 * @param string $userNameField
		 */
		public function setUserNameField( $userNameField ) {
			$this->userNameField = $userNameField;
		}
		
		public function setPassword( $password ) {
			$this->password = $password;
		}
		
		public function getPlainPassword() {
			return $this->plainPassword;
		}
		
		public function setPlainPassword( $plainPassword ) {
			$this->plainPassword = $plainPassword;
			// forces the object to look "dirty" to Doctrine. Avoids
			// Doctrine *not* saving this entity, if only plainPassword changes
			$this->password = null;
		}
		
		public function __toString() {
			return 'User';
		}
		
		
	}