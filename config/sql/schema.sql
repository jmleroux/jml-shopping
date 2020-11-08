DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS product_selection;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

CREATE TABLE categories (
  id   VARCHAR(50) NOT NULL,
  name VARCHAR(50) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE products (
  id          VARCHAR(50) NOT NULL,
  name        VARCHAR(50) NOT NULL,
  category_id VARCHAR(50) DEFAULT NULL,
  quantity    INTEGER     NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (category_id) REFERENCES categories (id)
);

CREATE TABLE product_selection (
  id          VARCHAR(50) NOT NULL,
  name        VARCHAR(50) NOT NULL,
  category_id VARCHAR(50) DEFAULT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (category_id) REFERENCES categories (id)
);

CREATE TABLE users (
  login    VARCHAR(20) NOT NULL,
  PRIMARY KEY (login)
);

CREATE INDEX idx_category ON products (category_id);
CREATE UNIQUE INDEX ux_product_selection_name ON product_selection (name);
