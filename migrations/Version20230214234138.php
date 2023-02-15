<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230214234138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, id_client_id INT DEFAULT NULL, id_centre_id INT DEFAULT NULL, note INT NOT NULL, INDEX IDX_8F91ABF099DED506 (id_client_id), INDEX IDX_8F91ABF0C6096BE4 (id_centre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE certification (id INT AUTO_INCREMENT NOT NULL, id_formation_id INT DEFAULT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_6C3C6D7571C15D5C (id_formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, id_client_id INT DEFAULT NULL, id_centre_id INT DEFAULT NULL, commentaire VARCHAR(255) NOT NULL, INDEX IDX_67F068BC99DED506 (id_client_id), INDEX IDX_67F068BCC6096BE4 (id_centre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, date_formation DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, id_formation_id INT DEFAULT NULL, id_personnel_id INT DEFAULT NULL, date_inscription DATE NOT NULL, INDEX IDX_5E90F6D671C15D5C (id_formation_id), INDEX IDX_5E90F6D63FD1E507 (id_personnel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendez_vous (id INT AUTO_INCREMENT NOT NULL, id_client_id INT DEFAULT NULL, id_assistant_psy_id INT DEFAULT NULL, id_liste_attente_id INT DEFAULT NULL, date_rdv DATE DEFAULT NULL, INDEX IDX_65E8AA0A99DED506 (id_client_id), INDEX IDX_65E8AA0AE01AD1BC (id_assistant_psy_id), INDEX IDX_65E8AA0ADB4092B8 (id_liste_attente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, id_produit_id INT DEFAULT NULL, id_centre_id INT DEFAULT NULL, qte INT NOT NULL, INDEX IDX_4B365660AABEFE2C (id_produit_id), INDEX IDX_4B365660C6096BE4 (id_centre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF099DED506 FOREIGN KEY (id_client_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0C6096BE4 FOREIGN KEY (id_centre_id) REFERENCES centre (id)');
        $this->addSql('ALTER TABLE certification ADD CONSTRAINT FK_6C3C6D7571C15D5C FOREIGN KEY (id_formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC99DED506 FOREIGN KEY (id_client_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCC6096BE4 FOREIGN KEY (id_centre_id) REFERENCES centre (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D671C15D5C FOREIGN KEY (id_formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D63FD1E507 FOREIGN KEY (id_personnel_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A99DED506 FOREIGN KEY (id_client_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0AE01AD1BC FOREIGN KEY (id_assistant_psy_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0ADB4092B8 FOREIGN KEY (id_liste_attente_id) REFERENCES liste_attente (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660AABEFE2C FOREIGN KEY (id_produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660C6096BE4 FOREIGN KEY (id_centre_id) REFERENCES centre (id)');
        $this->addSql('ALTER TABLE actualite ADD id_super_admin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE actualite ADD CONSTRAINT FK_54928197869FA03D FOREIGN KEY (id_super_admin_id) REFERENCES super_administrateur (id)');
        $this->addSql('CREATE INDEX IDX_54928197869FA03D ON actualite (id_super_admin_id)');
        $this->addSql('ALTER TABLE centre ADD id_admin_centre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE centre ADD CONSTRAINT FK_C6A0EA7546951179 FOREIGN KEY (id_admin_centre_id) REFERENCES personnel (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C6A0EA7546951179 ON centre (id_admin_centre_id)');
        $this->addSql('ALTER TABLE creneau_horaire ADD id_assistant_psy_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE creneau_horaire ADD CONSTRAINT FK_521E5DC2E01AD1BC FOREIGN KEY (id_assistant_psy_id) REFERENCES personnel (id)');
        $this->addSql('CREATE INDEX IDX_521E5DC2E01AD1BC ON creneau_horaire (id_assistant_psy_id)');
        $this->addSql('ALTER TABLE documentation ADD id_super_admin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE documentation ADD CONSTRAINT FK_73D5A93B869FA03D FOREIGN KEY (id_super_admin_id) REFERENCES super_administrateur (id)');
        $this->addSql('CREATE INDEX IDX_73D5A93B869FA03D ON documentation (id_super_admin_id)');
        $this->addSql('ALTER TABLE notification ADD id_client_id INT DEFAULT NULL, ADD id_personnel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA99DED506 FOREIGN KEY (id_client_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA3FD1E507 FOREIGN KEY (id_personnel_id) REFERENCES personnel (id)');
        $this->addSql('CREATE INDEX IDX_BF5476CA99DED506 ON notification (id_client_id)');
        $this->addSql('CREATE INDEX IDX_BF5476CA3FD1E507 ON notification (id_personnel_id)');
        $this->addSql('ALTER TABLE personnel ADD id_centre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personnel ADD CONSTRAINT FK_A6BCF3DEC6096BE4 FOREIGN KEY (id_centre_id) REFERENCES centre (id)');
        $this->addSql('CREATE INDEX IDX_A6BCF3DEC6096BE4 ON personnel (id_centre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF099DED506');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0C6096BE4');
        $this->addSql('ALTER TABLE certification DROP FOREIGN KEY FK_6C3C6D7571C15D5C');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC99DED506');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCC6096BE4');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D671C15D5C');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D63FD1E507');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A99DED506');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0AE01AD1BC');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0ADB4092B8');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660AABEFE2C');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660C6096BE4');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE certification');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE rendez_vous');
        $this->addSql('DROP TABLE stock');
        $this->addSql('ALTER TABLE actualite DROP FOREIGN KEY FK_54928197869FA03D');
        $this->addSql('DROP INDEX IDX_54928197869FA03D ON actualite');
        $this->addSql('ALTER TABLE actualite DROP id_super_admin_id');
        $this->addSql('ALTER TABLE centre DROP FOREIGN KEY FK_C6A0EA7546951179');
        $this->addSql('DROP INDEX UNIQ_C6A0EA7546951179 ON centre');
        $this->addSql('ALTER TABLE centre DROP id_admin_centre_id');
        $this->addSql('ALTER TABLE creneau_horaire DROP FOREIGN KEY FK_521E5DC2E01AD1BC');
        $this->addSql('DROP INDEX IDX_521E5DC2E01AD1BC ON creneau_horaire');
        $this->addSql('ALTER TABLE creneau_horaire DROP id_assistant_psy_id');
        $this->addSql('ALTER TABLE documentation DROP FOREIGN KEY FK_73D5A93B869FA03D');
        $this->addSql('DROP INDEX IDX_73D5A93B869FA03D ON documentation');
        $this->addSql('ALTER TABLE documentation DROP id_super_admin_id');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA99DED506');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA3FD1E507');
        $this->addSql('DROP INDEX IDX_BF5476CA99DED506 ON notification');
        $this->addSql('DROP INDEX IDX_BF5476CA3FD1E507 ON notification');
        $this->addSql('ALTER TABLE notification DROP id_client_id, DROP id_personnel_id');
        $this->addSql('ALTER TABLE personnel DROP FOREIGN KEY FK_A6BCF3DEC6096BE4');
        $this->addSql('DROP INDEX IDX_A6BCF3DEC6096BE4 ON personnel');
        $this->addSql('ALTER TABLE personnel DROP id_centre_id');
    }
}
