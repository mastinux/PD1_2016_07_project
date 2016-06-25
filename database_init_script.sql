/*
DROP DATABASE theater_db;
create database theater_db;

use theater_db;

create table theater_user(
	email varchar(320) not null,
    pw varchar(255) not null,
	primary key (email)
);

create table theater_booked_seat(
	cln int not null,
    rwn int not null,
    username varchar(320) not null,
    primary key (cln, rwn),
	foreign key (username) references theater_user(email)
);
*/
#SET SQL_SAFE_UPDATES = 0;
#delete from theater_user where pw != "a";

use theater_db;
select * from theater_user;

#insert into theater_booked_seat(cln, rwn, username) values(1,1,'angela');
select * from theater_booked_seat;

#select * from theater_booked_seat where username != 'angela';
