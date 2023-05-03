<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230502120334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trading_manager_dresseur DROP FOREIGN KEY FK_6F46560AA1A01CBE');
        $this->addSql('ALTER TABLE trading_manager_dresseur DROP FOREIGN KEY FK_6F46560AB09EB8D6');
        $this->addSql('DROP TABLE trading_manager_dresseur');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trading_manager_dresseur (trading_manager_id INT NOT NULL, dresseur_id INT NOT NULL, INDEX IDX_6F46560AA1A01CBE (dresseur_id), INDEX IDX_6F46560AB09EB8D6 (trading_manager_id), PRIMARY KEY(trading_manager_id, dresseur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE trading_manager_dresseur ADD CONSTRAINT FK_6F46560AA1A01CBE FOREIGN KEY (dresseur_id) REFERENCES dresseur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trading_manager_dresseur ADD CONSTRAINT FK_6F46560AB09EB8D6 FOREIGN KEY (trading_manager_id) REFERENCES trading_manager (id) ON DELETE CASCADE');
    }
}
