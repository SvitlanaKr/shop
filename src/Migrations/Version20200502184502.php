<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200502184502 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, model INTEGER DEFAULT NULL, producer INTEGER DEFAULT NULL)');
        $this->addSql('CREATE TABLE delivery (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE payment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE storage (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, count INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE storage_product (storage_id INTEGER NOT NULL, product_id INTEGER NOT NULL, PRIMARY KEY(storage_id, product_id))');
        $this->addSql('CREATE INDEX IDX_A47637CF5CC5DB90 ON storage_product (storage_id)');
        $this->addSql('CREATE INDEX IDX_A47637CF4584665A ON storage_product (product_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE delivery');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE storage');
        $this->addSql('DROP TABLE storage_product');
    }
}
