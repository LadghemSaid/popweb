<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200327162320 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE mailling_list (id INT AUTO_INCREMENT NOT NULL, mail VARCHAR(255) NOT NULL, contact_mail TINYINT(1) DEFAULT NULL, newsletter_mail TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project ADD img_alternate VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE article ADD img_alternate VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE job ADD img_alternate VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE mailling_list');
        $this->addSql('ALTER TABLE article DROP img_alternate');
        $this->addSql('ALTER TABLE job DROP img_alternate');
        $this->addSql('ALTER TABLE project DROP img_alternate');
    }
}
