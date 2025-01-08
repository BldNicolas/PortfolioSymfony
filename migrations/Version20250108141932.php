<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250108141932 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experience DROP CONSTRAINT fk_590c103ccfa12b8');
        $this->addSql('ALTER TABLE project DROP CONSTRAINT fk_2fb3d0eeccfa12b8');
        $this->addSql('DROP SEQUENCE profile_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE profile_section_id_seq CASCADE');
        $this->addSql('CREATE TABLE about (id SERIAL NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, date_of_birth DATE NOT NULL, email VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE about_custom_section (id SERIAL NOT NULL, portfolio_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F1F73008B96B5643 ON about_custom_section (portfolio_id)');
        $this->addSql('CREATE TABLE portfolio (id SERIAL NOT NULL, owner_id INT DEFAULT NULL, about_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A9ED10627E3C61F9 ON portfolio (owner_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A9ED1062D087DB59 ON portfolio (about_id)');
        $this->addSql('ALTER TABLE about_custom_section ADD CONSTRAINT FK_F1F73008B96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE portfolio ADD CONSTRAINT FK_A9ED10627E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE portfolio ADD CONSTRAINT FK_A9ED1062D087DB59 FOREIGN KEY (about_id) REFERENCES about (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE profile_section DROP CONSTRAINT fk_fecda473ccfa12b8');
        $this->addSql('ALTER TABLE profile DROP CONSTRAINT fk_8157aa0f6b9dd454');
        $this->addSql('DROP TABLE profile_section');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP INDEX idx_590c103ccfa12b8');
        $this->addSql('ALTER TABLE experience RENAME COLUMN profile_id TO portfolio_id');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT FK_590C103B96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_590C103B96B5643 ON experience (portfolio_id)');
        $this->addSql('DROP INDEX idx_2fb3d0eeccfa12b8');
        $this->addSql('ALTER TABLE project ALTER technologies TYPE TEXT');
        $this->addSql('ALTER TABLE project RENAME COLUMN profile_id TO portfolio_id');
        $this->addSql('COMMENT ON COLUMN project.technologies IS NULL');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEB96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2FB3D0EEB96B5643 ON project (portfolio_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE experience DROP CONSTRAINT FK_590C103B96B5643');
        $this->addSql('ALTER TABLE project DROP CONSTRAINT FK_2FB3D0EEB96B5643');
        $this->addSql('CREATE SEQUENCE profile_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE profile_section_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE profile_section (id SERIAL NOT NULL, profile_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_fecda473ccfa12b8 ON profile_section (profile_id)');
        $this->addSql('CREATE TABLE profile (id SERIAL NOT NULL, user_profile_id INT DEFAULT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, date_of_birth DATE NOT NULL, email VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_8157aa0f6b9dd454 ON profile (user_profile_id)');
        $this->addSql('ALTER TABLE profile_section ADD CONSTRAINT fk_fecda473ccfa12b8 FOREIGN KEY (profile_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT fk_8157aa0f6b9dd454 FOREIGN KEY (user_profile_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE about_custom_section DROP CONSTRAINT FK_F1F73008B96B5643');
        $this->addSql('ALTER TABLE portfolio DROP CONSTRAINT FK_A9ED10627E3C61F9');
        $this->addSql('ALTER TABLE portfolio DROP CONSTRAINT FK_A9ED1062D087DB59');
        $this->addSql('DROP TABLE about');
        $this->addSql('DROP TABLE about_custom_section');
        $this->addSql('DROP TABLE portfolio');
        $this->addSql('DROP INDEX IDX_590C103B96B5643');
        $this->addSql('ALTER TABLE experience RENAME COLUMN portfolio_id TO profile_id');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT fk_590c103ccfa12b8 FOREIGN KEY (profile_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_590c103ccfa12b8 ON experience (profile_id)');
        $this->addSql('DROP INDEX IDX_2FB3D0EEB96B5643');
        $this->addSql('ALTER TABLE project ALTER technologies TYPE TEXT');
        $this->addSql('ALTER TABLE project RENAME COLUMN portfolio_id TO profile_id');
        $this->addSql('COMMENT ON COLUMN project.technologies IS \'(DC2Type:simple_array)\'');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT fk_2fb3d0eeccfa12b8 FOREIGN KEY (profile_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_2fb3d0eeccfa12b8 ON project (profile_id)');
    }
}
