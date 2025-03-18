<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250318202701 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE educateur CHANGE date_naissance date_naissance DATETIME DEFAULT NULL, CHANGE situation_matrimoniale situation_matrimoniale VARCHAR(200) DEFAULT NULL, CHANGE garant_1 garant_1 VARCHAR(200) DEFAULT NULL, CHANGE adresse_garant1 adresse_garant1 VARCHAR(200) DEFAULT NULL, CHANGE garant_2 garant_2 VARCHAR(200) DEFAULT NULL, CHANGE adresse_garant2 adresse_garant2 VARCHAR(200) DEFAULT NULL, CHANGE carte_identite carte_identite VARCHAR(200) DEFAULT NULL, CHANGE casier_judiciaire casier_judiciaire VARCHAR(200) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE educateur CHANGE date_naissance date_naissance DATETIME NOT NULL, CHANGE situation_matrimoniale situation_matrimoniale VARCHAR(200) NOT NULL, CHANGE garant_1 garant_1 VARCHAR(200) NOT NULL, CHANGE adresse_garant1 adresse_garant1 VARCHAR(200) NOT NULL, CHANGE garant_2 garant_2 VARCHAR(200) NOT NULL, CHANGE adresse_garant2 adresse_garant2 VARCHAR(200) NOT NULL, CHANGE carte_identite carte_identite VARCHAR(200) NOT NULL, CHANGE casier_judiciaire casier_judiciaire VARCHAR(200) NOT NULL');
    }
}
