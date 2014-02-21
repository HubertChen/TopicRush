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

