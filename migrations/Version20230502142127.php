<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230502142127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trading_manager ADD captured_pokemon_seller_id INT NOT NULL, ADD captured_pokemon_buyer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trading_manager ADD CONSTRAINT FK_9F38F4D2E42FFB45 FOREIGN KEY (captured_pokemon_seller_id) REFERENCES captured_pokemon (id)');
        $this->addSql('ALTER TABLE trading_manager ADD CONSTRAINT FK_9F38F4D2AD6C35B1 FOREIGN KEY (captured_pokemon_buyer_id) REFERENCES captured_pokemon (id)');
        $this->addSql('CREATE INDEX IDX_9F38F4D2E42FFB45 ON trading_manager (captured_pokemon_seller_id)');
        $this->addSql('CREATE INDEX IDX_9F38F4D2AD6C35B1 ON trading_manager (captured_pokemon_buyer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trading_manager DROP FOREIGN KEY FK_9F38F4D2E42FFB45');
        $this->addSql('ALTER TABLE trading_manager DROP FOREIGN KEY FK_9F38F4D2AD6C35B1');
        $this->addSql('DROP INDEX IDX_9F38F4D2E42FFB45 ON trading_manager');
        $this->addSql('DROP INDEX IDX_9F38F4D2AD6C35B1 ON trading_manager');
        $this->addSql('ALTER TABLE trading_manager DROP captured_pokemon_seller_id, DROP captured_pokemon_buyer_id');
    }
}
