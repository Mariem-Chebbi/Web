<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230222125211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rendez_vous ADD id_personnel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A3FD1E507 FOREIGN KEY (id_personnel_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_65E8AA0A3FD1E507 ON rendez_vous (id_personnel_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A3FD1E507');
        $this->addSql('DROP INDEX IDX_65E8AA0A3FD1E507 ON rendez_vous');
        $this->addSql('ALTER TABLE rendez_vous DROP id_personnel_id');
    }
}
