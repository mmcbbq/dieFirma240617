DROP DATABASE dieFirma;
CREATE DATABASE dieFirma;

use dieFirma;


Create TABLE department(
                           id int auto_increment primary key ,
                           name varchar(255)
);

INSERT INTO department (name) values
                                  ('Hr'),
                                  ('IT'),
                                  ('Sales');