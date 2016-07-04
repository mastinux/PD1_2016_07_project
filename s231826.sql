use s231826;

create table theater_user(
  email varchar(255) not null,
  pw varchar(255) not null,
	primary key (email)
);

insert into theater_user(email, pw) values ('u1@p.it', md5('p1'));
insert into theater_user(email, pw) values ('u2@p.it', md5('p2'));

create table theater_booked_seat(
	cln int not null,
  rwn int not null,
  username varchar(255) not null,
  primary key (cln, rwn),
	foreign key (username) references theater_user(email) on delete cascade
);

insert into theater_booked_seat(cln, rwn, username) values(0,0,'u1@p.it');
insert into theater_booked_seat(cln, rwn, username) values(1,0,'u1@p.it');
insert into theater_booked_seat(cln, rwn, username) values(2,0,'u1@p.it');
insert into theater_booked_seat(cln, rwn, username) values(3,0,'u1@p.it');
insert into theater_booked_seat(cln, rwn, username) values(4,0,'u1@p.it');
insert into theater_booked_seat(cln, rwn, username) values(5,0,'u1@p.it');

insert into theater_booked_seat(cln, rwn, username) values(0,3,'u2@p.it');
insert into theater_booked_seat(cln, rwn, username) values(1,3,'u2@p.it');
insert into theater_booked_seat(cln, rwn, username) values(2,3,'u2@p.it');
insert into theater_booked_seat(cln, rwn, username) values(3,3,'u2@p.it');
insert into theater_booked_seat(cln, rwn, username) values(0,4,'u2@p.it');
insert into theater_booked_seat(cln, rwn, username) values(1,4,'u2@p.it');
insert into theater_booked_seat(cln, rwn, username) values(2,4,'u2@p.it');
insert into theater_booked_seat(cln, rwn, username) values(3,4,'u2@p.it');
insert into theater_booked_seat(cln, rwn, username) values(4,4,'u2@p.it');