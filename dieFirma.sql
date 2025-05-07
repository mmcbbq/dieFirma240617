DROP DATABASE if exists dieFirma;
CREATE DATABASE dieFirma;

use dieFirma;


Create TABLE department
(
    id   int auto_increment primary key,
    name varchar(255)
);

INSERT INTO department (name)
values ('Hr'),
       ('IT'),
       ('Sales');

CREATE TABLE user
(
    id       int auto_increment primary key,
    vorname  varchar(255),
    nachname varchar(255),
    bday     date
);

INSERT INTO user (vorname, nachname, bday)
VALUES ('Joe', 'Biden', '1940-05-12'),
       ('Donald', 'Trump', '1950-05-12');