<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230502122412 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trading_manager ADD pokemon_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trading_manager ADD CONSTRAINT FK_9F38F4D22FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id)');
        $this->addSql('CREATE INDEX IDX_9F38F4D22FE71C3E ON trading_manager (pokemon_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trading_manager DROP FOREIGN KEY FK_9F38F4D22FE71C3E');
        $this->addSql('DROP INDEX IDX_9F38F4D22FE71C3E ON trading_manager');
        $this->addSql('ALTER TABLE trading_manager DROP pokemon_id');
    }
}
