<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220627080356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE achats (id_achat INT AUTO_INCREMENT NOT NULL, id_prod INT DEFAULT NULL, id_user INT DEFAULT NULL, id_type_lieu INT DEFAULT NULL, date_achat DATE NOT NULL, date_gar_achat DATE NOT NULL, prix_achat DOUBLE PRECISION NOT NULL, photo_ticket_achat VARCHAR(255) NOT NULL, lieu_achat VARCHAR(255) NOT NULL, INDEX id_user (id_user), INDEX id_prod (id_prod), INDEX id_type_lieu (id_type_lieu), PRIMARY KEY(id_achat)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id_cat INT AUTO_INCREMENT NOT NULL, nom_cat VARCHAR(50) NOT NULL, PRIMARY KEY(id_cat)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modifications (id_modif INT AUTO_INCREMENT NOT NULL, id_prod INT DEFAULT NULL, id_user INT DEFAULT NULL, type_modif VARCHAR(10) NOT NULL, desc_modif VARCHAR(500) NOT NULL, date_modif DATE NOT NULL, INDEX id_user (id_user), INDEX id_prod (id_prod), PRIMARY KEY(id_modif)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produits (id_prod INT AUTO_INCREMENT NOT NULL, id_cat INT DEFAULT NULL, nom_prod VARCHAR(100) NOT NULL, manuel_prod VARCHAR(255) DEFAULT NULL, infos_prod VARCHAR(1000) NOT NULL, efface_prod TINYINT(1) NOT NULL, INDEX IDX_BE2DDF8CFAABF2 (id_cat), FULLTEXT INDEX IDX_BE2DDF8C4764DBF992A66134 (nom_prod, infos_prod), PRIMARY KEY(id_prod)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles (id_role INT AUTO_INCREMENT NOT NULL, nom_role VARCHAR(50) NOT NULL, PRIMARY KEY(id_role)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_lieux (id_type_lieu INT AUTO_INCREMENT NOT NULL, nom_type_lieu VARCHAR(50) NOT NULL, PRIMARY KEY(id_type_lieu)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateurs (id_user INT AUTO_INCREMENT NOT NULL, id_role INT DEFAULT NULL, mail_user VARCHAR(255) NOT NULL, prenom_user VARCHAR(50) NOT NULL, nom_user VARCHAR(50) NOT NULL, mdp_user VARCHAR(255) NOT NULL, INDEX IDX_497B315EDC499668 (id_role), FULLTEXT INDEX IDX_497B315E6B8CB11F7F431C27 (prenom_user, nom_user), PRIMARY KEY(id_user)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE achats ADD CONSTRAINT FK_9920924E3E940D95 FOREIGN KEY (id_prod) REFERENCES produits (id_prod)');
        $this->addSql('ALTER TABLE achats ADD CONSTRAINT FK_9920924E6B3CA4B FOREIGN KEY (id_user) REFERENCES utilisateurs (id_user)');
        $this->addSql('ALTER TABLE achats ADD CONSTRAINT FK_9920924E786D0476 FOREIGN KEY (id_type_lieu) REFERENCES type_lieux (id_type_lieu)');
        $this->addSql('ALTER TABLE modifications ADD CONSTRAINT FK_733C18D63E940D95 FOREIGN KEY (id_prod) REFERENCES produits (id_prod)');
        $this->addSql('ALTER TABLE modifications ADD CONSTRAINT FK_733C18D66B3CA4B FOREIGN KEY (id_user) REFERENCES utilisateurs (id_user)');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8CFAABF2 FOREIGN KEY (id_cat) REFERENCES categories (id_cat)');
        $this->addSql('ALTER TABLE utilisateurs ADD CONSTRAINT FK_497B315EDC499668 FOREIGN KEY (id_role) REFERENCES roles (id_role)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produits DROP FOREIGN KEY FK_BE2DDF8CFAABF2');
        $this->addSql('ALTER TABLE achats DROP FOREIGN KEY FK_9920924E3E940D95');
        $this->addSql('ALTER TABLE modifications DROP FOREIGN KEY FK_733C18D63E940D95');
        $this->addSql('ALTER TABLE utilisateurs DROP FOREIGN KEY FK_497B315EDC499668');
        $this->addSql('ALTER TABLE achats DROP FOREIGN KEY FK_9920924E786D0476');
        $this->addSql('ALTER TABLE achats DROP FOREIGN KEY FK_9920924E6B3CA4B');
        $this->addSql('ALTER TABLE modifications DROP FOREIGN KEY FK_733C18D66B3CA4B');
        $this->addSql('DROP TABLE achats');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE modifications');
        $this->addSql('DROP TABLE produits');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE type_lieux');
        $this->addSql('DROP TABLE utilisateurs');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
