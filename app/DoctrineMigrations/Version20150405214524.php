<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150405214524  extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("
ALTER TABLE user ADD institute_id INT DEFAULT NULL, ADD cathedra_id INT DEFAULT NULL;
ALTER TABLE user ADD CONSTRAINT FK_8D93D649697B0F4C FOREIGN KEY (institute_id) REFERENCES institute (id);
ALTER TABLE user ADD CONSTRAINT FK_8D93D649E1B616A9 FOREIGN KEY (cathedra_id) REFERENCES cathedra (id);
CREATE INDEX IDX_8D93D649697B0F4C ON user (institute_id);
CREATE INDEX IDX_8D93D649E1B616A9 ON user (cathedra_id);
        ");

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
       $this->addSql("
ALTER TABLE  user DROP FOREIGN KEY  `FK_8D93D649697B0F4C` ;
ALTER TABLE  user DROP FOREIGN KEY  `FK_8D93D649E1B616A9` ;


       ");
        $this->addSql("

ALTER TABLE user DROP  cathedra_id;

       ");
        $this->addSql("

ALTER TABLE user DROP institute_id;

       ");

    }
}

