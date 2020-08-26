create database test1;

use test1;

CREATE TABLE `user` (
  `uid` int NOT NULL auto_increment primary key,
  `username` varchar(20) NOT NULL,
  `password` varchar(30) NOT NULL,
  `dis` boolean DEFAULT 0,
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `prod` (
  `pid` int NOT NULL auto_increment primary key,
  `prodname` varchar(20) NOT NULL,
  `prodcount` int NOT NULL,
  `cash` int DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `cart` (
  `did` int NOT NULL auto_increment primary key,
  `uid` int NOT NULL,
  `prodname` varchar(20) NOT NULL,
  `prodcount` int NOT NULL,
  `cash` int,
  `total` int DEFAULT 0,
  FOREIGN KEY (`cid`) REFERENCES customer(`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

CREATE TABLE `detail` (
  `did` int NOT NULL auto_increment primary key,
  `uid` int NOT NULL,
  `pid` int not null,
  `prodname` varchar(20) NOT NULL,
  `prodcount` int NOT NULL,
  `cash` int,
  `total` int DEFAULT 0,
  FOREIGN KEY (`cid`) REFERENCES customer(`cid`)
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

INSERT INTO `black_list` (`bid`,`dis`) VALUES
(1,0),
(2,0);


購物清單 detail
購買人 購買商品 數量 總金額

select customer, prodname,prodcount,total
from  

可建立購物車表
把值都記得
接著丟到購物車介面 然後要計算總金額

確認購買跳到訂單詳情頁



