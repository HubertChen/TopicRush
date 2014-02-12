Create or replace trigger event_update
AFTER
UPDATE of title, location, time1, time2 
on event
for each row

DECLARE 
updated_user integer;
new_notice number;

SELECT userID into updated_user from follow where eventID = :new.eventID;
SELECT trig_seq.nextval INTO new_notice FROM dual;

case
when updating ('title') then
		insert into notice values(new_notice , 'New_tittle', sysdate);
		insert into sent values (updated_user,updated_user,'Unread');
	when updating ('location') then
		insert into notice values(new_notice , 'New_Location', sysdate);
		insert into sent values (updated_user,updated_user,'Unread');
	when updating ('time1') then
		insert into notice values(new_notice , 'New_Time1', sysdate);
		insert into sent values (updated_user,updated_user,'Unread');
	when updating ('time2') then
		insert into notice values(new_notice , 'New_time2', sysdate);
		insert into sent values (updated_user,updated_user,'Unread');
	end case;
/*Select userID FROM follow WHERE eventID=:NEW.eventID;
BEGIN

SELECT trig_seq.nextval INTO new_notice FROM dual;
INSERT into notice(noticeID, content, time)
Values(new_notice, 'There has been an update to the event!', sysdate);

INSERT into sent(userID, noticeID, status)
Vaules(updated_user, new_notice, 'Unread'); */


end;
/
