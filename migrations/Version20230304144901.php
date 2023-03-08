<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230304144901 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE raiting (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, user_id INT DEFAULT NULL, raiting INT NOT NULL, INDEX IDX_3AE2A2094584665A (product_id), INDEX IDX_3AE2A209A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE raiting ADD CONSTRAINT FK_3AE2A2094584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE raiting ADD CONSTRAINT FK_3AE2A209A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE product ADD raiting_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADBBA5A3BA FOREIGN KEY (raiting_id) REFERENCES raiting (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADBBA5A3BA ON product (raiting_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADBBA5A3BA');
        $this->addSql('ALTER TABLE raiting DROP FOREIGN KEY FK_3AE2A2094584665A');
        $this->addSql('ALTER TABLE raiting DROP FOREIGN KEY FK_3AE2A209A76ED395');
        $this->addSql('DROP TABLE raiting');
        $this->addSql('DROP INDEX IDX_D34A04ADBBA5A3BA ON product');
        $this->addSql('ALTER TABLE product DROP raiting_id');
    }
}
