<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201211104113 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE evenement_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE filleul_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE parrain_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE event_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE godparent_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE godson_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE event (id INT NOT NULL, marker_id_id INT DEFAULT NULL, organizer_id_id INT DEFAULT NULL, event_name VARCHAR(255) DEFAULT NULL, event_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7D7BA1418 ON event (marker_id_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7E78C696A ON event (organizer_id_id)');
        $this->addSql('CREATE TABLE event_godson (event_id INT NOT NULL, godson_id INT NOT NULL, PRIMARY KEY(event_id, godson_id))');
        $this->addSql('CREATE INDEX IDX_275484E571F7E88B ON event_godson (event_id)');
        $this->addSql('CREATE INDEX IDX_275484E57C1421C3 ON event_godson (godson_id)');
        $this->addSql('CREATE TABLE godparent (id INT NOT NULL, user_id_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2475E3CE9D86650F ON godparent (user_id_id)');
        $this->addSql('CREATE TABLE godson (id INT NOT NULL, user_id_id INT DEFAULT NULL, godparent_id_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_15CDF3B79D86650F ON godson (user_id_id)');
        $this->addSql('CREATE INDEX IDX_15CDF3B7D24F0E92 ON godson (godparent_id_id)');
        $this->addSql('CREATE TABLE thread_user_thread (thread_user_id INT NOT NULL, thread_id INT NOT NULL, PRIMARY KEY(thread_user_id, thread_id))');
        $this->addSql('CREATE INDEX IDX_B7D3043916D43BDC ON thread_user_thread (thread_user_id)');
        $this->addSql('CREATE INDEX IDX_B7D30439E2904019 ON thread_user_thread (thread_id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7D7BA1418 FOREIGN KEY (marker_id_id) REFERENCES marker (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7E78C696A FOREIGN KEY (organizer_id_id) REFERENCES godparent (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_godson ADD CONSTRAINT FK_275484E571F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_godson ADD CONSTRAINT FK_275484E57C1421C3 FOREIGN KEY (godson_id) REFERENCES godson (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE godparent ADD CONSTRAINT FK_2475E3CE9D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE godson ADD CONSTRAINT FK_15CDF3B79D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE godson ADD CONSTRAINT FK_15CDF3B7D24F0E92 FOREIGN KEY (godparent_id_id) REFERENCES godparent (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE thread_user_thread ADD CONSTRAINT FK_B7D3043916D43BDC FOREIGN KEY (thread_user_id) REFERENCES thread_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE thread_user_thread ADD CONSTRAINT FK_B7D30439E2904019 FOREIGN KEY (thread_id) REFERENCES thread (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE filleul');
        $this->addSql('DROP TABLE parrain');
        $this->addSql('ALTER TABLE marker DROP user_id');
        $this->addSql('ALTER TABLE marker DROP marker_id');
        $this->addSql('ALTER TABLE marker RENAME COLUMN adress TO address');
        $this->addSql('ALTER TABLE message ADD thread_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE message ADD send_to_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message DROP thread_id');
        $this->addSql('ALTER TABLE message DROP sender_id');
        $this->addSql('ALTER TABLE message RENAME COLUMN sent_to TO sender_id_id');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F75C0816C FOREIGN KEY (thread_id_id) REFERENCES thread (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F6061F7CF FOREIGN KEY (sender_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F59574F23 FOREIGN KEY (send_to_id) REFERENCES thread_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B6BD307F75C0816C ON message (thread_id_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F6061F7CF ON message (sender_id_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F59574F23 ON message (send_to_id)');
        $this->addSql('ALTER TABLE thread_user ADD user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE thread_user DROP thread_id');
        $this->addSql('ALTER TABLE thread_user ADD CONSTRAINT FK_922CAC79D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_922CAC79D86650F ON thread_user (user_id_id)');
        $this->addSql('ALTER TABLE "user" RENAME COLUMN is_parrain TO is_godparent');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE event_godson DROP CONSTRAINT FK_275484E571F7E88B');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA7E78C696A');
        $this->addSql('ALTER TABLE godson DROP CONSTRAINT FK_15CDF3B7D24F0E92');
        $this->addSql('ALTER TABLE event_godson DROP CONSTRAINT FK_275484E57C1421C3');
        $this->addSql('DROP SEQUENCE event_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE godparent_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE godson_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE evenement_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE filleul_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE parrain_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE evenement (id INT NOT NULL, organisateur_id INT DEFAULT NULL, participant_id INT NOT NULL, marker_id INT DEFAULT NULL, event_name VARCHAR(255) DEFAULT NULL, evenement_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE filleul (id INT NOT NULL, parrain_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE parrain (id INT NOT NULL, user_id INT DEFAULT NULL, filleul_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_godson');
        $this->addSql('DROP TABLE godparent');
        $this->addSql('DROP TABLE godson');
        $this->addSql('DROP TABLE thread_user_thread');
        $this->addSql('ALTER TABLE marker ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE marker ADD marker_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE marker RENAME COLUMN address TO adress');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307F75C0816C');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307F6061F7CF');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307F59574F23');
        $this->addSql('DROP INDEX IDX_B6BD307F75C0816C');
        $this->addSql('DROP INDEX IDX_B6BD307F6061F7CF');
        $this->addSql('DROP INDEX IDX_B6BD307F59574F23');
        $this->addSql('ALTER TABLE message ADD sender_id INT NOT NULL');
        $this->addSql('ALTER TABLE message ADD sent_to INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message DROP sender_id_id');
        $this->addSql('ALTER TABLE message DROP send_to_id');
        $this->addSql('ALTER TABLE message RENAME COLUMN thread_id_id TO thread_id');
        $this->addSql('ALTER TABLE thread_user DROP CONSTRAINT FK_922CAC79D86650F');
        $this->addSql('DROP INDEX IDX_922CAC79D86650F');
        $this->addSql('ALTER TABLE thread_user ADD thread_id INT NOT NULL');
        $this->addSql('ALTER TABLE thread_user DROP user_id_id');
        $this->addSql('ALTER TABLE "user" RENAME COLUMN is_godparent TO is_parrain');
    }
}
