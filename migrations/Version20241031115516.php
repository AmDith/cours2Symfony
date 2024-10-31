<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241031115516 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP CONSTRAINT fk_c74404559d86650f');
        $this->addSql('DROP INDEX uniq_c74404559d86650f');
        $this->addSql('ALTER TABLE client DROP user_id_id');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455450FF010 ON client (telephone)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455E7769B0F ON client (surname)');
        $this->addSql('ALTER TABLE "user" ADD cient_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD roles JSON NULL');
        $this->addSql('ALTER TABLE "user" ALTER nom TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE "user" ALTER prenom TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE "user" ALTER login TYPE VARCHAR(180)');
        $this->addSql('ALTER TABLE "user" ALTER password TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE "user" ALTER is_blocked DROP NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649260E0D2B FOREIGN KEY (cient_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649260E0D2B ON "user" (cient_id)');
        $this->addSql('ALTER INDEX uniq_8d93d649aa08cb10 RENAME TO UNIQ_IDENTIFIER_LOGIN');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649260E0D2B');
        $this->addSql('DROP INDEX UNIQ_8D93D649260E0D2B');
        $this->addSql('ALTER TABLE "user" DROP cient_id');
        $this->addSql('ALTER TABLE "user" DROP roles');
        $this->addSql('ALTER TABLE "user" ALTER login TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE "user" ALTER password TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE "user" ALTER nom TYPE VARCHAR(50)');
        $this->addSql('ALTER TABLE "user" ALTER prenom TYPE VARCHAR(50)');
        $this->addSql('ALTER TABLE "user" ALTER is_blocked SET NOT NULL');
        $this->addSql('ALTER INDEX uniq_identifier_login RENAME TO uniq_8d93d649aa08cb10');
        $this->addSql('DROP INDEX UNIQ_C7440455450FF010');
        $this->addSql('DROP INDEX UNIQ_C7440455E7769B0F');
        $this->addSql('ALTER TABLE client ADD user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT fk_c74404559d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_c74404559d86650f ON client (user_id_id)');
    }
}
