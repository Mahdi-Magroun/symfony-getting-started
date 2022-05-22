<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220520220024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE greengrocer DROP FOREIGN KEY FK_AC14ABED8FDDAB70');
        $this->addSql('DROP INDEX UNIQ_AC14ABED7E3C61F9 ON greengrocer');
        $this->addSql('ALTER TABLE greengrocer CHANGE owner_id owner_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE greengrocer ADD CONSTRAINT FK_AC14ABED8FDDAB70 FOREIGN KEY (owner_id_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AC14ABED8FDDAB70 ON greengrocer (owner_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE greengrocer DROP FOREIGN KEY FK_AC14ABED8FDDAB70');
        $this->addSql('DROP INDEX UNIQ_AC14ABED8FDDAB70 ON greengrocer');
        $this->addSql('ALTER TABLE greengrocer CHANGE owner_id_id owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE greengrocer ADD CONSTRAINT FK_AC14ABED8FDDAB70 FOREIGN KEY (owner_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AC14ABED7E3C61F9 ON greengrocer (owner_id)');
    }
}
