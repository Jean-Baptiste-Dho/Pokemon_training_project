<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230502121743 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trading_manager ADD seller_id_id INT NOT NULL, ADD status VARCHAR(255) NOT NULL, ADD traided_pokemon VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE trading_manager ADD CONSTRAINT FK_9F38F4D2DF4C85EA FOREIGN KEY (seller_id_id) REFERENCES `dresseur` (id)');
        $this->addSql('CREATE INDEX IDX_9F38F4D2DF4C85EA ON trading_manager (seller_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trading_manager DROP FOREIGN KEY FK_9F38F4D2DF4C85EA');
        $this->addSql('DROP INDEX IDX_9F38F4D2DF4C85EA ON trading_manager');
        $this->addSql('ALTER TABLE trading_manager DROP seller_id_id, DROP status, DROP traided_pokemon');
    }
}
