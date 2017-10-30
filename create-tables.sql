CREATE DATABASE mathcsDB;
USE mathcsDB
CREATE TABLE course
(
courseNum VARCHAR(8) NOT NULL,
title VARCHAR(50) NOT NULL,
credits INT unsigned NOT NULL,
offering VARCHAR(50) NOT NULL,
CONSTRAINT coursePK PRIMARY KEY (courseNum)
);
CREATE TABLE degree
(
degID INT unsigned NOT NULL,
field VARCHAR(30) NOT NULL,
majorminor VARCHAR(5) NOT NULL,
CONSTRAINT degPK PRIMARY KEY (degID)
);
CREATE TABLE hasPrereq(
num VARCHAR(8) NOT NULL,
pNum VARCHAR(8) NOT NULL,
CONSTRAINT prereqPK PRIMARY KEY (num,pNum),
CONSTRAINT prereqFK FOREIGN KEY (num) REFERENCES course(courseNum),
CONSTRAINT prereqOfFK FOREIGN KEY (pnum) REFERENCES course(courseNum)
);
CREATE TABLE hasReq
(
dID INT unsigned NOT NULL,
cNum VARCHAR(8) NOT NULL,
CONSTRAINT reqPK PRIMARY KEY (dID,cNum),
CONSTRAINT reqDegFK FOREIGN KEY (dID) REFERENCES degree(degID),
CONSTRAINT reqCourseFK FOREIGN KEY (cNum) REFERENCES course(courseNum)
);
CREATE TABLE hasElec
(
elecID INT unsigned NOT NULL,
elecCount INT unsigned NOT NULL,
dID INT unsigned NOT NULL,
CONSTRAINT elecPK PRIMARY KEY (elecID),
CONSTRAINT elecFK FOREIGN KEY (dID) REFERENCES degree(degID)
);
CREATE TABLE elecBucket
(
elecID INT unsigned NOT NULL,
cNum VARCHAR(8) NOT NULL,
CONSTRAINT bucketPK PRIMARY KEY (elecID,cNum),
CONSTRAINT bucketElecFK FOREIGN KEY (elecID) REFERENCES hasElec(elecID),
CONSTRAINT bucketCourseFK FOREIGN KEY (cNum) REFERENCES course(courseNum)
);