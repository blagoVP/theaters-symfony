<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201209190244 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE play (id INT AUTO_INCREMENT NOT NULL, users_liked_id INT DEFAULT NULL, creator_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, image_url VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_5E89DEBA99AC33A3 (users_liked_id), INDEX IDX_5E89DEBA61220EA6 (creator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE play ADD CONSTRAINT FK_5E89DEBA99AC33A3 FOREIGN KEY (users_liked_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE play ADD CONSTRAINT FK_5E89DEBA61220EA6 FOREIGN KEY (creator_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE play DROP FOREIGN KEY FK_5E89DEBA99AC33A3');
        $this->addSql('ALTER TABLE play DROP FOREIGN KEY FK_5E89DEBA61220EA6');
        $this->addSql('DROP TABLE play');
        $this->addSql('DROP TABLE user');
    }
}
