<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250109132909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX uniq_a9ed10627e3c61f9');
        $this->addSql('ALTER TABLE portfolio ALTER owner_id SET NOT NULL');
        $this->addSql('CREATE INDEX IDX_A9ED10627E3C61F9 ON portfolio (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX IDX_A9ED10627E3C61F9');
        $this->addSql('ALTER TABLE portfolio ALTER owner_id DROP NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX uniq_a9ed10627e3c61f9 ON portfolio (owner_id)');
    }
}
