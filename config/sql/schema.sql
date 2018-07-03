DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

CREATE TABLE categories (
  id   VARCHAR(50) NOT NULL,
  name VARCHAR(50) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE products (
  id          VARCHAR(50) NOT NULL,
  category_id VARCHAR(50) DEFAULT NULL,
  name        VARCHAR(50) NOT NULL,
  quantity    INTEGER     NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (category_id) REFERENCES categories (id)
);

CREATE TABLE users (
  uid      VARCHAR(50) NOT NULL,
  login    VARCHAR(20) NOT NULL,
  password VARCHAR(50) NOT NULL,
  PRIMARY KEY (uid)
);

CREATE INDEX idx_category ON products (category_id);
CREATE UNIQUE INDEX 'ux_login' ON users (login ASC);
