<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230425134836 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE captured_pokemon (id INT AUTO_INCREMENT NOT NULL, dresseur_id INT NOT NULL, pokemon_id INT NOT NULL, surname VARCHAR(255) DEFAULT NULL, INDEX IDX_C885E5D1A1A01CBE (dresseur_id), INDEX IDX_C885E5D12FE71C3E (pokemon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `dresseur` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pokemon (id INT AUTO_INCREMENT NOT NULL, poke_name VARCHAR(150) NOT NULL, pokedex_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pokemon_specie (id INT AUTO_INCREMENT NOT NULL, dresseur_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, weight VARCHAR(255) NOT NULL, shiny VARCHAR(255) NOT NULL, legendary VARCHAR(255) NOT NULL, INDEX IDX_66C17526A1A01CBE (dresseur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE captured_pokemon ADD CONSTRAINT FK_C885E5D1A1A01CBE FOREIGN KEY (dresseur_id) REFERENCES `dresseur` (id)');
        $this->addSql('ALTER TABLE captured_pokemon ADD CONSTRAINT FK_C885E5D12FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id)');
        $this->addSql('ALTER TABLE pokemon_specie ADD CONSTRAINT FK_66C17526A1A01CBE FOREIGN KEY (dresseur_id) REFERENCES `dresseur` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE captured_pokemon DROP FOREIGN KEY FK_C885E5D1A1A01CBE');
        $this->addSql('ALTER TABLE captured_pokemon DROP FOREIGN KEY FK_C885E5D12FE71C3E');
        $this->addSql('ALTER TABLE pokemon_specie DROP FOREIGN KEY FK_66C17526A1A01CBE');
        $this->addSql('DROP TABLE captured_pokemon');
        $this->addSql('DROP TABLE `dresseur`');
        $this->addSql('DROP TABLE pokemon');
        $this->addSql('DROP TABLE pokemon_specie');
        $this->addSql('DROP TABLE user');
    }
}
