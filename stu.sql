
CREATE TABLE timeslot( 
        id INT NOT NULL AUTO_INCREMENT, 
        demoDate DATE NOT NULL,  
        timeStart TIME NOT NULL, 
        timeEnd TIME NOT NULL, 
        maxSlots INT NOT NULL,
        PRIMARY KEY (id)
        );


CREATE TABLE student( 
        id INT NOT NULL AUTO_INCREMENT, 
        timeslot_id INT NOT NULL, 
        fname varchar(45) NOT NULL, 
        lname varchar(45) NOT NULL,  
        umid varchar(8) NOT NULL, 
        email varchar(80) NOT NULL, 
        phone varchar(12) NOT NULL, 
        PRIMARY KEY (id), 
        FOREIGN KEY(timeslot_id) 
        REFERENCES timeslot(id)
        );
insert into timeslot (demoDate, timeStart, timeEnd, maxSlots) Values('12/4/14', '6:00 PM', '7:00 PM', '6');
insert into timeslot (demoDate, timeStart, timeEnd, maxSlots) Values('12/4/14', '7:00 PM', '8:00 PM', '6');
insert into timeslot (demoDate, timeStart, timeEnd, maxSlots) Values('12/4/14', '8:00 PM', '9:00 PM', '6');
insert into timeslot (demoDate, timeStart, timeEnd, maxSlots) Values('12/5/14', '6:00 PM', '7:00 PM', '6');
insert into timeslot (demoDate, timeStart, timeEnd, maxSlots) Values('12/5/14', '7:00 PM', '8:00 PM', '6');
insert into timeslot (demoDate, timeStart, timeEnd, maxSlots) Values('12/5/14', '8:00 PM', '9:00 PM', '6');


insert into student (timeslot_id, fname, lname, umid, email, phone) 
Values('1', 'ben', 'maple', '11111111', 'lol@no.com', '555-555-5555');


