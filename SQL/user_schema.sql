CREATE TABLE IF NOT EXISTS `users` (
`userid` int(11) NOT NULL AUTO_INCREMENT,
`username` varchar(32) NOT NULL UNIQUE,
`fullname` varchar(50) NOT NULL,
`email` varchar(100) NOT NULL,
`password` varchar(100) NOT NULL,
`salt` varchar(256) NOT NULL,
`join_date` date NOT NULL,
PRIMARY KEY (`userid`),
UNIQUE (`username`),
UNIQUE (`email`)
);