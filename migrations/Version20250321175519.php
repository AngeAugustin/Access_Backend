<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250321175519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tutorat (reference_tutorat VARCHAR(20) NOT NULL, npi_parent VARCHAR(20) DEFAULT NULL, npi_educateur VARCHAR(20) DEFAULT NULL, npi_enfant VARCHAR(20) DEFAULT NULL, duree_tutorat VARCHAR(255) DEFAULT NULL, seance1 VARCHAR(200) DEFAULT NULL, seance2 VARCHAR(200) DEFAULT NULL, PRIMARY KEY(reference_tutorat)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE tutorat');
    }
}
