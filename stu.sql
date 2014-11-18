
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
        umid varchar(9) NOT NULL, 
        email varchar(256) NOT NULL, 
        phone varchar(13) NOT NULL, 
        PRIMARY KEY (id), 
        FOREIGN KEY(timeslot_id) 
        REFERENCES timeslot(id)
        );
insert into timeslot (demoDate, timeStart, timeEnd, maxSlots) Values('12/4/14', '18:00', '19:00', '6');
insert into timeslot (demoDate, timeStart, timeEnd, maxSlots) Values('12/4/14', '19:00', '20:00', '6');
insert into timeslot (demoDate, timeStart, timeEnd, maxSlots) Values('12/4/14', '20:00', '21:00', '6');
insert into timeslot (demoDate, timeStart, timeEnd, maxSlots) Values('12/5/14', '18:00', '19:00', '6');
insert into timeslot (demoDate, timeStart, timeEnd, maxSlots) Values('12/5/14', '19:00', '20:00', '6');
insert into timeslot (demoDate, timeStart, timeEnd, maxSlots) Values('12/5/14', '20:00', '21:00', '6');


insert into student (timeslot_id, fname, lname, umid, email, phone) 
Values('1', 'Benjamin', 'Maple', '6477-0198', 'bmaple@umich.edu', '(734)787-8033');


