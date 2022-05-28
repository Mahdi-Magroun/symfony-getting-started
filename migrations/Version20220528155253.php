<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220528155253 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE greengrocer DROP FOREIGN KEY FK_AC14ABED8FDDAB70');
        $this->addSql('ALTER TABLE greengrocer ADD CONSTRAINT FK_AC14ABED8FDDAB70 FOREIGN KEY (owner_id_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE greengrocer_picture DROP FOREIGN KEY FK_127A2BCA90523730');
        $this->addSql('ALTER TABLE greengrocer_picture ADD CONSTRAINT FK_127A2BCA90523730 FOREIGN KEY (greengrocer_id) REFERENCES greengrocer (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE greengrocer DROP FOREIGN KEY FK_AC14ABED8FDDAB70');
        $this->addSql('ALTER TABLE greengrocer ADD CONSTRAINT FK_AC14ABED8FDDAB70 FOREIGN KEY (owner_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE greengrocer_picture DROP FOREIGN KEY FK_127A2BCA90523730');
        $this->addSql('ALTER TABLE greengrocer_picture ADD CONSTRAINT FK_127A2BCA90523730 FOREIGN KEY (greengrocer_id) REFERENCES greengrocer (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
