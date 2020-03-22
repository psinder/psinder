<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200322180954 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE pet (id UUID NOT NULL, name VARCHAR(255) NOT NULL, birthdate DATE NOT NULL, sex VARCHAR(255) NOT NULL, breed_type VARCHAR(255) NOT NULL, breed_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN pet.id IS \'(DC2Type:PetId)\'');
        $this->addSql('COMMENT ON COLUMN pet.name IS \'(DC2Type:PetName)\'');
        $this->addSql('COMMENT ON COLUMN pet.birthdate IS \'(DC2Type:Birthdate)\'');
        $this->addSql('COMMENT ON COLUMN pet.sex IS \'(DC2Type:PetSex)\'');
        $this->addSql('COMMENT ON COLUMN pet.breed_type IS \'(DC2Type:PetType)\'');
        $this->addSql('CREATE TABLE shelter (id UUID NOT NULL, name VARCHAR(255) NOT NULL, contact_forms JSON NOT NULL, address_street VARCHAR(255) NOT NULL, address_number VARCHAR(255) NOT NULL, address_postalCode VARCHAR(255) NOT NULL, address_city VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN shelter.id IS \'(DC2Type:ShelterId)\'');
        $this->addSql('COMMENT ON COLUMN shelter.name IS \'(DC2Type:ShelterName)\'');
        $this->addSql('COMMENT ON COLUMN shelter.contact_forms IS \'(DC2Type:ContactForms)\'');
        $this->addSql('CREATE TABLE offer_application (id UUID NOT NULL, offer_id UUID DEFAULT NULL, adopter_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_257961CF53C674EE ON offer_application (offer_id)');
        $this->addSql('COMMENT ON COLUMN offer_application.id IS \'(DC2Type:ApplicationId)\'');
        $this->addSql('COMMENT ON COLUMN offer_application.offer_id IS \'(DC2Type:OfferId)\'');
        $this->addSql('COMMENT ON COLUMN offer_application.adopter_id IS \'(DC2Type:AdopterId)\'');
        $this->addSql('CREATE TABLE adopter (id UUID NOT NULL, name VARCHAR(255) NOT NULL, contact_forms JSON NOT NULL, birthdate DATE NOT NULL, gender VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN adopter.id IS \'(DC2Type:AdopterId)\'');
        $this->addSql('COMMENT ON COLUMN adopter.contact_forms IS \'(DC2Type:ContactForms)\'');
        $this->addSql('COMMENT ON COLUMN adopter.birthdate IS \'(DC2Type:Birthdate)\'');
        $this->addSql('COMMENT ON COLUMN adopter.gender IS \'(DC2Type:Gender)\'');
        $this->addSql('CREATE TABLE adopter_pet (adopter_id UUID NOT NULL, pet_id UUID NOT NULL, PRIMARY KEY(adopter_id, pet_id))');
        $this->addSql('CREATE INDEX IDX_462A07E6A0D47673 ON adopter_pet (adopter_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_462A07E6966F7FB6 ON adopter_pet (pet_id)');
        $this->addSql('COMMENT ON COLUMN adopter_pet.adopter_id IS \'(DC2Type:AdopterId)\'');
        $this->addSql('COMMENT ON COLUMN adopter_pet.pet_id IS \'(DC2Type:PetId)\'');
        $this->addSql('CREATE TABLE offer (id UUID NOT NULL, pet_id UUID NOT NULL, shelter_id UUID NOT NULL, is_open BOOLEAN NOT NULL, selected_adopter_id UUID DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_29D6873E966F7FB6 ON offer (pet_id)');
        $this->addSql('COMMENT ON COLUMN offer.id IS \'(DC2Type:OfferId)\'');
        $this->addSql('COMMENT ON COLUMN offer.pet_id IS \'(DC2Type:PetId)\'');
        $this->addSql('COMMENT ON COLUMN offer.shelter_id IS \'(DC2Type:ShelterId)\'');
        $this->addSql('COMMENT ON COLUMN offer.selected_adopter_id IS \'(DC2Type:AdopterId)\'');
        $this->addSql('ALTER TABLE offer_application ADD CONSTRAINT FK_257961CF53C674EE FOREIGN KEY (offer_id) REFERENCES offer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE adopter_pet ADD CONSTRAINT FK_462A07E6A0D47673 FOREIGN KEY (adopter_id) REFERENCES adopter (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE adopter_pet ADD CONSTRAINT FK_462A07E6966F7FB6 FOREIGN KEY (pet_id) REFERENCES pet (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873E966F7FB6 FOREIGN KEY (pet_id) REFERENCES pet (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE adopter_pet DROP CONSTRAINT FK_462A07E6966F7FB6');
        $this->addSql('ALTER TABLE offer DROP CONSTRAINT FK_29D6873E966F7FB6');
        $this->addSql('ALTER TABLE adopter_pet DROP CONSTRAINT FK_462A07E6A0D47673');
        $this->addSql('ALTER TABLE offer_application DROP CONSTRAINT FK_257961CF53C674EE');
        $this->addSql('DROP TABLE pet');
        $this->addSql('DROP TABLE shelter');
        $this->addSql('DROP TABLE offer_application');
        $this->addSql('DROP TABLE adopter');
        $this->addSql('DROP TABLE adopter_pet');
        $this->addSql('DROP TABLE offer');
    }
}
