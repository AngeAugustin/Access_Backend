<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250318181451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE educateur (id INT AUTO_INCREMENT NOT NULL, npi VARCHAR(20) NOT NULL, date_naissance DATETIME NOT NULL, situation_matrimoniale VARCHAR(200) NOT NULL, garant_1 VARCHAR(200) NOT NULL, adresse_garant1 VARCHAR(200) NOT NULL, garant_2 VARCHAR(200) NOT NULL, adresse_garant2 VARCHAR(200) NOT NULL, carte_identite VARCHAR(200) NOT NULL, casier_judiciaire VARCHAR(200) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE educateur');
    }
}
