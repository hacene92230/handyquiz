<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210419033612 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quizreply DROP INDEX UNIQ_6A7C4AA0853CD175, ADD INDEX IDX_6A7C4AA0853CD175 (quiz_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quizreply DROP INDEX IDX_6A7C4AA0853CD175, ADD UNIQUE INDEX UNIQ_6A7C4AA0853CD175 (quiz_id)');
    }
}
