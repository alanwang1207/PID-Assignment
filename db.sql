create database pid;

use pid;

CREATE TABLE `user` (
  `uid` int NOT NULL auto_increment primary key,
  `username` varchar(20) NOT NULL,
  `password` varchar(30) NOT NULL,
  `dis` boolean DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `prod` (
  `pid` int NOT NULL auto_increment primary key,
  `prodname` varchar(20) NOT NULL,
  `prodcount` int NOT NULL,
  `tempcount` int NOT NULL,
  `cash` int DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `cart` (
  `did` int NOT NULL auto_increment primary key,
  `uid` int NOT NULL,
  `pid` int not null,
  `count` int NOT NULL,
  FOREIGN KEY (`uid`) REFERENCES user(`uid`),
  FOREIGN KEY (`pid`) REFERENCES prod(`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `detail` (
  `did` int NOT NULL ,
  `uid` int NOT NULL,
  `prodname` varchar(20) NOT NULL,
  `prodcount` int NOT NULL,
  `cash` int NOT NULL,
  `total` int NOT NULL,
  `date` varchar(20)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user` (`uid`,`username`,`password`,`dis`) VALUES
(1,'admin','111','0'),
(2,'jason','111','0'),
(3,'hamber','111','0'),
(4,'riven','111','0');

INSERT INTO `prod` (`pid`,`prodname`,`prodcount`,`tempcount`,`cash`) VALUES
(1,'apple',100,100,20),
(2,'orange',100,100,30),
(3,'guava',100,100,40),
(4,'lemon',100,100,50);




