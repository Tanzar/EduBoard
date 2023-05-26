<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230526084941 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE album (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE album_gallery_image (album_id INT NOT NULL, gallery_image_id INT NOT NULL, INDEX IDX_7EC911ED1137ABCF (album_id), INDEX IDX_7EC911ED828F7D6 (gallery_image_id), PRIMARY KEY(album_id, gallery_image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gallery_image (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE album_gallery_image ADD CONSTRAINT FK_7EC911ED1137ABCF FOREIGN KEY (album_id) REFERENCES album (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE album_gallery_image ADD CONSTRAINT FK_7EC911ED828F7D6 FOREIGN KEY (gallery_image_id) REFERENCES gallery_image (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE album_gallery_image DROP FOREIGN KEY FK_7EC911ED1137ABCF');
        $this->addSql('ALTER TABLE album_gallery_image DROP FOREIGN KEY FK_7EC911ED828F7D6');
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE album_gallery_image');
        $this->addSql('DROP TABLE gallery_image');
    }
}
