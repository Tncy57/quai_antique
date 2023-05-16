<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230516120910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE schedule CHANGE lunch_opening lunch_opening DATETIME NOT NULL, CHANGE lunch_closing lunch_closing DATETIME NOT NULL, CHANGE dinner_opening dinner_opening DATETIME NOT NULL, CHANGE dinner_closing dinner_closing DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user ADD firstname VARCHAR(255) DEFAULT NULL, ADD lastname VARCHAR(255) DEFAULT NULL, ADD number_of_guests INT DEFAULT NULL, ADD allergy VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE schedule CHANGE lunch_opening lunch_opening TIME NOT NULL, CHANGE lunch_closing lunch_closing TIME NOT NULL, CHANGE dinner_opening dinner_opening TIME NOT NULL, CHANGE dinner_closing dinner_closing TIME NOT NULL');
        $this->addSql('ALTER TABLE user DROP firstname, DROP lastname, DROP number_of_guests, DROP allergy');
    }
}
