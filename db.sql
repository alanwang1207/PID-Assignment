create database test1;

use test1;

CREATE TABLE `user` (
  `id` int NOT NULL auto_increment primary key,
  `username` varchar(20) NOT NULL,
  `password` varchar(30) NOT NULL,
  `dis` boolean DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user` (`id`,`username`,`password`) VALUES
(1,'aaa','111'),
(2,'bbb','222');