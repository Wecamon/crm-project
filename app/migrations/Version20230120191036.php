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
        return 'Create initial dataset';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE appointment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE expense_item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE media_object_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE appointment (id INT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, schedule TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, price DOUBLE PRECISION NOT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FE38F844A76ED395 ON appointment (user_id)');
        $this->addSql('COMMENT ON COLUMN appointment.schedule IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN appointment.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN appointment.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE appointments_media_objects (appointment_id INT NOT NULL, media_object_id INT NOT NULL, PRIMARY KEY(appointment_id, media_object_id))');
        $this->addSql('CREATE INDEX IDX_87D09FA6E5B533F9 ON appointments_media_objects (appointment_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_87D09FA664DE5A5 ON appointments_media_objects (media_object_id)');
        $this->addSql('CREATE TABLE expense_item (id INT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN expense_item.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE media_object (id INT NOT NULL, owner_id INT NOT NULL, path TEXT NOT NULL, meta JSON DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_14D431327E3C61F9 ON media_object (owner_id)');
        $this->addSql('COMMENT ON COLUMN media_object.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) DEFAULT NULL, roles JSON DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "user".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user".updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE appointments_media_objects ADD CONSTRAINT FK_87D09FA6E5B533F9 FOREIGN KEY (appointment_id) REFERENCES appointment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE appointments_media_objects ADD CONSTRAINT FK_87D09FA664DE5A5 FOREIGN KEY (media_object_id) REFERENCES media_object (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE media_object ADD CONSTRAINT FK_14D431327E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE appointment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE expense_item_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE media_object_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE appointment DROP CONSTRAINT FK_FE38F844A76ED395');
        $this->addSql('ALTER TABLE appointments_media_objects DROP CONSTRAINT FK_87D09FA6E5B533F9');
        $this->addSql('ALTER TABLE appointments_media_objects DROP CONSTRAINT FK_87D09FA664DE5A5');
        $this->addSql('ALTER TABLE media_object DROP CONSTRAINT FK_14D431327E3C61F9');
        $this->addSql('DROP TABLE appointment');
        $this->addSql('DROP TABLE appointments_media_objects');
        $this->addSql('DROP TABLE expense_item');
        $this->addSql('DROP TABLE media_object');
        $this->addSql('DROP TABLE "user"');
    }
}
