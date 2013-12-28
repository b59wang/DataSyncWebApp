CREATE TABLE IF NOT EXISTS `data`(
`dataid` int(11) NOT NULL AUTO_INCREMENT,
`userid` int(11) NOT NULL,
`type` varchar(32) NOT NULL,
`text` varchar(256),
`url` varchar(100),
`date` datetime NOT NULL,
PRIMARY KEY (`dataid`),
FOREIGN KEY (`userid`) REFERENCES users(`userid`)
);
