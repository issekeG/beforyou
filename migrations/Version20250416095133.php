<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250416095133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formation CHANGE published_at published_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE formation_category DROP FOREIGN KEY FK_C1DE4E30D823E37A');
        $this->addSql('DROP INDEX IDX_C1DE4E30D823E37A ON formation_category');
        $this->addSql('ALTER TABLE formation_category DROP section_id');
        $this->addSql('ALTER TABLE posts CHANGE published_at published_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE keywords keywords VARCHAR(500) DEFAULT NULL');
        $this->addSql('ALTER TABLE realisation CHANGE client client VARCHAR(255) DEFAULT NULL, CHANGE delivery_at delivery_at DATE DEFAULT NULL, CHANGE sub_title sub_title VARCHAR(500) DEFAULT NULL');
        $this->addSql('ALTER TABLE sections CHANGE photo photo VARCHAR(350) DEFAULT NULL');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF335200282E');
        $this->addSql('ALTER TABLE student CHANGE formation_id formation_id INT NOT NULL, CHANGE activity_actuelle activity_actuelle VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF335200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE tags CHANGE name name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE team_member CHANGE facebook_link facebook_link VARCHAR(255) DEFAULT NULL, CHANGE linkedin linkedin VARCHAR(255) DEFAULT NULL, CHANGE twitter twitter VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE testimony CHANGE video_link video_link VARCHAR(300) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formation CHANGE published_at published_at DATETIME DEFAULT \'current_timestamp()\' NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE formation_category ADD section_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE formation_category ADD CONSTRAINT FK_C1DE4E30D823E37A FOREIGN KEY (section_id) REFERENCES formation_section (id)');
        $this->addSql('CREATE INDEX IDX_C1DE4E30D823E37A ON formation_category (section_id)');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\' COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE posts CHANGE published_at published_at DATETIME DEFAULT \'current_timestamp()\' NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE keywords keywords VARCHAR(500) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE realisation CHANGE client client VARCHAR(255) DEFAULT \'NULL\', CHANGE delivery_at delivery_at DATE DEFAULT \'NULL\', CHANGE sub_title sub_title VARCHAR(500) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE sections CHANGE photo photo VARCHAR(350) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF335200282E');
        $this->addSql('ALTER TABLE student CHANGE formation_id formation_id INT DEFAULT NULL, CHANGE activity_actuelle activity_actuelle VARCHAR(255) DEFAULT \'NULL\', CHANGE email email VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF335200282E FOREIGN KEY (formation_id) REFERENCES formation_category (id)');
        $this->addSql('ALTER TABLE tags CHANGE name name VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE team_member CHANGE facebook_link facebook_link VARCHAR(255) DEFAULT \'NULL\', CHANGE linkedin linkedin VARCHAR(255) DEFAULT \'NULL\', CHANGE twitter twitter VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE testimony CHANGE video_link video_link VARCHAR(300) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}
