<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230427090200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dresseur ADD user_pseudo_id INT NOT NULL');
        $this->addSql('ALTER TABLE dresseur ADD CONSTRAINT FK_77EA2FC620031926 FOREIGN KEY (user_pseudo_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_77EA2FC620031926 ON dresseur (user_pseudo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `dresseur` DROP FOREIGN KEY FK_77EA2FC620031926');
        $this->addSql('DROP INDEX UNIQ_77EA2FC620031926 ON `dresseur`');
        $this->addSql('ALTER TABLE `dresseur` DROP user_pseudo_id');
    }
}
