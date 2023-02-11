<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230120191036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment DROP CONSTRAINT fk_fe38f8449d86650f');
        $this->addSql('DROP INDEX idx_fe38f8449d86650f');
        $this->addSql('ALTER TABLE appointment ALTER price TYPE DOUBLE PRECISION');
        $this->addSql('ALTER TABLE appointment RENAME COLUMN user_id_id TO user_id');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_FE38F844A76ED395 ON appointment (user_id)');
        $this->addSql('ALTER TABLE expense_item ALTER price TYPE DOUBLE PRECISION');
        $this->addSql('ALTER TABLE media_object DROP CONSTRAINT fk_14d431328fddab70');
        $this->addSql('DROP INDEX idx_14d431328fddab70');
        $this->addSql('ALTER TABLE media_object RENAME COLUMN owner_id_id TO owner_id');
        $this->addSql('ALTER TABLE media_object ADD CONSTRAINT FK_14D431327E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_14D431327E3C61F9 ON media_object (owner_id)');
        $this->addSql('ALTER TABLE "user" ALTER phone TYPE VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE expense_item ALTER price TYPE NUMERIC(10, 0)');
        $this->addSql('ALTER TABLE media_object DROP CONSTRAINT FK_14D431327E3C61F9');
        $this->addSql('DROP INDEX IDX_14D431327E3C61F9');
        $this->addSql('ALTER TABLE media_object RENAME COLUMN owner_id TO owner_id_id');
        $this->addSql('ALTER TABLE media_object ADD CONSTRAINT fk_14d431328fddab70 FOREIGN KEY (owner_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_14d431328fddab70 ON media_object (owner_id_id)');
        $this->addSql('ALTER TABLE "user" ALTER phone TYPE INT');
        $this->addSql('ALTER TABLE appointment DROP CONSTRAINT FK_FE38F844A76ED395');
        $this->addSql('DROP INDEX IDX_FE38F844A76ED395');
        $this->addSql('ALTER TABLE appointment ALTER price TYPE NUMERIC(10, 0)');
        $this->addSql('ALTER TABLE appointment RENAME COLUMN user_id TO user_id_id');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT fk_fe38f8449d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_fe38f8449d86650f ON appointment (user_id_id)');
    }
}
