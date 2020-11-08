CREATE TABLE product_selection (
  id          VARCHAR(50) NOT NULL,
  name        VARCHAR(50) NOT NULL,
  category_id VARCHAR(50) DEFAULT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (category_id) REFERENCES categories (id)
);

CREATE UNIQUE INDEX ux_product_selection_name ON product_selection (name);
