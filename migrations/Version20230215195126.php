<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230215195126 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, quantite INT NOT NULL, date_reservation VARCHAR(255) NOT NULL, etat VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_product (reservation_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_B4DFBF28B83297E7 (reservation_id), INDEX IDX_B4DFBF284584665A (product_id), PRIMARY KEY(reservation_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation_product ADD CONSTRAINT FK_B4DFBF28B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_product ADD CONSTRAINT FK_B4DFBF284584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_product DROP FOREIGN KEY FK_B4DFBF28B83297E7');
        $this->addSql('ALTER TABLE reservation_product DROP FOREIGN KEY FK_B4DFBF284584665A');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE reservation_product');
    }
}
