DROP Table if exists profesores;
DROP Table if exists departamentos;

-- Tablas
create table departamentos(
    id int auto_increment primary key,
    nom_dep varchar(40) not null
);
create table profesores(
    id int auto_increment primary key,
    nom_prof varchar(40) not null,
    sueldo float not null,
    img varchar(120) not null,
    dep_id int,
    constraint fk_dep_prof foreign key(dep_id) references departamentos(id) on delete cascade on update cascade
);