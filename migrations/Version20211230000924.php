<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211230000924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE specialist_comment (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, brand_id INT DEFAULT NULL, model_id INT DEFAULT NULL, generation_id INT DEFAULT NULL, body_id INT DEFAULT NULL, engine_id INT DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_F21A0DA3A76ED395 (user_id), INDEX IDX_F21A0DA344F5D008 (brand_id), INDEX IDX_F21A0DA37975B7E7 (model_id), INDEX IDX_F21A0DA3553A6EC4 (generation_id), INDEX IDX_F21A0DA39B621D84 (body_id), INDEX IDX_F21A0DA3E78C9C0A (engine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE specialist_comment ADD CONSTRAINT FK_F21A0DA3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE specialist_comment ADD CONSTRAINT FK_F21A0DA344F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE specialist_comment ADD CONSTRAINT FK_F21A0DA37975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
        $this->addSql('ALTER TABLE specialist_comment ADD CONSTRAINT FK_F21A0DA3553A6EC4 FOREIGN KEY (generation_id) REFERENCES generation (id)');
        $this->addSql('ALTER TABLE specialist_comment ADD CONSTRAINT FK_F21A0DA39B621D84 FOREIGN KEY (body_id) REFERENCES car_body (id)');
        $this->addSql('ALTER TABLE specialist_comment ADD CONSTRAINT FK_F21A0DA3E78C9C0A FOREIGN KEY (engine_id) REFERENCES engine (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE specialist_comment');
    }
}
