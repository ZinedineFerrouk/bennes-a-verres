<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211209082806 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE benne (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', recordid VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, commune VARCHAR(255) NOT NULL, quartier DOUBLE PRECISION NOT NULL, model VARCHAR(255) NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE last_bennes_update (id INT AUTO_INCREMENT NOT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', errored_update TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, organization VARCHAR(255) DEFAULT NULL, kbis VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, user_token LONGTEXT DEFAULT NULL, api_access_token LONGTEXT DEFAULT NULL, is_validated TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE benne');
        $this->addSql('DROP TABLE last_bennes_update');
        $this->addSql('DROP TABLE user');
    }
}
