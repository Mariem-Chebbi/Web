<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230219135239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog_categorie (blog_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_EC033E7BDAE07E97 (blog_id), INDEX IDX_EC033E7BBCF5E72D (categorie_id), PRIMARY KEY(blog_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog_categorie ADD CONSTRAINT FK_EC033E7BDAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog_categorie ADD CONSTRAINT FK_EC033E7BBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog DROP categorie_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_categorie DROP FOREIGN KEY FK_EC033E7BDAE07E97');
        $this->addSql('ALTER TABLE blog_categorie DROP FOREIGN KEY FK_EC033E7BBCF5E72D');
        $this->addSql('DROP TABLE blog_categorie');
        $this->addSql('ALTER TABLE blog ADD categorie_id INT DEFAULT NULL');
    }
}
