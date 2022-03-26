<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20220326172347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Relationships between condo and user tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE condo_user (condo_id CHAR(36) NOT NULL, user_id CHAR(36) NOT NULL, PRIMARY KEY(condo_id, user_id))');
        $this->addSql('CREATE INDEX IDX_F2EAFCFE2B100ED ON condo_user (condo_id)');
        $this->addSql('CREATE INDEX IDX_F2EAFCFA76ED395 ON condo_user (user_id)');
        $this->addSql('ALTER TABLE condo_user ADD CONSTRAINT FK_F2EAFCFE2B100ED FOREIGN KEY (condo_id) REFERENCES "condo" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE condo_user ADD CONSTRAINT FK_F2EAFCFA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD first_name VARCHAR(55) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD last_name VARCHAR(55) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD avatar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD is_active BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD created_on TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE condo_user');
        $this->addSql('ALTER TABLE "user" DROP first_name');
        $this->addSql('ALTER TABLE "user" DROP last_name');
        $this->addSql('ALTER TABLE "user" DROP avatar');
        $this->addSql('ALTER TABLE "user" DROP is_active');
        $this->addSql('ALTER TABLE "user" DROP created_on');
    }
}
