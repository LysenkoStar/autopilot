<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200426113621 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (vk_id INT NOT NULL, app_settings INT DEFAULT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, is_closed TINYINT(1) NOT NULL, can_access_closed TINYINT(1) NOT NULL, sex SMALLINT NOT NULL, bdate VARCHAR(255) NOT NULL, city_id INT NOT NULL, city VARCHAR(255) NOT NULL, country_id INT NOT NULL, country VARCHAR(255) NOT NULL, photo_min VARCHAR(255) NOT NULL, photo_max VARCHAR(255) NOT NULL, has_photo TINYINT(1) NOT NULL, has_mobile TINYINT(1) NOT NULL, verified TINYINT(1) NOT NULL, access_token VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649EDC5C068 (app_settings), PRIMARY KEY(vk_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, user INT DEFAULT NULL, image VARCHAR(255) NOT NULL, vk_id INT NOT NULL, settings VARCHAR(255) DEFAULT NULL, `resources` VARCHAR(255) DEFAULT NULL, `actions` VARCHAR(255) DEFAULT NULL, `name` VARCHAR(255) NOT NULL, `type` VARCHAR(255) NOT NULL, `closed` TINYINT(1) NOT NULL, members_count INT NOT NULL, connected TINYINT(1) DEFAULT \'0\', access_token VARCHAR(255) DEFAULT NULL, date_added DATETIME DEFAULT NULL, INDEX IDX_6DC044C58D93D649 (user), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_settings (id INT AUTO_INCREMENT NOT NULL, renew_rate TINYINT(1) NOT NULL, receive_notifications TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649EDC5C068 FOREIGN KEY (app_settings) REFERENCES app_settings (id)');
        $this->addSql('ALTER TABLE `group` ADD CONSTRAINT FK_6DC044C58D93D649 FOREIGN KEY (user) REFERENCES user (vk_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE `group` DROP FOREIGN KEY FK_6DC044C58D93D649');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649EDC5C068');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE app_settings');
    }
}
