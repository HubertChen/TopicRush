drop table member;
drop table review;
drop table product;
drop table productdetail;
drop table category;
drop table topic;
drop table content;
drop table community;
drop table joins;
drop table follows;
drop table block;

create table member(
memberid int not null AUTO_INCREMENT,
username varchar(30) not null,
password varchar(30) not null,
city varchar(30) not null,
state varchar(2) not null,
zip varchar(5) not null,
role char not null,
status int not null,
email varchar(50) not null,
joindate timestamp not null,
lastlogin timestamp not null,
primary key(memberid));

create table review(
reviewid int not null AUTO_INCREMENT,
memberid int not null,
productid int not null,
reviewdetails varchar(300) not null,
rating int not null,
reviewdata timestamp not null,
primary key(reviewid,memberid,productid));

create table product(
productid int not null AUTO_INCREMENT,
ownerid int not null,
name varchar(40) not null,
description varchar(300) not null,
rating decimal(2,1) not null,
retailprice decimal(7,2) not null,
listedprice decimal(7,2) not null,
category int not null,
numreviews int not null,
primary key(productid));

create table productdetail(
detailid int not null AUTO_INCREMENT,
productid int not null,
type int not null,
path varchar(100),
description varchar(300) not null,
primary key(detailid));

create table category(
categoryid int not null AUTO_INCREMENT,
name varchar(20) not null,
primary key(categoryid));

create table topic(
topicid int not null AUTO_INCREMENT,
communityid int not null,
ownerid int not null,
followid int,
productid int,
name varchar(50),
created timestamp not null,
primary key(topicid));

create table content(
contentid int not null AUTO_INCREMENT,
topicid int not null,
ownerid int not null,
message varchar(200),
type int not null,
path varchar(100),
description varchar(300) not null,
created timestamp not null,
primary key(contentid));

create table community(
communityid int not null AUTO_INCREMENT,
ownerid int not null,
name varchar(30) not null,
created timestamp not null,
nummembers int,
numtopics int,
primary key(communityid));

create table joins(
memberid int not null,
communityid int not null,
primary key(memberid,communityid));

create table follows(
memberid int not null,
topicid int not null,
primary key(memberid,topicid));

create table block(
memberid int not null,
communityid int not null,
primary key(memberid, communityid));


delimiter //
drop trigger if exists member_joins //
create trigger member_joins after insert on joins
for each row
begin
  declare oldmembers integer;
  declare community integer;
  set community = new.communityid;
  select nummembers into oldmembers from community where communityid=community;
  update community set nummembers=(oldmembers + 1) where communityid=community;
end//


delimiter //
drop trigger if exists member_leaves //
create trigger member_leaves
before delete on joins
for each row
begin
  declare oldmembers int;
  declare community int;
  set community = old.communityid;
  select nummembers into oldmembers from community where communityid=community;
  update community set nummembers=(oldmembers - 1) where communityid=community;
end //



delimiter //
drop trigger if exists add_topic //
create trigger add_topic
after insert on topic
for each row
begin
  declare oldtopics int;
  declare community int;
  set community = new.communityid;
  select numtopics into oldtopics from community where communityid=community;
  update community set numtopics=(oldtopics + 1) where communityid=community;
end//

delimiter ;



