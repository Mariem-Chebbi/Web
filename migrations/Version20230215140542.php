<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230215140542 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actualite (id INT AUTO_INCREMENT NOT NULL, id_categorie_id INT DEFAULT NULL, id_super_admin_id INT DEFAULT NULL, libelle VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, date DATE DEFAULT NULL, auteur VARCHAR(255) DEFAULT NULL, INDEX IDX_549281979F34925F (id_categorie_id), INDEX IDX_54928197869FA03D (id_super_admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, id_client_id INT DEFAULT NULL, id_centre_id INT DEFAULT NULL, note INT NOT NULL, INDEX IDX_8F91ABF099DED506 (id_client_id), INDEX IDX_8F91ABF0C6096BE4 (id_centre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE centre (id INT AUTO_INCREMENT NOT NULL, id_admin_centre_id INT DEFAULT NULL, nom_social VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, tel1 VARCHAR(255) DEFAULT NULL, tel2 VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_C6A0EA7546951179 (id_admin_centre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE certification (id INT AUTO_INCREMENT NOT NULL, id_formation_id INT DEFAULT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_6C3C6D7571C15D5C (id_formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, id_client_id INT DEFAULT NULL, id_centre_id INT DEFAULT NULL, commentaire VARCHAR(255) NOT NULL, INDEX IDX_67F068BC99DED506 (id_client_id), INDEX IDX_67F068BCC6096BE4 (id_centre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE creneau_horaire (id INT AUTO_INCREMENT NOT NULL, id_assistant_psy_id INT DEFAULT NULL, heure INT DEFAULT NULL, jour VARCHAR(255) DEFAULT NULL, etat TINYINT(1) DEFAULT NULL, INDEX IDX_521E5DC2E01AD1BC (id_assistant_psy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE documentation (id INT AUTO_INCREMENT NOT NULL, id_super_admin_id INT DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_73D5A93B869FA03D (id_super_admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, nom_event VARCHAR(255) DEFAULT NULL, desc_event VARCHAR(255) DEFAULT NULL, date_debut DATE DEFAULT NULL, date_fin DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, date_formation DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, id_centre_id INT DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, INDEX IDX_C53D045FC6096BE4 (id_centre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, id_formation_id INT DEFAULT NULL, id_personnel_id INT DEFAULT NULL, date_inscription DATE NOT NULL, INDEX IDX_5E90F6D671C15D5C (id_formation_id), INDEX IDX_5E90F6D63FD1E507 (id_personnel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liste_attente (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, id_client_id INT DEFAULT NULL, id_personnel_id INT DEFAULT NULL, date_notification DATE DEFAULT NULL, message VARCHAR(255) DEFAULT NULL, INDEX IDX_BF5476CA99DED506 (id_client_id), INDEX IDX_BF5476CA3FD1E507 (id_personnel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendez_vous (id INT AUTO_INCREMENT NOT NULL, id_client_id INT DEFAULT NULL, id_assistant_psy_id INT DEFAULT NULL, id_liste_attente_id INT DEFAULT NULL, date_rdv DATE DEFAULT NULL, INDEX IDX_65E8AA0A99DED506 (id_client_id), INDEX IDX_65E8AA0AE01AD1BC (id_assistant_psy_id), INDEX IDX_65E8AA0ADB4092B8 (id_liste_attente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sponsor (id INT AUTO_INCREMENT NOT NULL, id_event_id INT DEFAULT NULL, nom_sponsor VARCHAR(255) DEFAULT NULL, logo_sponsor VARCHAR(255) DEFAULT NULL, INDEX IDX_818CC9D4212C041E (id_event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, id_produit_id INT DEFAULT NULL, id_centre_id INT DEFAULT NULL, qte INT NOT NULL, INDEX IDX_4B365660AABEFE2C (id_produit_id), INDEX IDX_4B365660C6096BE4 (id_centre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, id_centre_id INT DEFAULT NULL, email VARCHAR(255) NOT NULL, prenom VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, mot_de_passe VARCHAR(255) NOT NULL, num_tel VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, Type_utilisateur VARCHAR(255) NOT NULL, genre VARCHAR(255) DEFAULT NULL, cin VARCHAR(255) DEFAULT NULL, INDEX IDX_1D1C63B3C6096BE4 (id_centre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE actualite ADD CONSTRAINT FK_549281979F34925F FOREIGN KEY (id_categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE actualite ADD CONSTRAINT FK_54928197869FA03D FOREIGN KEY (id_super_admin_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF099DED506 FOREIGN KEY (id_client_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0C6096BE4 FOREIGN KEY (id_centre_id) REFERENCES centre (id)');
        $this->addSql('ALTER TABLE centre ADD CONSTRAINT FK_C6A0EA7546951179 FOREIGN KEY (id_admin_centre_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE certification ADD CONSTRAINT FK_6C3C6D7571C15D5C FOREIGN KEY (id_formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC99DED506 FOREIGN KEY (id_client_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCC6096BE4 FOREIGN KEY (id_centre_id) REFERENCES centre (id)');
        $this->addSql('ALTER TABLE creneau_horaire ADD CONSTRAINT FK_521E5DC2E01AD1BC FOREIGN KEY (id_assistant_psy_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE documentation ADD CONSTRAINT FK_73D5A93B869FA03D FOREIGN KEY (id_super_admin_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FC6096BE4 FOREIGN KEY (id_centre_id) REFERENCES centre (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D671C15D5C FOREIGN KEY (id_formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D63FD1E507 FOREIGN KEY (id_personnel_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA99DED506 FOREIGN KEY (id_client_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA3FD1E507 FOREIGN KEY (id_personnel_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A99DED506 FOREIGN KEY (id_client_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0AE01AD1BC FOREIGN KEY (id_assistant_psy_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0ADB4092B8 FOREIGN KEY (id_liste_attente_id) REFERENCES liste_attente (id)');
        $this->addSql('ALTER TABLE sponsor ADD CONSTRAINT FK_818CC9D4212C041E FOREIGN KEY (id_event_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660AABEFE2C FOREIGN KEY (id_produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660C6096BE4 FOREIGN KEY (id_centre_id) REFERENCES centre (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3C6096BE4 FOREIGN KEY (id_centre_id) REFERENCES centre (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actualite DROP FOREIGN KEY FK_549281979F34925F');
        $this->addSql('ALTER TABLE actualite DROP FOREIGN KEY FK_54928197869FA03D');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF099DED506');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0C6096BE4');
        $this->addSql('ALTER TABLE centre DROP FOREIGN KEY FK_C6A0EA7546951179');
        $this->addSql('ALTER TABLE certification DROP FOREIGN KEY FK_6C3C6D7571C15D5C');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC99DED506');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCC6096BE4');
        $this->addSql('ALTER TABLE creneau_horaire DROP FOREIGN KEY FK_521E5DC2E01AD1BC');
        $this->addSql('ALTER TABLE documentation DROP FOREIGN KEY FK_73D5A93B869FA03D');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FC6096BE4');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D671C15D5C');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D63FD1E507');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA99DED506');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA3FD1E507');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A99DED506');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0AE01AD1BC');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0ADB4092B8');
        $this->addSql('ALTER TABLE sponsor DROP FOREIGN KEY FK_818CC9D4212C041E');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660AABEFE2C');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660C6096BE4');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3C6096BE4');
        $this->addSql('DROP TABLE actualite');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE centre');
        $this->addSql('DROP TABLE certification');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE creneau_horaire');
        $this->addSql('DROP TABLE documentation');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE liste_attente');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE rendez_vous');
        $this->addSql('DROP TABLE sponsor');
        $this->addSql('DROP TABLE stock');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
