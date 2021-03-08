<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210308225616 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exercice (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE history (id INT AUTO_INCREMENT NOT NULL, id_fk INT NOT NULL, old_value INT DEFAULT NULL, new_value INT DEFAULT NULL, created_at DATETIME NOT NULL, entity_class VARCHAR(255) NOT NULL, property_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient_config_exercice (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, exercice_id INT DEFAULT NULL, one_rm INT NOT NULL, created_at DATETIME NOT NULL, enabled TINYINT(1) NOT NULL, INDEX IDX_B864A03A6B899279 (patient_id), INDEX IDX_B864A03A89D40298 (exercice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D6496B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE patient_config_exercice ADD CONSTRAINT FK_B864A03A6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE patient_config_exercice ADD CONSTRAINT FK_B864A03A89D40298 FOREIGN KEY (exercice_id) REFERENCES exercice (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6496B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE patient ADD first_name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL, ADD borg TINYINT(1) DEFAULT NULL, ADD taille INT DEFAULT NULL, ADD poids INT DEFAULT NULL, ADD bbloquant TINYINT(1) DEFAULT NULL, ADD dnd TINYINT(1) DEFAULT NULL, ADD did TINYINT(1) DEFAULT NULL, ADD fce INT DEFAULT NULL, ADD fevg INT DEFAULT NULL, ADD archived TINYINT(1) DEFAULT \'0\', DROP nom, DROP prenom, CHANGE date_naissance birthdate DATE NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient_config_exercice DROP FOREIGN KEY FK_B864A03A89D40298');
        $this->addSql('DROP TABLE exercice');
        $this->addSql('DROP TABLE history');
        $this->addSql('DROP TABLE patient_config_exercice');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE patient ADD nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD prenom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP first_name, DROP last_name, DROP borg, DROP taille, DROP poids, DROP bbloquant, DROP dnd, DROP did, DROP fce, DROP fevg, DROP archived, CHANGE birthdate date_naissance DATE NOT NULL');
    }
}
