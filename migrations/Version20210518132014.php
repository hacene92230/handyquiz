<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210518132014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quizreply DROP reponse');
        $this->addSql('ALTER TABLE reponse ADD quizreply_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7EC1C02A2 FOREIGN KEY (quizreply_id) REFERENCES quizreply (id)');
        $this->addSql('CREATE INDEX IDX_5FB6DEC7EC1C02A2 ON reponse (quizreply_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quizreply ADD reponse LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7EC1C02A2');
        $this->addSql('DROP INDEX IDX_5FB6DEC7EC1C02A2 ON reponse');
        $this->addSql('ALTER TABLE reponse DROP quizreply_id');
    }
}
