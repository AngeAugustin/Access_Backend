<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250526093136 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tarif ADD classe_actuelle VARCHAR(200) DEFAULT NULL, ADD tarif_horaire INT DEFAULT NULL, ADD nbre_seances_semaine INT DEFAULT NULL, ADD nbre_heure_seance INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tarif DROP classe_actuelle, DROP tarif_horaire, DROP nbre_seances_semaine, DROP nbre_heure_seance');
    }
}
