<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210404124341 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE im2021_utilisateurs (pk INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, identifiant VARCHAR(30) NOT NULL, motdepasse VARCHAR(64) NOT NULL, nom VARCHAR(30) DEFAULT NULL, prenom VARCHAR(30) DEFAULT NULL, anniversaire DATE DEFAULT NULL, isadmin BOOLEAN NOT NULL)');
        $this->addSql('CREATE TABLE panier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_u_id INTEGER NOT NULL, id_p_id INTEGER NOT NULL, quantite INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_24CC0DF26F858F92 ON panier (id_u_id)');
        $this->addSql('CREATE INDEX IDX_24CC0DF2585B7FA0 ON panier (id_p_id)');
        $this->addSql('DROP TABLE utilisateurs');
        $this->addSql('CREATE TEMPORARY TABLE __temp__im2021_treetrunk AS SELECT id, name, prix, quantite FROM im2021_treetrunk');
        $this->addSql('DROP TABLE im2021_treetrunk');
        $this->addSql('CREATE TABLE im2021_treetrunk (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(150) NOT NULL COLLATE BINARY, quantite INTEGER NOT NULL, prix DOUBLE PRECISION NOT NULL)');
        $this->addSql('INSERT INTO im2021_treetrunk (id, name, prix, quantite) SELECT id, name, prix, quantite FROM __temp__im2021_treetrunk');
        $this->addSql('DROP TABLE __temp__im2021_treetrunk');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateurs (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, identifiant VARCHAR(30) NOT NULL COLLATE BINARY, motdepasse VARCHAR(64) NOT NULL COLLATE BINARY, nom VARCHAR(30) DEFAULT NULL COLLATE BINARY, prenom VARCHAR(30) DEFAULT NULL COLLATE BINARY, anniversaire DATE DEFAULT NULL, isadmin BOOLEAN NOT NULL)');
        $this->addSql('DROP TABLE im2021_utilisateurs');
        $this->addSql('DROP TABLE panier');
        $this->addSql('CREATE TEMPORARY TABLE __temp__im2021_treetrunk AS SELECT id, name, prix, quantite FROM im2021_treetrunk');
        $this->addSql('DROP TABLE im2021_treetrunk');
        $this->addSql('CREATE TABLE im2021_treetrunk (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(150) NOT NULL, quantite INTEGER NOT NULL, prix INTEGER NOT NULL, description CLOB DEFAULT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO im2021_treetrunk (id, name, prix, quantite) SELECT id, name, prix, quantite FROM __temp__im2021_treetrunk');
        $this->addSql('DROP TABLE __temp__im2021_treetrunk');
    }
}
