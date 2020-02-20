<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20181225_shelter_pet_offer extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE pet (id UUID NOT NULL, name VARCHAR(255) NOT NULL, birthdate DATE NOT NULL, sex VARCHAR(255) NOT NULL, breed_type VARCHAR(255) NOT NULL, breed_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN pet.id IS \'(DC2Type:PetId)\'');
        $this->addSql('COMMENT ON COLUMN pet.name IS \'(DC2Type:PetName)\'');
        $this->addSql('COMMENT ON COLUMN pet.birthdate IS \'(DC2Type:Birthdate)\'');
        $this->addSql('COMMENT ON COLUMN pet.sex IS \'(DC2Type:PetSex)\'');
        $this->addSql('COMMENT ON COLUMN pet.breed_type IS \'(DC2Type:PetType)\'');
        $this->addSql('CREATE TABLE shelter (id UUID NOT NULL, name VARCHAR(255) NOT NULL, contactForms JSON NOT NULL, address_street VARCHAR(255) NOT NULL, address_number VARCHAR(255) NOT NULL, address_postalCode VARCHAR(255) NOT NULL, address_city VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN shelter.id IS \'(DC2Type:ShelterId)\'');
        $this->addSql('COMMENT ON COLUMN shelter.name IS \'(DC2Type:ShelterName)\'');
        $this->addSql('COMMENT ON COLUMN shelter.contactForms IS \'(DC2Type:ContactForms)\'');
        $this->addSql('CREATE TABLE offer (id UUID NOT NULL, pet_id UUID NOT NULL, shelterId UUID NOT NULL, applications JSON NOT NULL, isOpen BOOLEAN NOT NULL, selectedAdopter UUID DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_29D6873E966F7FB6 ON offer (pet_id)');
        $this->addSql('COMMENT ON COLUMN offer.id IS \'(DC2Type:OfferId)\'');
        $this->addSql('COMMENT ON COLUMN offer.pet_id IS \'(DC2Type:PetId)\'');
        $this->addSql('COMMENT ON COLUMN offer.shelterId IS \'(DC2Type:ShelterId)\'');
        $this->addSql('COMMENT ON COLUMN offer.applications IS \'(DC2Type:OfferApplications)\'');
        $this->addSql('COMMENT ON COLUMN offer.selectedAdopter IS \'(DC2Type:AdopterId)\'');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873E966F7FB6 FOREIGN KEY (pet_id) REFERENCES pet (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE offer DROP CONSTRAINT FK_29D6873E966F7FB6');
        $this->addSql('DROP TABLE pet');
        $this->addSql('DROP TABLE shelter');
        $this->addSql('DROP TABLE offer');
    }
}
