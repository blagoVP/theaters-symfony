<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210102171202 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_play (user_id INT NOT NULL, play_id INT NOT NULL, INDEX IDX_24089273A76ED395 (user_id), INDEX IDX_2408927325576DBD (play_id), PRIMARY KEY(user_id, play_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_play ADD CONSTRAINT FK_24089273A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_play ADD CONSTRAINT FK_2408927325576DBD FOREIGN KEY (play_id) REFERENCES play (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE play DROP FOREIGN KEY FK_5E89DEBA99AC33A3');
        $this->addSql('DROP INDEX IDX_5E89DEBA99AC33A3 ON play');
        $this->addSql('ALTER TABLE play DROP users_liked_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_play');
        $this->addSql('ALTER TABLE play ADD users_liked_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE play ADD CONSTRAINT FK_5E89DEBA99AC33A3 FOREIGN KEY (users_liked_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5E89DEBA99AC33A3 ON play (users_liked_id)');
    }
}
