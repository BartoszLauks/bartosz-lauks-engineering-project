<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220115161435 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brand ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE car_body ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE engine ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE gender ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE generation ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE model ADD created_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brand DROP created_at');
        $this->addSql('ALTER TABLE car_body DROP created_at');
        $this->addSql('ALTER TABLE engine DROP created_at');
        $this->addSql('ALTER TABLE gender DROP created_at');
        $this->addSql('ALTER TABLE generation DROP created_at');
        $this->addSql('ALTER TABLE model DROP created_at');
    }
}

