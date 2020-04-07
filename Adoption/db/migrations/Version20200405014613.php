<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200405014613 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE transfer (id UUID NOT NULL, pet_id UUID NOT NULL, offer_id UUID NOT NULL, adopter_id UUID NOT NULL, completed BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4034A3C0966F7FB6 ON transfer (pet_id)');
        $this->addSql('COMMENT ON COLUMN transfer.id IS \'(DC2Type:TransferId)\'');
        $this->addSql('COMMENT ON COLUMN transfer.pet_id IS \'(DC2Type:PetId)\'');
        $this->addSql('COMMENT ON COLUMN transfer.offer_id IS \'(DC2Type:OfferId)\'');
        $this->addSql('COMMENT ON COLUMN transfer.adopter_id IS \'(DC2Type:AdopterId)\'');
        $this->addSql('ALTER TABLE transfer ADD CONSTRAINT FK_4034A3C0966F7FB6 FOREIGN KEY (pet_id) REFERENCES pet (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE adopter ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE adopter ALTER name DROP DEFAULT');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE transfer');
        $this->addSql('ALTER TABLE adopter ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE adopter ALTER name DROP DEFAULT');
    }
}
