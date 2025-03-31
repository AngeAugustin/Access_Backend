<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250331175247 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE educateur CHANGE carte_identite carte_identite LONGBLOB DEFAULT NULL, CHANGE casier_judiciaire casier_judiciaire LONGBLOB DEFAULT NULL, CHANGE photo_educateur photo_educateur LONGBLOB DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE educateur CHANGE carte_identite carte_identite VARCHAR(200) DEFAULT NULL, CHANGE casier_judiciaire casier_judiciaire VARCHAR(200) DEFAULT NULL, CHANGE photo_educateur photo_educateur VARCHAR(200) DEFAULT NULL');
    }
}
