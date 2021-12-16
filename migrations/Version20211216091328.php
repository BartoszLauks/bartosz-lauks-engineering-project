<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211216091328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car_body_property (id INT AUTO_INCREMENT NOT NULL, property VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_body_value (id INT AUTO_INCREMENT NOT NULL, car_body_id INT DEFAULT NULL, property_id INT DEFAULT NULL, value VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_8C4152EDC8C9E658 (car_body_id), INDEX IDX_8C4152ED549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car_body_value ADD CONSTRAINT FK_8C4152EDC8C9E658 FOREIGN KEY (car_body_id) REFERENCES car_body (id)');
        $this->addSql('ALTER TABLE car_body_value ADD CONSTRAINT FK_8C4152ED549213EC FOREIGN KEY (property_id) REFERENCES car_body_property (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car_body_value DROP FOREIGN KEY FK_8C4152ED549213EC');
        $this->addSql('DROP TABLE car_body_property');
        $this->addSql('DROP TABLE car_body_value');
    }
}
