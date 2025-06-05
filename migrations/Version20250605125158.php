<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250605125158 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY fk_reference_tutorat');
        $this->addSql('DROP INDEX fk_reference_tutorat ON paiement');
        $this->addSql('ALTER TABLE paiement_parent ADD id_transaction VARCHAR(200) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT fk_reference_tutorat FOREIGN KEY (reference_tutorat) REFERENCES tutorat (reference_tutorat) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE INDEX fk_reference_tutorat ON paiement (reference_tutorat)');
        $this->addSql('ALTER TABLE paiement_parent DROP id_transaction');
    }
}
