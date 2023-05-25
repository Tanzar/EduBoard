<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230524095837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, timestamp DATETIME NOT NULL, published DATETIME NOT NULL, title VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, INDEX IDX_23A0E66F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_tags (article_id INT NOT NULL, tags_id INT NOT NULL, INDEX IDX_DFFE13277294869C (article_id), INDEX IDX_DFFE13278D7B4FB4 (tags_id), PRIMARY KEY(article_id, tags_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_news_images (article_id INT NOT NULL, news_images_id INT NOT NULL, INDEX IDX_F63517797294869C (article_id), INDEX IDX_F6351779C86A5A24 (news_images_id), PRIMARY KEY(article_id, news_images_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news_images (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tags (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66F675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE article_tags ADD CONSTRAINT FK_DFFE13277294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_tags ADD CONSTRAINT FK_DFFE13278D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_news_images ADD CONSTRAINT FK_F63517797294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_news_images ADD CONSTRAINT FK_F6351779C86A5A24 FOREIGN KEY (news_images_id) REFERENCES news_images (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD phone VARCHAR(15) NOT NULL, ADD address VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66F675F31B');
        $this->addSql('ALTER TABLE article_tags DROP FOREIGN KEY FK_DFFE13277294869C');
        $this->addSql('ALTER TABLE article_tags DROP FOREIGN KEY FK_DFFE13278D7B4FB4');
        $this->addSql('ALTER TABLE article_news_images DROP FOREIGN KEY FK_F63517797294869C');
        $this->addSql('ALTER TABLE article_news_images DROP FOREIGN KEY FK_F6351779C86A5A24');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_tags');
        $this->addSql('DROP TABLE article_news_images');
        $this->addSql('DROP TABLE news_images');
        $this->addSql('DROP TABLE tags');
        $this->addSql('ALTER TABLE `user` DROP phone, DROP address');
    }
}
