<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210409120506 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE questions (id INT AUTO_INCREMENT NOT NULL, reponse1 VARCHAR(255) NOT NULL, reponse2 VARCHAR(255) NOT NULL, reponse3 VARCHAR(255) NOT NULL, reponse4 VARCHAR(255) NOT NULL, reponse5 VARCHAR(255) NOT NULL, texte VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz_questions (quiz_id INT NOT NULL, questions_id INT NOT NULL, INDEX IDX_8CBC2533853CD175 (quiz_id), INDEX IDX_8CBC2533BCB134CE (questions_id), PRIMARY KEY(quiz_id, questions_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quiz_questions ADD CONSTRAINT FK_8CBC2533853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quiz_questions ADD CONSTRAINT FK_8CBC2533BCB134CE FOREIGN KEY (questions_id) REFERENCES questions (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_questions DROP FOREIGN KEY FK_8CBC2533BCB134CE');
        $this->addSql('ALTER TABLE quiz_questions DROP FOREIGN KEY FK_8CBC2533853CD175');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE quiz_questions');
    }
}
