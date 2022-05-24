<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220523194018 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939813481D2B');
        $this->addSql('DROP INDEX IDX_F529939813481D2B ON `order`');
        $this->addSql('ALTER TABLE `order` CHANGE farmer_id farm_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939865FCFA0D FOREIGN KEY (farm_id) REFERENCES farm (id)');
        $this->addSql('CREATE INDEX IDX_F529939865FCFA0D ON `order` (farm_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939865FCFA0D');
        $this->addSql('DROP INDEX IDX_F529939865FCFA0D ON `order`');
        $this->addSql('ALTER TABLE `order` CHANGE farm_id farmer_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939813481D2B FOREIGN KEY (farmer_id) REFERENCES farm (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_F529939813481D2B ON `order` (farmer_id)');
    }
}
