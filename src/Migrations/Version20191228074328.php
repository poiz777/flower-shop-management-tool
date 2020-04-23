<?php
	
	declare( strict_types=1 );
	
	namespace DoctrineMigrations;
	
	use Doctrine\DBAL\Schema\Schema;
	use Doctrine\Migrations\AbstractMigration;
	
	/**
	 * Auto-generated Migration: Please modify to your needs!
	 */
	final class Version20191228074328 extends AbstractMigration {
		public function getDescription(): string {
			return 'Create User Table';
		}
		
		public function up( Schema $schema ): void {
			$this->addSql( "
	    
	    " );
		}
		
		public function down( Schema $schema ): void {
			// this down() migration is auto-generated, please modify it to your needs
			
		}
	}
