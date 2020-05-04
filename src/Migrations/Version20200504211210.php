<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200504211210 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE "order" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, payment_id INTEGER DEFAULT NULL, delivery_id INTEGER DEFAULT NULL, created_at DATETIME NOT NULL, status VARCHAR(255) NOT NULL, total_price INTEGER DEFAULT NULL, description VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON "order" (user_id)');
        $this->addSql('CREATE INDEX IDX_F52993984C3A3BB ON "order" (payment_id)');
        $this->addSql('CREATE INDEX IDX_F529939812136921 ON "order" (delivery_id)');
        $this->addSql('DROP INDEX IDX_A47637CF4584665A');
        $this->addSql('DROP INDEX IDX_A47637CF5CC5DB90');
        $this->addSql('CREATE TEMPORARY TABLE __temp__storage_product AS SELECT id, storage_id, product_id, count FROM storage_product');
        $this->addSql('DROP TABLE storage_product');
        $this->addSql('CREATE TABLE storage_product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, storage_id INTEGER DEFAULT NULL, product_id INTEGER DEFAULT NULL, count INTEGER NOT NULL, CONSTRAINT FK_A47637CF5CC5DB90 FOREIGN KEY (storage_id) REFERENCES storage (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_A47637CF4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO storage_product (id, storage_id, product_id, count) SELECT id, storage_id, product_id, count FROM __temp__storage_product');
        $this->addSql('DROP TABLE __temp__storage_product');
        $this->addSql('CREATE INDEX IDX_A47637CF4584665A ON storage_product (product_id)');
        $this->addSql('CREATE INDEX IDX_A47637CF5CC5DB90 ON storage_product (storage_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE "order"');
        $this->addSql('DROP INDEX IDX_A47637CF5CC5DB90');
        $this->addSql('DROP INDEX IDX_A47637CF4584665A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__storage_product AS SELECT id, storage_id, product_id, count FROM storage_product');
        $this->addSql('DROP TABLE storage_product');
        $this->addSql('CREATE TABLE storage_product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, storage_id INTEGER DEFAULT NULL, product_id INTEGER DEFAULT NULL, count INTEGER NOT NULL)');
        $this->addSql('INSERT INTO storage_product (id, storage_id, product_id, count) SELECT id, storage_id, product_id, count FROM __temp__storage_product');
        $this->addSql('DROP TABLE __temp__storage_product');
        $this->addSql('CREATE INDEX IDX_A47637CF5CC5DB90 ON storage_product (storage_id)');
        $this->addSql('CREATE INDEX IDX_A47637CF4584665A ON storage_product (product_id)');
    }
}
