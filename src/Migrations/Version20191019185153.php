<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191019185153 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE department (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE policy (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, version VARCHAR(6) NOT NULL, content LONGTEXT NOT NULL, published_at DATETIME DEFAULT NULL, is_to_all_users TINYINT(1) NOT NULL, UNIQUE INDEX unique_policy (name, version), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE policy_filter (id INT AUTO_INCREMENT NOT NULL, job_id INT DEFAULT NULL, department_id INT DEFAULT NULL, policy_id INT NOT NULL, INDEX IDX_5510B200BE04EA9 (job_id), INDEX IDX_5510B200AE80F5DF (department_id), INDEX IDX_5510B2002D29E3C6 (policy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE policy_users (id INT AUTO_INCREMENT NOT NULL, policy_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_AF452C122D29E3C6 (policy_id), INDEX IDX_AF452C12A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, department_id INT NOT NULL, job_id INT NOT NULL, email VARCHAR(100) NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_8D93D649A9D1C132 (first_name), INDEX IDX_8D93D649AE80F5DF (department_id), INDEX IDX_8D93D649BE04EA9 (job_id), UNIQUE INDEX unique_email (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE policy_filter ADD CONSTRAINT FK_5510B200BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id)');
        $this->addSql('ALTER TABLE policy_filter ADD CONSTRAINT FK_5510B200AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE policy_filter ADD CONSTRAINT FK_5510B2002D29E3C6 FOREIGN KEY (policy_id) REFERENCES policy (id)');
        $this->addSql('ALTER TABLE policy_users ADD CONSTRAINT FK_AF452C122D29E3C6 FOREIGN KEY (policy_id) REFERENCES policy (id)');
        $this->addSql('ALTER TABLE policy_users ADD CONSTRAINT FK_AF452C12A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE policy_filter DROP FOREIGN KEY FK_5510B200AE80F5DF');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649AE80F5DF');
        $this->addSql('ALTER TABLE policy_filter DROP FOREIGN KEY FK_5510B200BE04EA9');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BE04EA9');
        $this->addSql('ALTER TABLE policy_filter DROP FOREIGN KEY FK_5510B2002D29E3C6');
        $this->addSql('ALTER TABLE policy_users DROP FOREIGN KEY FK_AF452C122D29E3C6');
        $this->addSql('ALTER TABLE policy_users DROP FOREIGN KEY FK_AF452C12A76ED395');
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE job');
        $this->addSql('DROP TABLE policy');
        $this->addSql('DROP TABLE policy_filter');
        $this->addSql('DROP TABLE policy_users');
        $this->addSql('DROP TABLE user');
    }
}
