# Table creation and customization
# Gemilang_POS
# 20 December 2017

# Table Creation

CREATE TABLE CUSTOMER(
    customer_id INT AUTO_INCREMENT,
    customer_name VARCHAR(30) NOT NULL,
    customer_phone VARCHAR(12),
    CONSTRAINT pk_customer PRIMARY KEY (customer_id)
);

CREATE TABLE PRODUCT(
    product_id INT AUTO_INCREMENT,
    product_name VARCHAR(50) NOT NULL,
    product_purchase_price INT NOT NULL,
    product_sale_price INT NOT NULL,
    product_stock_quantity INT,
    product_stock_unit VARCHAR(8) NOT NULL,
    CONSTRAINT pk_product PRIMARY KEY (product_id)
);

CREATE TABLE DISCOUNT_CARD(
    discount_id INT AUTO_INCREMENT,
    discount_phone VARCHAR(12) NOT NULL,
    CONSTRAINT pk_discount_card PRIMARY KEY (discount_id)
);

CREATE TABLE TRANSACT(
    transact_id INT AUTO_INCREMENT,
    transact_date TIMESTAMP,
    customer_id INT DEFAULT 10000001,
    discount_id INT,
    CONSTRAINT pk_transact PRIMARY KEY (transact_id),
    CONSTRAINT fk_transact_customer FOREIGN KEY (customer_id) REFERENCES CUSTOMER (customer_id),
    CONSTRAINT fk_transact_discount FOREIGN KEY (discount_id) REFERENCES DISCOUNT_CARD (discount_id)
);

CREATE TABLE TRANSACTLINE(
    transact_id INT NOT NULL,
    product_id INT NOT NULL,
    transact_item_quantity INT NOT NULL,
    CONSTRAINT fk_transactline_TRANSACT FOREIGN KEY (transact_id) REFERENCES TRANSACT (transact_id),
    CONSTRAINT fk_transactline_product FOREIGN KEY (product_id) REFERENCES PRODUCT (product_id),
    CONSTRAINT pk_transactline PRIMARY KEY (transact_id,product_id)
);

CREATE TABLE ACCOUNT(
    USER_ID VARCHAR(15),
    USER_PASSWORD VARCHAR(256) NOT NULL,
    USER_ROLE CHAR(1) NOT NULL,
    CONSTRAINT pk_user PRIMARY KEY (USER_ID)
);

# Auto increment alteration

ALTER TABLE CUSTOMER AUTO_INCREMENT = 10000001;
ALTER TABLE PRODUCT AUTO_INCREMENT = 30000001;
ALTER TABLE DISCOUNT_CARD AUTO_INCREMENT = 40000001;