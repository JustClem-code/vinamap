<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240406151912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE sub_wine_region_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE sub_wine_region (id INT NOT NULL, wineregion_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_130291DA364B0D36 ON sub_wine_region (wineregion_id)');
        $this->addSql('ALTER TABLE sub_wine_region ADD CONSTRAINT FK_130291DA364B0D36 FOREIGN KEY (wineregion_id) REFERENCES wine_region (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE sub_wine_region_id_seq CASCADE');
        $this->addSql('ALTER TABLE sub_wine_region DROP CONSTRAINT FK_130291DA364B0D36');
        $this->addSql('DROP TABLE sub_wine_region');
    }
}
