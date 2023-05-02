<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230427093234 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dresseur DROP FOREIGN KEY FK_77EA2FC620031926');
        $this->addSql('DROP INDEX UNIQ_77EA2FC620031926 ON dresseur');
        $this->addSql('ALTER TABLE dresseur ADD email VARCHAR(180) NOT NULL, ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', DROP user_pseudo_id, CHANGE name name VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_77EA2FC6E7927C74 ON dresseur (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_77EA2FC6E7927C74 ON `dresseur`');
        $this->addSql('ALTER TABLE `dresseur` ADD user_pseudo_id INT NOT NULL, DROP email, DROP roles, CHANGE name name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE `dresseur` ADD CONSTRAINT FK_77EA2FC620031926 FOREIGN KEY (user_pseudo_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_77EA2FC620031926 ON `dresseur` (user_pseudo_id)');
    }
}
