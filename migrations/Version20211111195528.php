<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211111195528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function isTransactional(): bool
    {
        return false;
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD keywords VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE article RENAME INDEX idx_23a0e66a76ed395 TO IDX_23A0E66F675F31B');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP keywords');
        $this->addSql('ALTER TABLE article RENAME INDEX idx_23a0e66f675f31b TO IDX_23A0E66A76ED395');
    }
}
