<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190412142424 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fos_user ADD name VARCHAR(255) DEFAULT NULL, ADD surname VARCHAR(255) DEFAULT NULL, CHANGE created created DATETIME NOT NULL, CHANGE updated updated DATETIME NOT NULL, CHANGE deleted deleted TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE customer ADD identification_number VARCHAR(20) DEFAULT NULL, ADD address VARCHAR(255) DEFAULT NULL, ADD business_name VARCHAR(255) DEFAULT NULL, ADD phone VARCHAR(22) DEFAULT NULL, ADD phone2 VARCHAR(22) DEFAULT NULL, ADD contact_name VARCHAR(255) DEFAULT NULL, ADD trade_name VARCHAR(255) DEFAULT NULL, ADD notes LONGTEXT DEFAULT NULL, CHANGE last_editor_id last_editor_id INT NOT NULL, CHANGE deleted deleted TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer DROP identification_number, DROP address, DROP business_name, DROP phone, DROP phone2, DROP contact_name, DROP trade_name, DROP notes, CHANGE last_editor_id last_editor_id INT DEFAULT NULL, CHANGE deleted deleted TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE fos_user DROP name, DROP surname, CHANGE created created DATETIME DEFAULT \'1970-01-01 00:00:00\' NOT NULL, CHANGE updated updated DATETIME DEFAULT \'1970-01-01 00:00:00\' NOT NULL, CHANGE deleted deleted TINYINT(1) DEFAULT \'0\' NOT NULL');
    }
}
