<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230504140513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trade (id INT AUTO_INCREMENT NOT NULL, pokemon_id INT DEFAULT NULL, captured_pokemon_seller_id INT NOT NULL, captured_pokemon_buyer_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(255) NOT NULL, INDEX IDX_7E1A43662FE71C3E (pokemon_id), INDEX IDX_7E1A4366E42FFB45 (captured_pokemon_seller_id), INDEX IDX_7E1A4366AD6C35B1 (captured_pokemon_buyer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trade ADD CONSTRAINT FK_7E1A43662FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id)');
        $this->addSql('ALTER TABLE trade ADD CONSTRAINT FK_7E1A4366E42FFB45 FOREIGN KEY (captured_pokemon_seller_id) REFERENCES captured_pokemon (id)');
        $this->addSql('ALTER TABLE trade ADD CONSTRAINT FK_7E1A4366AD6C35B1 FOREIGN KEY (captured_pokemon_buyer_id) REFERENCES captured_pokemon (id)');
        $this->addSql('ALTER TABLE trading_manager DROP FOREIGN KEY FK_9F38F4D22FE71C3E');
        $this->addSql('ALTER TABLE trading_manager DROP FOREIGN KEY FK_9F38F4D2AD6C35B1');
        $this->addSql('ALTER TABLE trading_manager DROP FOREIGN KEY FK_9F38F4D2E42FFB45');
        $this->addSql('DROP TABLE trading_manager');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trading_manager (id INT AUTO_INCREMENT NOT NULL, pokemon_id INT DEFAULT NULL, captured_pokemon_seller_id INT NOT NULL, captured_pokemon_buyer_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_9F38F4D2AD6C35B1 (captured_pokemon_buyer_id), INDEX IDX_9F38F4D22FE71C3E (pokemon_id), INDEX IDX_9F38F4D2E42FFB45 (captured_pokemon_seller_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE trading_manager ADD CONSTRAINT FK_9F38F4D22FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id)');
        $this->addSql('ALTER TABLE trading_manager ADD CONSTRAINT FK_9F38F4D2AD6C35B1 FOREIGN KEY (captured_pokemon_buyer_id) REFERENCES captured_pokemon (id)');
        $this->addSql('ALTER TABLE trading_manager ADD CONSTRAINT FK_9F38F4D2E42FFB45 FOREIGN KEY (captured_pokemon_seller_id) REFERENCES captured_pokemon (id)');
        $this->addSql('ALTER TABLE trade DROP FOREIGN KEY FK_7E1A43662FE71C3E');
        $this->addSql('ALTER TABLE trade DROP FOREIGN KEY FK_7E1A4366E42FFB45');
        $this->addSql('ALTER TABLE trade DROP FOREIGN KEY FK_7E1A4366AD6C35B1');
        $this->addSql('DROP TABLE trade');
    }
}
