<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210330085656 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE im2021_treetrunk (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(150) NOT NULL, prix INTEGER NOT NULL, quantite INTEGER NOT NULL, description CLOB DEFAULT NULL)');
        $this->addSql('CREATE TABLE im2021_utilisateurs (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, identifiant VARCHAR(30) NOT NULL, motdepasse VARCHAR(64) NOT NULL, nom VARCHAR(30) DEFAULT NULL, prenom VARCHAR(30) DEFAULT NULL, anniversaire DATE DEFAULT NULL, isadmin BOOLEAN NOT NULL)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE im2021_treetrunk');
        $this->addSql('DROP TABLE im2021_utilisateurs');

    }
}
