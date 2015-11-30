
use bookstore;
/* Populate initial data */
INSERT INTO admins (username,passwdhash) VALUES('admin','$6$.WJ.cxDM$aKOoFZZNZqWPj1B4J8hxfNxkgx1S5u9mcghKyM2S.gABcwGNY8.YOUugIKZGWRXXj4OyYbLAVLkNd.ZRUwjSB0');
INSERT INTO users (username,lastname,firstname,address,city,state,zip,telephone,email,passwdhash,cctype,ccnumber,ccexpdate,isenabled)  VALUES('whilson','Hilson','Walter','3829 N. Sputnik St.','Moscow','ID','83844','2085551212','nota.real@email.com','$6$pAzzRj8k$msQhxbBEpyH7pnnZ6KwG8w8oKdEEi4p1U8zlDmvD2u9Z2KNWtK.sheO0VBk03yd0ZH/ZnMJjmzDrWuy4qqSGH0','V',3912394029381003,102016,'Y');
INSERT INTO users (username,lastname,firstname,address,city,state,zip,telephone,email,passwdhash,cctype,ccnumber,ccexpdate,isenabled)  VALUES('mcpherson','McPherson','Alan','499 N. Main Street','Main Street','MI','48377','7345551212','fakeperson@nowhere.com','$6$neKpXgnt$1eqWZ3l6ayyYBwB9VntAZL2pWdBqX2WdP2tK/d96GXBpr13kecBNaAD6ri7zWtVigs7cTrxBg9wwjXiXm1uOw.','M',3928034918827399,122017,'Y');
INSERT INTO users (username,lastname,firstname,address,city,state,zip,telephone,email,passwdhash,cctype,ccnumber,ccexpdate,isenabled)  VALUES('rblues','Blues','Rhythm','4939 N. Hacker Street','Hacker','MI','45678','2485559999','adisableduser@hacker.com','$6$..1wrLkL$JSxAcLbLep3KYKG2WwVsG5GVBsDRM63rw6aehAOpYMYGScmuO.c/nt5prso1p8.oiwCTPcZDol.JH2..jHror1','V',4837399203992811,012018,'N');
INSERT INTO books (isbn,title,author,subject,pubyear,description,imageurl,quantity,supplier,price)  VALUES('382759103548','Introduction to Finance','Sherry Platt','Finance','2012','This is a book description','images/book.jpg','12','Morton House books','39.99');
INSERT INTO books (isbn,title,author,subject,pubyear,description,imageurl,quantity,supplier,price)  VALUES('349123428183','Where the Wild Things Are','Maurice Sendak','Fiction','1974','A favorite of children\'s literature','images/book.jpg','10','Harper and Row','12.99');
INSERT INTO books (isbn,title,author,subject,pubyear,description,imageurl,quantity,supplier,price)  VALUES('349138103922','American Government: A History','Janet Jones','History','2011','This is a book description','images/book.jpg','3','Grover Educational books','59.99');
INSERT INTO books (isbn,title,author,subject,pubyear,description,imageurl,quantity,supplier,price)  VALUES('493188204823','Internet for Dummies','Margaret Young','Computers','2012','For dummies series','images/book.jpg','0','Wiley and Sons','31.99');

INSERT INTO books (isbn,title,author,subject,pubyear,description,imageurl,quantity,supplier,price)  VALUES('12345678901234','Great Gatsby (The)','F. Scott Fitzgerald','Fiction','1922','Classic book on the Roaring \'20s.','images/book.jpg','8','Random House','9.99');
INSERT INTO books (isbn,title,author,subject,pubyear,description,imageurl,quantity,supplier,price)  VALUES('23456789012345','To Kill a Mockingbird','Harper Lee','Fiction','1958','Classic book on racial strife in the deep south in the 1950s.','images/book.jpg','6','Penguin books','12.99');
INSERT INTO books (isbn,title,author,subject,pubyear,description,imageurl,quantity,supplier,price)  VALUES('34567890123456','Animal Farm','George Orwell','Fiction','1945','Classic book on totalitarianism featuring animals who overthrow rule by humans only to be ruled by other animals.','images/book.jpg','0','Random House','10.99');
INSERT INTO books (isbn,title,author,subject,pubyear,description,imageurl,quantity,supplier,price)  VALUES('45678901234567','Animal Farming Methods','George Foreman','Agriculture','2007','A book for beginning farmers.','images/book.jpg','8','Spirit House','23.99');
INSERT INTO books (isbn,title,author,subject,pubyear,description,imageurl,quantity,supplier,price)  VALUES('56789012345678','Washington Crosses the Delaware','Hans Hessman','History','1907','History of the Revolutionary War.','images/book.jpg','11','Fairport Publishing','13.99');
INSERT INTO carts (username,itemno,itemisbn,itemqty,itemprice) VALUES('mcpherson','1','56789012345678','1','13.99');
UPDATE books SET buyerdate='2015-11-27';

INSERT INTO orders (ordernumber,username,orderdate,ordsecnum,orderstatus,orderitems,ordertotal) VALUES('1','mcpherson','2015-11-27','0000','C','1','13.99');
INSERT INTO items (ordernumber,itemno,itemisbn,itemqty,itemprice) VALUES('1','1','56789012345678','1','13.99');

INSERT INTO orders (ordernumber,username,orderdate,ordsecnum,orderstatus,orderitems,ordertotal) VALUES('2','whilson','2015-11-28','1234','C','2','26.98');
INSERT INTO items (ordernumber,itemno,itemisbn,itemqty,itemprice) VALUES('2','1','56789012345678','1','13.99');
INSERT INTO items (ordernumber,itemno,itemisbn,itemqty,itemprice) VALUES('2','2','23456789012345','1','12.99');

INSERT INTO orders (ordernumber,username,orderdate,ordsecnum,orderstatus,orderitems,ordertotal) VALUES('3','mcpherson','2015-11-28','0000','C','1','31.99');
INSERT INTO items (ordernumber,itemno,itemisbn,itemqty,itemprice) VALUES('3','1','493188204823','1','31.99');
