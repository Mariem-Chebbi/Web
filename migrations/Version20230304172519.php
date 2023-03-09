<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230304172519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_certif (id INT AUTO_INCREMENT NOT NULL, id_personnel_id INT DEFAULT NULL, id_certif_id INT DEFAULT NULL, INDEX IDX_8902834F3FD1E507 (id_personnel_id), INDEX IDX_8902834F63F29423 (id_certif_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_certif ADD CONSTRAINT FK_8902834F3FD1E507 FOREIGN KEY (id_personnel_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_certif ADD CONSTRAINT FK_8902834F63F29423 FOREIGN KEY (id_certif_id) REFERENCES certification (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_certif DROP FOREIGN KEY FK_8902834F3FD1E507');
        $this->addSql('ALTER TABLE user_certif DROP FOREIGN KEY FK_8902834F63F29423');
        $this->addSql('DROP TABLE user_certif');
    }
}
