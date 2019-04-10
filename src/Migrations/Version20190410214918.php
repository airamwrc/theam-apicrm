<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190410214918 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer ADD creator_id INT NOT NULL, ADD last_editor_id INT DEFAULT NULL, CHANGE created created DATETIME NOT NULL, CHANGE updated updated DATETIME NOT NULL');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E0961220EA6 FOREIGN KEY (creator_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E097E5A734A FOREIGN KEY (last_editor_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_81398E0961220EA6 ON customer (creator_id)');
        $this->addSql('CREATE INDEX IDX_81398E097E5A734A ON customer (last_editor_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E0961220EA6');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E097E5A734A');
        $this->addSql('DROP INDEX IDX_81398E0961220EA6 ON customer');
        $this->addSql('DROP INDEX IDX_81398E097E5A734A ON customer');
        $this->addSql('ALTER TABLE customer DROP creator_id, DROP last_editor_id, CHANGE created created DATETIME DEFAULT \'1970-01-01 00:00:00\' NOT NULL, CHANGE updated updated DATETIME DEFAULT \'1970-01-01 00:00:00\' NOT NULL');
    }
}
