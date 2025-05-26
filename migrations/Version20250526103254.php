<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250526103254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paiement (id_paiement INT NOT NULL, reference_tutorat VARCHAR(20) DEFAULT NULL, npi_parent VARCHAR(20) DEFAULT NULL, npi_educateur VARCHAR(20) DEFAULT NULL, npi_agent VARCHAR(20) DEFAULT NULL, duree_tutorat INT DEFAULT NULL, nbre_paiements INT DEFAULT NULL, classe_actuelle VARCHAR(200) DEFAULT NULL, montant_paiement1 INT DEFAULT NULL, statut_paiement1 VARCHAR(200) DEFAULT NULL, montant_paiement2 INT DEFAULT NULL, statut_paiement2 VARCHAR(200) DEFAULT NULL, date_paiement1 DATETIME DEFAULT NULL, date_paiement2 DATETIME DEFAULT NULL, montant_paiement3 INT DEFAULT NULL, statut_paiement3 VARCHAR(200) DEFAULT NULL, date_paiement3 DATETIME DEFAULT NULL, PRIMARY KEY(id_paiement)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE paiement');
    }
}
