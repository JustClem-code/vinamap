<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240723185429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE product (id INT NOT NULL, appellation_id INT DEFAULT NULL, user_email_id INT NOT NULL, name VARCHAR(255) NOT NULL, manufacturer VARCHAR(255) NOT NULL, vintage INT DEFAULT NULL, review TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D34A04AD7CDE30DD ON product (appellation_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD48BF25C9 ON product (user_email_id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD7CDE30DD FOREIGN KEY (appellation_id) REFERENCES appellation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD48BF25C9 FOREIGN KEY (user_email_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('ALTER TABLE product DROP CONSTRAINT FK_D34A04AD7CDE30DD');
        $this->addSql('ALTER TABLE product DROP CONSTRAINT FK_D34A04AD48BF25C9');
        $this->addSql('DROP TABLE product');
    }
}
