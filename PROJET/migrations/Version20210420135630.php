<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210420135630 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE paniers (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_u INTEGER NOT NULL, quantite INTEGER NOT NULL, id_p INTEGER NOT NULL)');
        $this->addSql('DROP INDEX IDX_29DD1761BE35FDA0');
        $this->addSql('CREATE TEMPORARY TABLE __temp__im2021_utilisateurs AS SELECT pk, nom, prenom, anniversaire, identifiant, motdepasse, isadmin FROM im2021_utilisateurs');
        $this->addSql('DROP TABLE im2021_utilisateurs');
        $this->addSql('CREATE TABLE im2021_utilisateurs (pk INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(30) DEFAULT NULL COLLATE BINARY, prenom VARCHAR(30) DEFAULT NULL COLLATE BINARY, anniversaire DATE DEFAULT NULL, identifiant VARCHAR(30) NOT NULL COLLATE BINARY --sert de login (doit être unique)
        , motdepasse VARCHAR(64) NOT NULL COLLATE BINARY --mot de passe crypté : il faut une taille assez grande pour ne pas le tronquer
        , isadmin BOOLEAN NOT NULL --type boolean
        )');
        $this->addSql('INSERT INTO im2021_utilisateurs (pk, nom, prenom, anniversaire, identifiant, motdepasse, isadmin) SELECT pk, nom, prenom, anniversaire, identifiant, motdepasse, isadmin FROM __temp__im2021_utilisateurs');
        $this->addSql('DROP TABLE __temp__im2021_utilisateurs');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE paniers');
        $this->addSql('CREATE TEMPORARY TABLE __temp__im2021_utilisateurs AS SELECT pk, identifiant, motdepasse, nom, prenom, anniversaire, isadmin FROM im2021_utilisateurs');
        $this->addSql('DROP TABLE im2021_utilisateurs');
        $this->addSql('CREATE TABLE im2021_utilisateurs (pk INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, identifiant VARCHAR(30) NOT NULL --sert de login (doit être unique)
        , motdepasse VARCHAR(64) NOT NULL --mot de passe crypté : il faut une taille assez grande pour ne pas le tronquer
        , nom VARCHAR(30) DEFAULT NULL, prenom VARCHAR(30) DEFAULT NULL, anniversaire DATE DEFAULT NULL, isadmin BOOLEAN NOT NULL --type boolean
        , paniers_id INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO im2021_utilisateurs (pk, identifiant, motdepasse, nom, prenom, anniversaire, isadmin) SELECT pk, identifiant, motdepasse, nom, prenom, anniversaire, isadmin FROM __temp__im2021_utilisateurs');
        $this->addSql('DROP TABLE __temp__im2021_utilisateurs');
        $this->addSql('CREATE INDEX IDX_29DD1761BE35FDA0 ON im2021_utilisateurs (paniers_id)');
    }
}
