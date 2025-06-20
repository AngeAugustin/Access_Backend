<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250620091401 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enfant ADD niveau_economie VARCHAR(200) DEFAULT NULL, ADD niveau_comptabilite VARCHAR(200) DEFAULT NULL, ADD niveau_comptagenerale VARCHAR(200) DEFAULT NULL, ADD niveau_comptaanalytique VARCHAR(200) DEFAULT NULL, ADD niveau_comptasociete VARCHAR(200) DEFAULT NULL, ADD niveau_comptausuelle VARCHAR(200) DEFAULT NULL, ADD niveau_ta VARCHAR(200) DEFAULT NULL, ADD niveau_mathsfinanciere VARCHAR(200) DEFAULT NULL, ADD niveau_droit VARCHAR(200) DEFAULT NULL, ADD niveau_mathsgenerale VARCHAR(200) DEFAULT NULL, ADD niveau_fiscalite VARCHAR(200) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enfant DROP niveau_economie, DROP niveau_comptabilite, DROP niveau_comptagenerale, DROP niveau_comptaanalytique, DROP niveau_comptasociete, DROP niveau_comptausuelle, DROP niveau_ta, DROP niveau_mathsfinanciere, DROP niveau_droit, DROP niveau_mathsgenerale, DROP niveau_fiscalite');
    }
}
