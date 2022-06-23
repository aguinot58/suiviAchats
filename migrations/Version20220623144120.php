<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220623144120 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE achats CHANGE id_prod id_prod INT DEFAULT NULL, CHANGE id_user id_user INT DEFAULT NULL, CHANGE id_type_lieu id_type_lieu INT DEFAULT NULL');
        $this->addSql('ALTER TABLE modifications CHANGE id_prod id_prod INT DEFAULT NULL, CHANGE id_user id_user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produits CHANGE id_cat id_cat INT DEFAULT NULL');
        $this->addSql('CREATE FULLTEXT INDEX IDX_BE2DDF8C4764DBF992A66134 ON produits (nom_prod, infos_prod)');
        $this->addSql('ALTER TABLE produits RENAME INDEX id_cat TO IDX_BE2DDF8CFAABF2');
        $this->addSql('ALTER TABLE utilisateurs CHANGE id_role id_role INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE achats CHANGE id_prod id_prod INT NOT NULL, CHANGE id_user id_user INT NOT NULL, CHANGE id_type_lieu id_type_lieu INT NOT NULL');
        $this->addSql('ALTER TABLE modifications CHANGE id_prod id_prod INT NOT NULL, CHANGE id_user id_user INT NOT NULL');
        $this->addSql('DROP INDEX IDX_BE2DDF8C4764DBF992A66134 ON produits');
        $this->addSql('ALTER TABLE produits CHANGE id_cat id_cat INT NOT NULL');
        $this->addSql('ALTER TABLE produits RENAME INDEX idx_be2ddf8cfaabf2 TO id_cat');
        $this->addSql('ALTER TABLE utilisateurs CHANGE id_role id_role INT NOT NULL');
    }
}
