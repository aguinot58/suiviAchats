<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220624134211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE FULLTEXT INDEX IDX_497B315E6B8CB11F7F431C27 ON utilisateurs (prenom_user, nom_user)');
        $this->addSql('ALTER TABLE utilisateurs RENAME INDEX id_role TO IDX_497B315EDC499668');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_497B315E6B8CB11F7F431C27 ON utilisateurs');
        $this->addSql('ALTER TABLE utilisateurs RENAME INDEX idx_497b315edc499668 TO id_role');
    }
}
