<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220527171613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE greengrocer_picture (id INT AUTO_INCREMENT NOT NULL, greengrocer_id INT NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_127A2BCA90523730 (greengrocer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE greengrocer_picture ADD CONSTRAINT FK_127A2BCA90523730 FOREIGN KEY (greengrocer_id) REFERENCES greengrocer (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE greengrocer_picture');
    }
}
