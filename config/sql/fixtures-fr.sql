insert into categories ("id", "name") values ('cid1', 'Frais');
insert into categories ("id", "name") values ('cid2', 'Scolaire');
insert into categories ("id", "name") values ('cid3', 'Jeux / Jouets');
insert into categories ("id", "name") values ('cid4', 'Droguerie');
insert into categories ("id", "name") values ('cid5', 'Condiments');
insert into categories ("id", "name") values ('cid6', 'Boissons');
insert into categories ("id", "name") values ('cid7', 'Bricolage');
insert into categories ("id", "name") values ('cid8', 'Petit dej');
insert into categories ("id", "name") values ('cid9', 'Légumes');
insert into categories ("id", "name") values ('cid10', 'Surgelés');

insert into product_selection ("id", "category_id", "name") values ('psid1', 'cid1', 'Lait');
insert into product_selection ("id", "category_id", "name") values ('psid2', 'cid1', 'Oeufs');
insert into product_selection ("id", "category_id", "name") values ('psid3', 'cid2', 'Encre noire');
insert into product_selection ("id", "category_id", "name") values ('psid4', 'cid8', 'Café');

insert into products ("id", "category_id", "name", "quantity") values ('pid1', 'cid1', 'product1', 10);
insert into products ("id", "category_id", "name", "quantity") values ('pid2', 'cid2', 'product2', 10);
insert into products ("id", "category_id", "name", "quantity") values ('pid3', 'cid1', 'product3', 5);
insert into products ("id", "category_id", "name", "quantity") values ('pid4', 'cid2', 'product4', 10);
