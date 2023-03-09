<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230309062245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE creneau_horaire ADD centre_id INT DEFAULT NULL, CHANGE heure_debut heure_debut INT DEFAULT NULL, CHANGE jour jour VARCHAR(255) DEFAULT NULL, CHANGE etat etat TINYINT(1) DEFAULT NULL, CHANGE heure_fin heure_fin INT DEFAULT NULL');
        $this->addSql('ALTER TABLE creneau_horaire ADD CONSTRAINT FK_521E5DC2463CD7C3 FOREIGN KEY (centre_id) REFERENCES centre (id)');
        $this->addSql('CREATE INDEX IDX_521E5DC2463CD7C3 ON creneau_horaire (centre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE creneau_horaire DROP FOREIGN KEY FK_521E5DC2463CD7C3');
        $this->addSql('DROP INDEX IDX_521E5DC2463CD7C3 ON creneau_horaire');
        $this->addSql('ALTER TABLE creneau_horaire DROP centre_id, CHANGE heure_debut heure_debut INT NOT NULL, CHANGE jour jour VARCHAR(255) NOT NULL, CHANGE etat etat TINYINT(1) NOT NULL, CHANGE heure_fin heure_fin INT NOT NULL');
    }
}
