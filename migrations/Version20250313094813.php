<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250313094813 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE enfant (npi_enfant VARCHAR(20) NOT NULL, nom_enfant VARCHAR(200) NOT NULL, prenom_enfant VARCHAR(200) NOT NULL, date_naissance DATETIME NOT NULL, sexe_enfant VARCHAR(5) NOT NULL, classe_precedente VARCHAR(20) NOT NULL, ecole_precedente VARCHAR(20) NOT NULL, classe_actuelle VARCHAR(200) NOT NULL, ecole_actuelle VARCHAR(200) DEFAULT NULL, parent_tuteur VARCHAR(200) NOT NULL, matieres_preferes VARCHAR(240) DEFAULT NULL, centre_interet VARCHAR(245) DEFAULT NULL, niveau_francais VARCHAR(200) DEFAULT NULL, niveau_anglais VARCHAR(200) DEFAULT NULL, niveau_philosophie VARCHAR(200) DEFAULT NULL, niveau_mathematique VARCHAR(200) DEFAULT NULL, niveau_svt VARCHAR(200) DEFAULT NULL, niveau_pct VARCHAR(200) DEFAULT NULL, niveau_histgeo VARCHAR(200) DEFAULT NULL, niveau_allemand VARCHAR(200) DEFAULT NULL, niveau_espagnol VARCHAR(200) DEFAULT NULL, npi VARCHAR(20) NOT NULL, PRIMARY KEY(npi_enfant)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE enfant');
    }
}
