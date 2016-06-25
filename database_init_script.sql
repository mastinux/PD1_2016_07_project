/*
DROP DATABASE theater_db;
create database theater_db;
*/
use theater_db;
/*
create table theater_user(
	email varchar(320) not null,
    pw varchar(255) not null,
    username varchar(64) not null,
	primary key (email)
);

create table theater_booked_seat(
	cln int not null,
    rwn int not null,
    email varchar(320) not null,
    primary key (cln, rwn, email),
	foreign key (email) references theater_user(email)
);
*/
#SET SQL_SAFE_UPDATES = 0;
#delete from theater_user where pw != "a";

select * from theater_user;
select * from theater_booked_seat;