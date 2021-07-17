<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210622181724 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE change_password_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE event_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE godparent_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE godson_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE marker_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE message_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE thread_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE thread_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE change_password (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE event (id INT NOT NULL, marker_id_id INT DEFAULT NULL, organizer_id_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, description TEXT DEFAULT NULL, date DATE DEFAULT NULL, lat DOUBLE PRECISION NOT NULL, lng DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7D7BA1418 ON event (marker_id_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7E78C696A ON event (organizer_id_id)');
        $this->addSql('CREATE TABLE event_user (event_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(event_id, user_id))');
        $this->addSql('CREATE INDEX IDX_92589AE271F7E88B ON event_user (event_id)');
        $this->addSql('CREATE INDEX IDX_92589AE2A76ED395 ON event_user (user_id)');
        $this->addSql('CREATE TABLE godparent (id INT NOT NULL, user_id_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2475E3CE9D86650F ON godparent (user_id_id)');
        $this->addSql('CREATE TABLE godson (id INT NOT NULL, user_id_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_15CDF3B79D86650F ON godson (user_id_id)');
        $this->addSql('CREATE TABLE godson_godparent (godson_id INT NOT NULL, godparent_id INT NOT NULL, PRIMARY KEY(godson_id, godparent_id))');
        $this->addSql('CREATE INDEX IDX_7EFDCC437C1421C3 ON godson_godparent (godson_id)');
        $this->addSql('CREATE INDEX IDX_7EFDCC43A84C5BC2 ON godson_godparent (godparent_id)');
        $this->addSql('CREATE TABLE marker (id INT NOT NULL, lat DOUBLE PRECISION DEFAULT NULL, lng DOUBLE PRECISION DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE message (id INT NOT NULL, thread_id INT NOT NULL, sender_id INT NOT NULL, sent_to INT DEFAULT NULL, text_body TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, joined_file BYTEA DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE thread (id INT NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE thread_user (id INT NOT NULL, user_id_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_922CAC79D86650F ON thread_user (user_id_id)');
        $this->addSql('CREATE TABLE thread_user_thread (thread_user_id INT NOT NULL, thread_id INT NOT NULL, PRIMARY KEY(thread_user_id, thread_id))');
        $this->addSql('CREATE INDEX IDX_B7D3043916D43BDC ON thread_user_thread (thread_user_id)');
        $this->addSql('CREATE INDEX IDX_B7D30439E2904019 ON thread_user_thread (thread_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, school VARCHAR(255) NOT NULL, is_connected BOOLEAN DEFAULT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, is_godparent BOOLEAN NOT NULL, spoken_language TEXT DEFAULT NULL, language_to_learn TEXT DEFAULT NULL, description TEXT DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, is_godson BOOLEAN NOT NULL, token VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('COMMENT ON COLUMN "user".spoken_language IS \'(DC2Type:array)\'');
        $this->addSql('COMMENT ON COLUMN "user".language_to_learn IS \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7D7BA1418 FOREIGN KEY (marker_id_id) REFERENCES marker (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7E78C696A FOREIGN KEY (organizer_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_user ADD CONSTRAINT FK_92589AE271F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_user ADD CONSTRAINT FK_92589AE2A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE godparent ADD CONSTRAINT FK_2475E3CE9D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE godson ADD CONSTRAINT FK_15CDF3B79D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE godson_godparent ADD CONSTRAINT FK_7EFDCC437C1421C3 FOREIGN KEY (godson_id) REFERENCES godson (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE godson_godparent ADD CONSTRAINT FK_7EFDCC43A84C5BC2 FOREIGN KEY (godparent_id) REFERENCES godparent (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE thread_user ADD CONSTRAINT FK_922CAC79D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE thread_user_thread ADD CONSTRAINT FK_B7D3043916D43BDC FOREIGN KEY (thread_user_id) REFERENCES thread_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE thread_user_thread ADD CONSTRAINT FK_B7D30439E2904019 FOREIGN KEY (thread_id) REFERENCES thread (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE event_user DROP CONSTRAINT FK_92589AE271F7E88B');
        $this->addSql('ALTER TABLE godson_godparent DROP CONSTRAINT FK_7EFDCC43A84C5BC2');
        $this->addSql('ALTER TABLE godson_godparent DROP CONSTRAINT FK_7EFDCC437C1421C3');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA7D7BA1418');
        $this->addSql('ALTER TABLE thread_user_thread DROP CONSTRAINT FK_B7D30439E2904019');
        $this->addSql('ALTER TABLE thread_user_thread DROP CONSTRAINT FK_B7D3043916D43BDC');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA7E78C696A');
        $this->addSql('ALTER TABLE event_user DROP CONSTRAINT FK_92589AE2A76ED395');
        $this->addSql('ALTER TABLE godparent DROP CONSTRAINT FK_2475E3CE9D86650F');
        $this->addSql('ALTER TABLE godson DROP CONSTRAINT FK_15CDF3B79D86650F');
        $this->addSql('ALTER TABLE thread_user DROP CONSTRAINT FK_922CAC79D86650F');
        $this->addSql('DROP SEQUENCE change_password_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE event_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE godparent_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE godson_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE marker_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE message_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE thread_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE thread_user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP TABLE change_password');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_user');
        $this->addSql('DROP TABLE godparent');
        $this->addSql('DROP TABLE godson');
        $this->addSql('DROP TABLE godson_godparent');
        $this->addSql('DROP TABLE marker');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE thread');
        $this->addSql('DROP TABLE thread_user');
        $this->addSql('DROP TABLE thread_user_thread');
        $this->addSql('DROP TABLE "user"');
    }
}
