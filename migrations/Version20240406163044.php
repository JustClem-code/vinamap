<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240406163044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appellation ADD subwineregion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE appellation ADD CONSTRAINT FK_187A5B987B4228A9 FOREIGN KEY (subwineregion_id) REFERENCES sub_wine_region (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_187A5B987B4228A9 ON appellation (subwineregion_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE appellation DROP CONSTRAINT FK_187A5B987B4228A9');
        $this->addSql('DROP INDEX IDX_187A5B987B4228A9');
        $this->addSql('ALTER TABLE appellation DROP subwineregion_id');
    }
}
