<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150826234616 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fields DROP FOREIGN KEY FK_7EE5E3885DA37D00');
        $this->addSql('ALTER TABLE fields ADD CONSTRAINT FK_7EE5E3885DA37D00 FOREIGN KEY (measure_id) REFERENCES measures (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fields DROP FOREIGN KEY FK_7EE5E3885DA37D00');
        $this->addSql('ALTER TABLE fields ADD CONSTRAINT FK_7EE5E3885DA37D00 FOREIGN KEY (measure_id) REFERENCES measures (id)');
    }
}
