<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220528140657 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE farm_pictures DROP FOREIGN KEY FK_D777799A65FCFA0D');
        $this->addSql('ALTER TABLE farm_pictures ADD CONSTRAINT FK_D777799A65FCFA0D FOREIGN KEY (farm_id) REFERENCES farm (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94D4584665A');
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94DC72F7599');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94D4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94DC72F7599 FOREIGN KEY (ordor_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939865FCFA0D');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939890523730');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939865FCFA0D FOREIGN KEY (farm_id) REFERENCES farm (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939890523730 FOREIGN KEY (greengrocer_id) REFERENCES greengrocer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD65FCFA0D');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD65FCFA0D FOREIGN KEY (farm_id) REFERENCES farm (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE farm_pictures DROP FOREIGN KEY FK_D777799A65FCFA0D');
        $this->addSql('ALTER TABLE farm_pictures ADD CONSTRAINT FK_D777799A65FCFA0D FOREIGN KEY (farm_id) REFERENCES farm (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94D4584665A');
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94DC72F7599');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94D4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94DC72F7599 FOREIGN KEY (ordor_id) REFERENCES `order` (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939865FCFA0D');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939890523730');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939865FCFA0D FOREIGN KEY (farm_id) REFERENCES farm (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939890523730 FOREIGN KEY (greengrocer_id) REFERENCES greengrocer (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD65FCFA0D');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD65FCFA0D FOREIGN KEY (farm_id) REFERENCES farm (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
