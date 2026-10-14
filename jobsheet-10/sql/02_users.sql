create table if not exists users (
    id serial primary key,
    nama varchar(255) not null,
    username varchar(50) not null unique,
    password varchar(255) not null,
    role varchar(20) not null default 'petugas'
);