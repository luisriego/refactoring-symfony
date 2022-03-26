<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220326132245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates `condo` table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE condo (id CHAR(36) NOT NULL, name VARCHAR(100) NOT NULL, tax_code CHAR(14) NOT NULL, is_active BOOLEAN NOT NULL, created_on TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE condo');
    }
}
