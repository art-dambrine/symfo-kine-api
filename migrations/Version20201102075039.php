<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201102075039 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fce (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, fce INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_C013C3336B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fevg (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, fevg INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_DBA654836B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fce ADD CONSTRAINT FK_C013C3336B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE fevg ADD CONSTRAINT FK_DBA654836B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE patient ADD borg TINYINT(1) NOT NULL, ADD taille INT DEFAULT NULL, ADD poids INT DEFAULT NULL, ADD bbloquant TINYINT(1) NOT NULL, ADD dnd TINYINT(1) NOT NULL, ADD did TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE fce');
        $this->addSql('DROP TABLE fevg');
        $this->addSql('ALTER TABLE patient DROP borg, DROP taille, DROP poids, DROP bbloquant, DROP dnd, DROP did');
    }
}
