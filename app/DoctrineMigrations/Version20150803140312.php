<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150803140312 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE positions (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
            CREATE TABLE jobs (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, position_id INT DEFAULT NULL, cathedra_id INT DEFAULT NULL, institute_id INT DEFAULT NULL, bet NUMERIC(1, 2) DEFAULT NULL, additional TINYINT(1) NOT NULL, INDEX IDX_A8936DC5A76ED395 (user_id), INDEX IDX_A8936DC5DD842E46 (position_id), INDEX IDX_A8936DC5E1B616A9 (cathedra_id), INDEX IDX_A8936DC5697B0F4C (institute_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
            ALTER TABLE jobs ADD CONSTRAINT FK_A8936DC5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id);
            ALTER TABLE jobs ADD CONSTRAINT FK_A8936DC5DD842E46 FOREIGN KEY (position_id) REFERENCES positions (id);
            ALTER TABLE jobs ADD CONSTRAINT FK_A8936DC5E1B616A9 FOREIGN KEY (cathedra_id) REFERENCES cathedra (id);
            ALTER TABLE jobs ADD CONSTRAINT FK_A8936DC5697B0F4C FOREIGN KEY (institute_id) REFERENCES institute (id);
            ALTER TABLE user DROP FOREIGN KEY FK_8D93D649697B0F4C;
            ALTER TABLE user DROP FOREIGN KEY FK_8D93D649E1B616A9;
            DROP INDEX IDX_8D93D649697B0F4C ON user;
            DROP INDEX IDX_8D93D649E1B616A9 ON user;
            ALTER TABLE user DROP institute_id, DROP cathedra_id;
        ");

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("
            DROP INDEX FK_A8936DC5A76ED395 ON jobs;
            DROP INDEX FK_A8936DC5DD842E46 ON jobs;
            DROP INDEX FK_A8936DC5E1B616A9 ON jobs;
            DROP INDEX FK_A8936DC5697B0F4C ON jobs;
            DROP TABLE positions;
            DROP TABLE jobs;
        ");

    }
}
