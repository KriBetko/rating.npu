<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150823212558 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE criteria (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, group_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, coefficient NUMERIC(10, 2) DEFAULT NULL, reference VARCHAR(100) NOT NULL, type INT NOT NULL, INDEX IDX_B61F9B8112469DE2 (category_id), INDEX IDX_B61F9B81FE54D947 (group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fields (id INT AUTO_INCREMENT NOT NULL, measure_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, INDEX IDX_7EE5E3885DA37D00 (measure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE criteria_group (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE criteria_category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, type INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE measures (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, criterion_id INT DEFAULT NULL, year_id INT DEFAULT NULL, value INT NOT NULL, INDEX IDX_508A1C55A76ED395 (user_id), INDEX IDX_508A1C5597766307 (criterion_id), INDEX IDX_508A1C5540C1FEA7 (year_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE years (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE criterion_years (year_id INT NOT NULL, criterion_id INT NOT NULL, INDEX IDX_48F4496F40C1FEA7 (year_id), INDEX IDX_48F4496F97766307 (criterion_id), PRIMARY KEY(year_id, criterion_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE criteria ADD CONSTRAINT FK_B61F9B8112469DE2 FOREIGN KEY (category_id) REFERENCES criteria_category (id)');
        $this->addSql('ALTER TABLE criteria ADD CONSTRAINT FK_B61F9B81FE54D947 FOREIGN KEY (group_id) REFERENCES criteria_group (id)');
        $this->addSql('ALTER TABLE fields ADD CONSTRAINT FK_7EE5E3885DA37D00 FOREIGN KEY (measure_id) REFERENCES measures (id)');
        $this->addSql('ALTER TABLE measures ADD CONSTRAINT FK_508A1C55A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE measures ADD CONSTRAINT FK_508A1C5597766307 FOREIGN KEY (criterion_id) REFERENCES criteria (id)');
        $this->addSql('ALTER TABLE measures ADD CONSTRAINT FK_508A1C5540C1FEA7 FOREIGN KEY (year_id) REFERENCES years (id)');
        $this->addSql('ALTER TABLE criterion_years ADD CONSTRAINT FK_48F4496F40C1FEA7 FOREIGN KEY (year_id) REFERENCES years (id)');
        $this->addSql('ALTER TABLE criterion_years ADD CONSTRAINT FK_48F4496F97766307 FOREIGN KEY (criterion_id) REFERENCES criteria (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE measures DROP FOREIGN KEY FK_508A1C5597766307');
        $this->addSql('ALTER TABLE criterion_years DROP FOREIGN KEY FK_48F4496F97766307');
        $this->addSql('ALTER TABLE criteria DROP FOREIGN KEY FK_B61F9B81FE54D947');
        $this->addSql('ALTER TABLE criteria DROP FOREIGN KEY FK_B61F9B8112469DE2');
        $this->addSql('ALTER TABLE fields DROP FOREIGN KEY FK_7EE5E3885DA37D00');
        $this->addSql('ALTER TABLE measures DROP FOREIGN KEY FK_508A1C5540C1FEA7');
        $this->addSql('ALTER TABLE criterion_years DROP FOREIGN KEY FK_48F4496F40C1FEA7');
        $this->addSql('DROP TABLE criteria');
        $this->addSql('DROP TABLE fields');
        $this->addSql('DROP TABLE criteria_group');
        $this->addSql('DROP TABLE criteria_category');
        $this->addSql('DROP TABLE measures');
        $this->addSql('DROP TABLE years');
        $this->addSql('DROP TABLE criterion_years');
    }
}
