PRAGMA foreign_keys = OFF;
BEGIN TRANSACTION;
CREATE TABLE categories (
  id    INTEGER     NOT NULL,
  label VARCHAR(50) NOT NULL,
  PRIMARY KEY (id)
);
CREATE TABLE products (
  id       INTEGER     NOT NULL,
  category INTEGER DEFAULT NULL,
  product  VARCHAR(50) NOT NULL,
  quantity INTEGER     NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT FK_B3BA5A5A64C19C1 FOREIGN KEY (category) REFERENCES categories (id)
    NOT DEFERRABLE INITIALLY IMMEDIATE
);
CREATE TABLE users (
  uid      INTEGER     NOT NULL,
  login    VARCHAR(20) NOT NULL,
  password VARCHAR(50) NOT NULL,
  PRIMARY KEY (uid)
);
CREATE INDEX IDX_category ON products (category);
CREATE UNIQUE INDEX "ux_login" ON users (login ASC);
COMMIT;
