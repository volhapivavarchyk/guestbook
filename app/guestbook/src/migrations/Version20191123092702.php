<?php

declare(strict_types=1);

namespace Piv\Guestbook\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191123092702 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE messages ADD annotation_for_id INT NOT NULL');
        $this->addSql('ALTER TABLE users ADD password VARCHAR(128) NOT NULL, ADD role VARCHAR(10) NOT NULL, ADD api_token VARCHAR(255) DEFAULT NULL, CHANGE name username VARCHAR(128) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E97BA2F5EB ON users (api_token)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE messages DROP annotation_for_id');
        $this->addSql('DROP INDEX UNIQ_1483A5E97BA2F5EB ON users');
        $this->addSql('ALTER TABLE users ADD name VARCHAR(128) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, DROP username, DROP password, DROP role, DROP api_token');
    }
}
