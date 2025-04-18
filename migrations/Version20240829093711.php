<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240829093711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE description (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE new_cook_book ADD description_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE new_cook_book ADD CONSTRAINT FK_F79CF915656842B5 FOREIGN KEY (description_id_id) REFERENCES description (id)');
        $this->addSql('CREATE INDEX IDX_F79CF915656842B5 ON new_cook_book (description_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE new_cook_book DROP FOREIGN KEY FK_F79CF915656842B5');
        $this->addSql('DROP TABLE description');
        $this->addSql('DROP INDEX IDX_F79CF915656842B5 ON new_cook_book');
        $this->addSql('ALTER TABLE new_cook_book DROP description_id_id');
    }
}
