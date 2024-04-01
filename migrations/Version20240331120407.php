<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240331120407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appellation_grape_variety (appellation_id INT NOT NULL, grape_variety_id INT NOT NULL, PRIMARY KEY(appellation_id, grape_variety_id))');
        $this->addSql('CREATE INDEX IDX_A11D6B387CDE30DD ON appellation_grape_variety (appellation_id)');
        $this->addSql('CREATE INDEX IDX_A11D6B38ED00A18A ON appellation_grape_variety (grape_variety_id)');
        $this->addSql('ALTER TABLE appellation_grape_variety ADD CONSTRAINT FK_A11D6B387CDE30DD FOREIGN KEY (appellation_id) REFERENCES appellation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE appellation_grape_variety ADD CONSTRAINT FK_A11D6B38ED00A18A FOREIGN KEY (grape_variety_id) REFERENCES grape_variety (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE appellation_grape_variety DROP CONSTRAINT FK_A11D6B387CDE30DD');
        $this->addSql('ALTER TABLE appellation_grape_variety DROP CONSTRAINT FK_A11D6B38ED00A18A');
        $this->addSql('DROP TABLE appellation_grape_variety');
    }
}
