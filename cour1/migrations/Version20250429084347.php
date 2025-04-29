<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250429084347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initial migration for licences table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE licences (id SERIAL NOT NULL, tenant VARCHAR(100) NOT NULL, name VARCHAR(100) DEFAULT NULL, client_id SMALLINT DEFAULT NULL, api_name VARCHAR(100) NOT NULL, licence_key VARCHAR(255) DEFAULT NULL, status VARCHAR(100) NOT NULL, creation_date DATE NOT NULL, expiration_date DATE NOT NULL, usage_limite INT NOT NULL, usage_count BIGINT DEFAULT NULL, rate_limit INT NOT NULL, last_used_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_by UUID NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN licences.last_used_at IS '(DC2Type:datetime_immutable)'
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE licences
        SQL);
    }
}
