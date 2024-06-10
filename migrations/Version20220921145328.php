<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220921145328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE interview CHANGE place place VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE interview_criterion_result CHANGE remark remark LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD nationality VARCHAR(255) NOT NULL, ADD sexe VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE interview CHANGE place place VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE interview_criterion_result CHANGE remark remark VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE `user` DROP nationality, DROP sexe');
    }
}
