<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230502145238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trading_manager DROP FOREIGN KEY FK_9F38F4D26C755722');
        $this->addSql('ALTER TABLE trading_manager DROP FOREIGN KEY FK_9F38F4D28DE820D9');
        $this->addSql('DROP INDEX IDX_9F38F4D28DE820D9 ON trading_manager');
        $this->addSql('DROP INDEX IDX_9F38F4D26C755722 ON trading_manager');
        $this->addSql('ALTER TABLE trading_manager DROP seller_id, DROP buyer_id, DROP trade_ref');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trading_manager ADD seller_id INT NOT NULL, ADD buyer_id INT DEFAULT NULL, ADD trade_ref VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE trading_manager ADD CONSTRAINT FK_9F38F4D26C755722 FOREIGN KEY (buyer_id) REFERENCES dresseur (id)');
        $this->addSql('ALTER TABLE trading_manager ADD CONSTRAINT FK_9F38F4D28DE820D9 FOREIGN KEY (seller_id) REFERENCES dresseur (id)');
        $this->addSql('CREATE INDEX IDX_9F38F4D28DE820D9 ON trading_manager (seller_id)');
        $this->addSql('CREATE INDEX IDX_9F38F4D26C755722 ON trading_manager (buyer_id)');
    }
}
