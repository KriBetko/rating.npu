<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150405214522 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE user ADD
            firstName VARCHAR(255) NOT NULL,
            ADD lastName VARCHAR(255) NOT NULL,
            ADD parentName VARCHAR(255) NOT NULL;
        ");

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
       $this->addSql("
        ALTER TABLE user DROP firstName, lastName, parentName
       ");

    }
}
