<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20200308100351_adopter_with_pets extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE adopter (id UUID NOT NULL, name VARCHAR(255) NOT NULL, contactForms JSON NOT NULL, birthdate DATE NOT NULL, gender VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN adopter.id IS \'(DC2Type:AdopterId)\'');
        $this->addSql('COMMENT ON COLUMN adopter.contactForms IS \'(DC2Type:ContactForms)\'');
        $this->addSql('COMMENT ON COLUMN adopter.birthdate IS \'(DC2Type:Birthdate)\'');
        $this->addSql('COMMENT ON COLUMN adopter.gender IS \'(DC2Type:Gender)\'');
        $this->addSql('CREATE TABLE adopters_pets (adopter_id UUID NOT NULL, pet_id UUID NOT NULL, PRIMARY KEY(adopter_id, pet_id))');
        $this->addSql('CREATE INDEX IDX_1C1A1A1AA0D47673 ON adopters_pets (adopter_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1C1A1A1A966F7FB6 ON adopters_pets (pet_id)');
        $this->addSql('COMMENT ON COLUMN adopters_pets.adopter_id IS \'(DC2Type:AdopterId)\'');
        $this->addSql('COMMENT ON COLUMN adopters_pets.pet_id IS \'(DC2Type:PetId)\'');
        $this->addSql('ALTER TABLE adopters_pets ADD CONSTRAINT FK_1C1A1A1AA0D47673 FOREIGN KEY (adopter_id) REFERENCES adopter (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE adopters_pets ADD CONSTRAINT FK_1C1A1A1A966F7FB6 FOREIGN KEY (pet_id) REFERENCES pet (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE adopters_pets DROP CONSTRAINT FK_1C1A1A1AA0D47673');
        $this->addSql('DROP TABLE adopter');
        $this->addSql('DROP TABLE adopters_pets');
    }
}
