<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250406161613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, slug VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_404021BF12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation_section (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, formation_id INT DEFAULT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, sex VARCHAR(10) NOT NULL, age INT NOT NULL, nationality VARCHAR(255) NOT NULL, school_level VARCHAR(255) NOT NULL, activity_actuelle VARCHAR(255) DEFAULT NULL, country VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, INDEX IDX_B723AF335200282E (formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF12469DE2 FOREIGN KEY (category_id) REFERENCES formation_category (id)');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF335200282E FOREIGN KEY (formation_id) REFERENCES formation_category (id)');
        $this->addSql('ALTER TABLE posts CHANGE published_at published_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE keywords keywords VARCHAR(500) DEFAULT NULL');
        $this->addSql('ALTER TABLE realisation CHANGE client client VARCHAR(255) DEFAULT NULL, CHANGE delivery_at delivery_at DATE DEFAULT NULL, CHANGE sub_title sub_title VARCHAR(500) DEFAULT NULL');
        $this->addSql('ALTER TABLE sections CHANGE photo photo VARCHAR(350) DEFAULT NULL');
        $this->addSql('ALTER TABLE tags CHANGE name name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE team_member CHANGE facebook_link facebook_link VARCHAR(255) DEFAULT NULL, CHANGE linkedin linkedin VARCHAR(255) DEFAULT NULL, CHANGE twitter twitter VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE testimony CHANGE video_link video_link VARCHAR(300) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF12469DE2');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF335200282E');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE formation_category');
        $this->addSql('DROP TABLE formation_section');
        $this->addSql('DROP TABLE student');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\' COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE posts CHANGE published_at published_at DATETIME DEFAULT \'current_timestamp()\' NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE keywords keywords VARCHAR(500) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE realisation CHANGE client client VARCHAR(255) DEFAULT \'NULL\', CHANGE delivery_at delivery_at DATE DEFAULT \'NULL\', CHANGE sub_title sub_title VARCHAR(500) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE sections CHANGE photo photo VARCHAR(350) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE tags CHANGE name name VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE team_member CHANGE facebook_link facebook_link VARCHAR(255) DEFAULT \'NULL\', CHANGE linkedin linkedin VARCHAR(255) DEFAULT \'NULL\', CHANGE twitter twitter VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE testimony CHANGE video_link video_link VARCHAR(300) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}
