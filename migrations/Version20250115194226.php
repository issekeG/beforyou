<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250115194226 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, subsidiary_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_AC74095AD4A7BDA2 (subsidiary_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, realisation_id INT DEFAULT NULL, image VARCHAR(500) NOT NULL, dimension VARCHAR(255) NOT NULL, INDEX IDX_E01FBE6AB685E551 (realisation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE posts (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, image VARCHAR(350) NOT NULL, author VARCHAR(255) NOT NULL, read_time INT NOT NULL, published_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', keywords VARCHAR(500) DEFAULT NULL, seo_description LONGTEXT DEFAULT NULL, seo_title VARCHAR(350) NOT NULL, slug VARCHAR(255) NOT NULL, section_numbers INT DEFAULT NULL, sector VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE realisation (id INT AUTO_INCREMENT NOT NULL, activity_id INT DEFAULT NULL, title VARCHAR(500) NOT NULL, client VARCHAR(255) DEFAULT NULL, started_at DATE NOT NULL, delivery_at DATE DEFAULT NULL, sub_title VARCHAR(500) DEFAULT NULL, sub_title2 VARCHAR(500) NOT NULL, sub_title_description LONGTEXT DEFAULT NULL, second_sub_title_description LONGTEXT DEFAULT NULL, slug VARCHAR(500) NOT NULL, INDEX IDX_EAA5610E81C06096 (activity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sections (id INT AUTO_INCREMENT NOT NULL, posts_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, photo VARCHAR(350) DEFAULT NULL, INDEX IDX_2B964398D5E258C5 (posts_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subsidiary (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, photo VARCHAR(500) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tags (id INT AUTO_INCREMENT NOT NULL, post_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_6FBC94264B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team_member (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, `rank` INT NOT NULL, description LONGTEXT NOT NULL, facebook_link VARCHAR(255) DEFAULT NULL, linkedin VARCHAR(255) DEFAULT NULL, twitter VARCHAR(255) DEFAULT NULL, photo VARCHAR(500) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095AD4A7BDA2 FOREIGN KEY (subsidiary_id) REFERENCES subsidiary (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AB685E551 FOREIGN KEY (realisation_id) REFERENCES realisation (id)');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT FK_EAA5610E81C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('ALTER TABLE sections ADD CONSTRAINT FK_2B964398D5E258C5 FOREIGN KEY (posts_id) REFERENCES posts (id)');
        $this->addSql('ALTER TABLE tags ADD CONSTRAINT FK_6FBC94264B89032C FOREIGN KEY (post_id) REFERENCES posts (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095AD4A7BDA2');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AB685E551');
        $this->addSql('ALTER TABLE realisation DROP FOREIGN KEY FK_EAA5610E81C06096');
        $this->addSql('ALTER TABLE sections DROP FOREIGN KEY FK_2B964398D5E258C5');
        $this->addSql('ALTER TABLE tags DROP FOREIGN KEY FK_6FBC94264B89032C');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE posts');
        $this->addSql('DROP TABLE realisation');
        $this->addSql('DROP TABLE sections');
        $this->addSql('DROP TABLE subsidiary');
        $this->addSql('DROP TABLE tags');
        $this->addSql('DROP TABLE team_member');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
