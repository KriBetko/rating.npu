<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151217004908 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user CHANGE firstName firstName VARCHAR(255) NOT NULL, CHANGE lastName lastName VARCHAR(255) NOT NULL, CHANGE parentName parentName VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE jobs ADD `group` VARCHAR(64) DEFAULT NULL, ADD formEducation INT DEFAULT NULL, ADD entryYear DATE DEFAULT NULL, ADD specialization VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE jobs DROP `group`, DROP formEducation, DROP entryYear, DROP specialization');
        $this->addSql('ALTER TABLE user CHANGE firstName firstName VARCHAR(255) DEFAULT NULL, CHANGE lastName lastName VARCHAR(255) DEFAULT NULL, CHANGE parentName parentName VARCHAR(255) DEFAULT NULL');
    }
}
