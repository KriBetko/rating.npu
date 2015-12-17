<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151115221005 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cathedras_users (cathedra_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_833B9A0E1B616A9 (cathedra_id), INDEX IDX_833B9A0A76ED395 (user_id), PRIMARY KEY(cathedra_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE institutes_users (institute_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_67523244697B0F4C (institute_id), INDEX IDX_67523244A76ED395 (user_id), PRIMARY KEY(institute_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cathedras_users ADD CONSTRAINT FK_833B9A0E1B616A9 FOREIGN KEY (cathedra_id) REFERENCES cathedra (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cathedras_users ADD CONSTRAINT FK_833B9A0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE institutes_users ADD CONSTRAINT FK_67523244697B0F4C FOREIGN KEY (institute_id) REFERENCES institute (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE institutes_users ADD CONSTRAINT FK_67523244A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cathedra ADD director INT DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE cathedra ADD CONSTRAINT FK_4BEC624C1E90D3F0 FOREIGN KEY (director) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4BEC624C1E90D3F0 ON cathedra (director)');
        $this->addSql('ALTER TABLE institute ADD director INT DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE institute ADD CONSTRAINT FK_CA55B5D01E90D3F0 FOREIGN KEY (director) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CA55B5D01E90D3F0 ON institute (director)');
        $this->addSql('ALTER TABLE criteria CHANGE reference reference VARCHAR(100) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE cathedras_users');
        $this->addSql('DROP TABLE institutes_users');
        $this->addSql('ALTER TABLE cathedra DROP FOREIGN KEY FK_4BEC624C1E90D3F0');
        $this->addSql('DROP INDEX UNIQ_4BEC624C1E90D3F0 ON cathedra');
        $this->addSql('ALTER TABLE cathedra DROP director, CHANGE description description LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE criteria CHANGE reference reference VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE institute DROP FOREIGN KEY FK_CA55B5D01E90D3F0');
        $this->addSql('DROP INDEX UNIQ_CA55B5D01E90D3F0 ON institute');
        $this->addSql('ALTER TABLE institute DROP director, CHANGE description description LONGTEXT NOT NULL');
    }
}
