<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230304104605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, id_personnel_id INT DEFAULT NULL, id_formation_id INT DEFAULT NULL, present TINYINT(1) NOT NULL, INDEX IDX_5E90F6D63FD1E507 (id_personnel_id), INDEX IDX_5E90F6D671C15D5C (id_formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D63FD1E507 FOREIGN KEY (id_personnel_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D671C15D5C FOREIGN KEY (id_formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE user CHANGE image image VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D63FD1E507');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D671C15D5C');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('ALTER TABLE user CHANGE image image VARCHAR(255) DEFAULT NULL');
    }
}
