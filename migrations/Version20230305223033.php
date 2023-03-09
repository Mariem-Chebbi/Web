<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230305223033 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment_blog (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, blog_id INT DEFAULT NULL, comment VARCHAR(255) NOT NULL, INDEX IDX_E623F3AFA76ED395 (user_id), INDEX IDX_E623F3AFDAE07E97 (blog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment_blog ADD CONSTRAINT FK_E623F3AFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment_blog ADD CONSTRAINT FK_E623F3AFDAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id)');
        $this->addSql('ALTER TABLE user CHANGE image image VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment_blog DROP FOREIGN KEY FK_E623F3AFA76ED395');
        $this->addSql('ALTER TABLE comment_blog DROP FOREIGN KEY FK_E623F3AFDAE07E97');
        $this->addSql('DROP TABLE comment_blog');
        $this->addSql('ALTER TABLE user CHANGE image image VARCHAR(255) DEFAULT NULL');
    }
}
