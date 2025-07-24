<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250724083620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE educateur ADD dispo1_jour VARCHAR(20) DEFAULT NULL, ADD dispo2_jour VARCHAR(20) DEFAULT NULL, ADD dispo3_jour VARCHAR(20) DEFAULT NULL, ADD dispo4_jour VARCHAR(20) DEFAULT NULL, ADD dispo1_heure VARCHAR(20) DEFAULT NULL, ADD dispo2_heure VARCHAR(20) DEFAULT NULL, ADD dispo3_heure VARCHAR(20) DEFAULT NULL, ADD dispo4_heure VARCHAR(20) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE educateur DROP dispo1_jour, DROP dispo2_jour, DROP dispo3_jour, DROP dispo4_jour, DROP dispo1_heure, DROP dispo2_heure, DROP dispo3_heure, DROP dispo4_heure');
    }
}
