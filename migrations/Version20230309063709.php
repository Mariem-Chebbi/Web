<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230309063709 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE creneau_horaire_user (creneau_horaire_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_E4317B3A1709936 (creneau_horaire_id), INDEX IDX_E4317B3AA76ED395 (user_id), PRIMARY KEY(creneau_horaire_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE creneau_horaire_user ADD CONSTRAINT FK_E4317B3A1709936 FOREIGN KEY (creneau_horaire_id) REFERENCES creneau_horaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE creneau_horaire_user ADD CONSTRAINT FK_E4317B3AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE creneau_horaire DROP FOREIGN KEY FK_521E5DC2463CD7C3');
        $this->addSql('DROP INDEX IDX_521E5DC2463CD7C3 ON creneau_horaire');
        $this->addSql('ALTER TABLE creneau_horaire DROP centre_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE creneau_horaire_user DROP FOREIGN KEY FK_E4317B3A1709936');
        $this->addSql('ALTER TABLE creneau_horaire_user DROP FOREIGN KEY FK_E4317B3AA76ED395');
        $this->addSql('DROP TABLE creneau_horaire_user');
        $this->addSql('ALTER TABLE creneau_horaire ADD centre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE creneau_horaire ADD CONSTRAINT FK_521E5DC2463CD7C3 FOREIGN KEY (centre_id) REFERENCES centre (id)');
        $this->addSql('CREATE INDEX IDX_521E5DC2463CD7C3 ON creneau_horaire (centre_id)');
    }
}
