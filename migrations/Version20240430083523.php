<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240430083523 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "household" (id SERIAL NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE household_user (household_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(household_id, user_id))');
        $this->addSql('CREATE INDEX IDX_8CCC41A8E79FF843 ON household_user (household_id)');
        $this->addSql('CREATE INDEX IDX_8CCC41A8A76ED395 ON household_user (user_id)');
        $this->addSql('ALTER TABLE household_user ADD CONSTRAINT FK_8CCC41A8E79FF843 FOREIGN KEY (household_id) REFERENCES "household" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE household_user ADD CONSTRAINT FK_8CCC41A8A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE household_user DROP CONSTRAINT FK_8CCC41A8E79FF843');
        $this->addSql('ALTER TABLE household_user DROP CONSTRAINT FK_8CCC41A8A76ED395');
        $this->addSql('DROP TABLE "household"');
        $this->addSql('DROP TABLE household_user');
    }
}
