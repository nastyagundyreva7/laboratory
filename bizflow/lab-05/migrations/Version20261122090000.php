<?php
declare(strict_types=1);
namespace DoctrineMigrations;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
final class Version20261122090000 extends AbstractMigration
{
    public function getDescription(): string { return 'Create BizFlow customer, product, sales_order and order_item tables'; }
    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(160) NOT NULL, email VARCHAR(190) NOT NULL, phone VARCHAR(40) DEFAULT NULL, company VARCHAR(160) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', UNIQUE INDEX uniq_customer_email (email), INDEX idx_customer_created (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB");
        $this->addSql("CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(180) NOT NULL, sku VARCHAR(64) NOT NULL, cost_cents INT NOT NULL, price_cents INT NOT NULL, active TINYINT(1) DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', UNIQUE INDEX uniq_product_sku (sku), INDEX idx_product_active (active), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB");
        $this->addSql("CREATE TABLE sales_order (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, status VARCHAR(24) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX idx_order_status_created (status, created_at), INDEX idx_order_customer_created (customer_id, created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB");
        $this->addSql("CREATE TABLE order_item (id INT AUTO_INCREMENT NOT NULL, order_id INT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, unit_price_cents INT NOT NULL, INDEX idx_item_order (order_id), INDEX idx_item_product (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB");
        $this->addSql('ALTER TABLE sales_order ADD CONSTRAINT FK_ORDER_CUSTOMER FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_ITEM_ORDER FOREIGN KEY (order_id) REFERENCES sales_order (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_ITEM_PRODUCT FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE RESTRICT');
    }
    public function down(Schema $schema): void { $this->addSql('DROP TABLE order_item'); $this->addSql('DROP TABLE sales_order'); $this->addSql('DROP TABLE product'); $this->addSql('DROP TABLE customer'); }
}
