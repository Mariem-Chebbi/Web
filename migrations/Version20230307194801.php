<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230307194801 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date DATETIME NOT NULL, auteur VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_categorie (blog_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_EC033E7BDAE07E97 (blog_id), INDEX IDX_EC033E7BBCF5E72D (categorie_id), PRIMARY KEY(blog_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE centre (id INT AUTO_INCREMENT NOT NULL, nom_social VARCHAR(255) NOT NULL, aderesse VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, logo VARCHAR(255) NOT NULL, tel1 VARCHAR(255) NOT NULL, tel2 VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE centre_services (centre_id INT NOT NULL, services_id INT NOT NULL, INDEX IDX_75CC35FD463CD7C3 (centre_id), INDEX IDX_75CC35FDAEF5A6C1 (services_id), PRIMARY KEY(centre_id, services_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE certification (id INT AUTO_INCREMENT NOT NULL, id_formation_id INT DEFAULT NULL, image VARCHAR(255) NOT NULL, date_certif DATETIME NOT NULL, UNIQUE INDEX UNIQ_6C3C6D7571C15D5C (id_formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment_blog (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, blog_id INT DEFAULT NULL, comment VARCHAR(255) NOT NULL, INDEX IDX_E623F3AFA76ED395 (user_id), INDEX IDX_E623F3AFDAE07E97 (blog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE creneau_horaire (id INT AUTO_INCREMENT NOT NULL, heure_debut INT NOT NULL, jour VARCHAR(255) NOT NULL, etat TINYINT(1) NOT NULL, heure_fin INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, nom_event VARCHAR(255) NOT NULL, lieu_event VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorite (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, product_id INT DEFAULT NULL, INDEX IDX_68C58ED9A76ED395 (user_id), INDEX IDX_68C58ED94584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date_formation DATETIME NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, id_personnel_id INT DEFAULT NULL, id_formation_id INT DEFAULT NULL, present TINYINT(1) NOT NULL, INDEX IDX_5E90F6D63FD1E507 (id_personnel_id), INDEX IDX_5E90F6D671C15D5C (id_formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, raiting_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, quantite INT NOT NULL, INDEX IDX_D34A04ADBBA5A3BA (raiting_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE raiting (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, user_id INT DEFAULT NULL, raiting INT NOT NULL, INDEX IDX_3AE2A2094584665A (product_id), INDEX IDX_3AE2A209A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, quantite INT NOT NULL, date_reservation DATETIME NOT NULL, etat VARCHAR(255) NOT NULL, INDEX IDX_42C84955A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_product (reservation_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_B4DFBF28B83297E7 (reservation_id), INDEX IDX_B4DFBF284584665A (product_id), PRIMARY KEY(reservation_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE services (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, icone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sponser (id INT AUTO_INCREMENT NOT NULL, evenement_id INT DEFAULT NULL, nom_sponser VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_7B63215EFD02F13 (evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, num_tel VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, date_naissance DATETIME NOT NULL, image VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_certif (id INT AUTO_INCREMENT NOT NULL, id_personnel_id INT DEFAULT NULL, id_certif_id INT DEFAULT NULL, INDEX IDX_8902834F3FD1E507 (id_personnel_id), INDEX IDX_8902834F63F29423 (id_certif_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog_categorie ADD CONSTRAINT FK_EC033E7BDAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog_categorie ADD CONSTRAINT FK_EC033E7BBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE centre_services ADD CONSTRAINT FK_75CC35FD463CD7C3 FOREIGN KEY (centre_id) REFERENCES centre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE centre_services ADD CONSTRAINT FK_75CC35FDAEF5A6C1 FOREIGN KEY (services_id) REFERENCES services (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE certification ADD CONSTRAINT FK_6C3C6D7571C15D5C FOREIGN KEY (id_formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE comment_blog ADD CONSTRAINT FK_E623F3AFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment_blog ADD CONSTRAINT FK_E623F3AFDAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id)');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED94584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D63FD1E507 FOREIGN KEY (id_personnel_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D671C15D5C FOREIGN KEY (id_formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADBBA5A3BA FOREIGN KEY (raiting_id) REFERENCES raiting (id)');
        $this->addSql('ALTER TABLE raiting ADD CONSTRAINT FK_3AE2A2094584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE raiting ADD CONSTRAINT FK_3AE2A209A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation_product ADD CONSTRAINT FK_B4DFBF28B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_product ADD CONSTRAINT FK_B4DFBF284584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sponser ADD CONSTRAINT FK_7B63215EFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE user_certif ADD CONSTRAINT FK_8902834F3FD1E507 FOREIGN KEY (id_personnel_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_certif ADD CONSTRAINT FK_8902834F63F29423 FOREIGN KEY (id_certif_id) REFERENCES certification (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_categorie DROP FOREIGN KEY FK_EC033E7BDAE07E97');
        $this->addSql('ALTER TABLE blog_categorie DROP FOREIGN KEY FK_EC033E7BBCF5E72D');
        $this->addSql('ALTER TABLE centre_services DROP FOREIGN KEY FK_75CC35FD463CD7C3');
        $this->addSql('ALTER TABLE centre_services DROP FOREIGN KEY FK_75CC35FDAEF5A6C1');
        $this->addSql('ALTER TABLE certification DROP FOREIGN KEY FK_6C3C6D7571C15D5C');
        $this->addSql('ALTER TABLE comment_blog DROP FOREIGN KEY FK_E623F3AFA76ED395');
        $this->addSql('ALTER TABLE comment_blog DROP FOREIGN KEY FK_E623F3AFDAE07E97');
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED9A76ED395');
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED94584665A');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D63FD1E507');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D671C15D5C');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADBBA5A3BA');
        $this->addSql('ALTER TABLE raiting DROP FOREIGN KEY FK_3AE2A2094584665A');
        $this->addSql('ALTER TABLE raiting DROP FOREIGN KEY FK_3AE2A209A76ED395');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('ALTER TABLE reservation_product DROP FOREIGN KEY FK_B4DFBF28B83297E7');
        $this->addSql('ALTER TABLE reservation_product DROP FOREIGN KEY FK_B4DFBF284584665A');
        $this->addSql('ALTER TABLE sponser DROP FOREIGN KEY FK_7B63215EFD02F13');
        $this->addSql('ALTER TABLE user_certif DROP FOREIGN KEY FK_8902834F3FD1E507');
        $this->addSql('ALTER TABLE user_certif DROP FOREIGN KEY FK_8902834F63F29423');
        $this->addSql('DROP TABLE blog');
        $this->addSql('DROP TABLE blog_categorie');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE centre');
        $this->addSql('DROP TABLE centre_services');
        $this->addSql('DROP TABLE certification');
        $this->addSql('DROP TABLE comment_blog');
        $this->addSql('DROP TABLE creneau_horaire');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE favorite');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE raiting');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE reservation_product');
        $this->addSql('DROP TABLE services');
        $this->addSql('DROP TABLE sponser');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_certif');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
