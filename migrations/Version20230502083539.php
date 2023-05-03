<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230502083539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trading_manager (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trading_manager_dresseur (trading_manager_id INT NOT NULL, dresseur_id INT NOT NULL, INDEX IDX_6F46560AB09EB8D6 (trading_manager_id), INDEX IDX_6F46560AA1A01CBE (dresseur_id), PRIMARY KEY(trading_manager_id, dresseur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trading_manager_dresseur ADD CONSTRAINT FK_6F46560AB09EB8D6 FOREIGN KEY (trading_manager_id) REFERENCES trading_manager (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trading_manager_dresseur ADD CONSTRAINT FK_6F46560AA1A01CBE FOREIGN KEY (dresseur_id) REFERENCES `dresseur` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pokemon_specie DROP FOREIGN KEY FK_66C17526A1A01CBE');
        $this->addSql('DROP TABLE pokemon_specie');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pokemon_specie (id INT AUTO_INCREMENT NOT NULL, dresseur_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, color VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, weight VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, shiny VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, legendary VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_66C17526A1A01CBE (dresseur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE pokemon_specie ADD CONSTRAINT FK_66C17526A1A01CBE FOREIGN KEY (dresseur_id) REFERENCES dresseur (id)');
        $this->addSql('ALTER TABLE trading_manager_dresseur DROP FOREIGN KEY FK_6F46560AB09EB8D6');
        $this->addSql('ALTER TABLE trading_manager_dresseur DROP FOREIGN KEY FK_6F46560AA1A01CBE');
        $this->addSql('DROP TABLE trading_manager');
        $this->addSql('DROP TABLE trading_manager_dresseur');
    }
}
