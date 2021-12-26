<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211225154347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sales_offers (id INT AUTO_INCREMENT NOT NULL, brand_id INT DEFAULT NULL, model_id INT DEFAULT NULL, generation_id INT DEFAULT NULL, car_body_id INT DEFAULT NULL, engine_id INT DEFAULT NULL, user_id INT DEFAULT NULL, price INT NOT NULL, mileage INT NOT NULL, details LONGTEXT DEFAULT NULL, INDEX IDX_F8B2562F44F5D008 (brand_id), INDEX IDX_F8B2562F7975B7E7 (model_id), INDEX IDX_F8B2562F553A6EC4 (generation_id), INDEX IDX_F8B2562FC8C9E658 (car_body_id), INDEX IDX_F8B2562FE78C9C0A (engine_id), INDEX IDX_F8B2562FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sales_offers ADD CONSTRAINT FK_F8B2562F44F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE sales_offers ADD CONSTRAINT FK_F8B2562F7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
        $this->addSql('ALTER TABLE sales_offers ADD CONSTRAINT FK_F8B2562F553A6EC4 FOREIGN KEY (generation_id) REFERENCES generation (id)');
        $this->addSql('ALTER TABLE sales_offers ADD CONSTRAINT FK_F8B2562FC8C9E658 FOREIGN KEY (car_body_id) REFERENCES car_body (id)');
        $this->addSql('ALTER TABLE sales_offers ADD CONSTRAINT FK_F8B2562FE78C9C0A FOREIGN KEY (engine_id) REFERENCES engine (id)');
        $this->addSql('ALTER TABLE sales_offers ADD CONSTRAINT FK_F8B2562FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE sales_offers');
    }
}
