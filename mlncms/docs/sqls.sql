CREATE TABLE `masters` (
     `id` int(10) NOT NULL AUTO_INCREMENT,
     `username` varchar(255) NOT NULL,
     `salt` varchar(5) NOT NULL,
     `password` varchar(255) NOT NULL,
     `groupId` int(11) NOT NULL,
     PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mastergroups` (
     `id` int(10) NOT NULL AUTO_INCREMENT,
     `name` varchar(255) NOT NULL,
     `hasprivilege` text NOT NULL,
     PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
