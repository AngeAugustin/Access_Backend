<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250601174004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paiement_admin (id_paiement VARCHAR(20) NOT NULL, montant_paiement VARCHAR(200) DEFAULT NULL, date_paiement VARCHAR(200) DEFAULT NULL, statut_paiement VARCHAR(200) DEFAULT NULL, npi_agent VARCHAR(20) DEFAULT NULL, nom_agent VARCHAR(200) DEFAULT NULL, prenom_agent VARCHAR(200) DEFAULT NULL, role_agent VARCHAR(200) DEFAULT NULL, PRIMARY KEY(id_paiement)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE paiement_admin');
    }
}
