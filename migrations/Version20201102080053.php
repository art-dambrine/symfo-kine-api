<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201102080053 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exercice (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient_config_exercice (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, exercice_id INT DEFAULT NULL, one_rm INT NOT NULL, created_at DATETIME NOT NULL, enabled TINYINT(1) NOT NULL, INDEX IDX_B864A03A6B899279 (patient_id), INDEX IDX_B864A03A89D40298 (exercice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE patient_config_exercice ADD CONSTRAINT FK_B864A03A6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE patient_config_exercice ADD CONSTRAINT FK_B864A03A89D40298 FOREIGN KEY (exercice_id) REFERENCES exercice (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient_config_exercice DROP FOREIGN KEY FK_B864A03A89D40298');
        $this->addSql('DROP TABLE exercice');
        $this->addSql('DROP TABLE patient_config_exercice');
    }
}
