create database test1;

use test1;

CREATE TABLE `user` (
  `uid` int NOT NULL auto_increment primary key,
  `username` varchar(20) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `prod` (
  `pid` int NOT NULL auto_increment primary key,
  `prodname` varchar(20) NOT NULL,
  `prodcount` int NOT NULL,
  `cash` int DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `customer` (
  `cid` int NOT NULL auto_increment primary key,
  `username` varchar(20) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS black_list (
  `bid` int NOT NULL primary key,
  `dis` boolean DEFAULT 0,
  FOREIGN KEY (`bid`) REFERENCES customer(`cid`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `user` (`uid`,`username`,`password`) VALUES
(1,'aaa','111'),
(2,'bbb','222');

INSERT INTO `prod` (`pid`,`prodname`,`prodcount`,`cash`) VALUES
(1,'apple',2,20),
(2,'orange',4,30);

INSERT INTO `customer` (`cid`,`username`,`password`) VALUES
(1,'cusaaa','111'),
(2,'cusbbb','222');


購物清單 detail
購買人 購買商品 數量 總金額

select customer, prodname,prodcount,total
from  