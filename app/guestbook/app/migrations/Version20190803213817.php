<?php
declare(strict_types=1);

namespace Piv\Guestbook\App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration
 */
final class Version20190803213817 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE messages (message_id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, theme VARCHAR(128) NOT NULL, text LONGTEXT NOT NULL, pictures VARCHAR(128) DEFAULT NULL, filepath VARCHAR(255) DEFAULT NULL, date DATETIME NOT NULL, ip VARCHAR(128) NOT NULL, browser VARCHAR(128) NOT NULL, INDEX IDX_DB021E96A76ED395 (user_id), INDEX search_idx (theme, date), PRIMARY KEY(message_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (user_id INT AUTO_INCREMENT NOT NULL, name VARCHAR(128) NOT NULL, email VARCHAR(128) NOT NULL, INDEX search_idx (email), PRIMARY KEY(user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96A76ED395 FOREIGN KEY (user_id) REFERENCES users (user_id)');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96A76ED395');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP TABLE users');
    }
}
