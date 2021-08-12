CREATE TABLE `resource` (
  `bookid` int(11) NOT NULL auto_increment,
  `bookno` int(2) NOT NULL,
  `isbn` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `author` varchar(20) NOT NULL,
  `publisher` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `rcost` DECIMAL(5,2) NOT NULL,
  `ecost` DECIMAL(5,2) NOT NULL,
  PRIMARY KEY  (`bookid`)
);