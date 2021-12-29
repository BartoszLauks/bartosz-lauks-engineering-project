<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211228005028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post ADD brand_id INT DEFAULT NULL, ADD model_id INT DEFAULT NULL, ADD generation_id INT DEFAULT NULL, ADD car_body_id INT DEFAULT NULL, ADD engine_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D44F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D553A6EC4 FOREIGN KEY (generation_id) REFERENCES generation (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DC8C9E658 FOREIGN KEY (car_body_id) REFERENCES car_body (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DE78C9C0A FOREIGN KEY (engine_id) REFERENCES engine (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D44F5D008 ON post (brand_id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D7975B7E7 ON post (model_id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D553A6EC4 ON post (generation_id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DC8C9E658 ON post (car_body_id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DE78C9C0A ON post (engine_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D44F5D008');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D7975B7E7');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D553A6EC4');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DC8C9E658');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DE78C9C0A');
        $this->addSql('DROP INDEX IDX_5A8A6C8D44F5D008 ON post');
        $this->addSql('DROP INDEX IDX_5A8A6C8D7975B7E7 ON post');
        $this->addSql('DROP INDEX IDX_5A8A6C8D553A6EC4 ON post');
        $this->addSql('DROP INDEX IDX_5A8A6C8DC8C9E658 ON post');
        $this->addSql('DROP INDEX IDX_5A8A6C8DE78C9C0A ON post');
        $this->addSql('ALTER TABLE post DROP brand_id, DROP model_id, DROP generation_id, DROP car_body_id, DROP engine_id');
    }
}
