CREATE DATABASE `dev_gubbins`;
CREATE DATABASE `autotests_gubbins`;
USE `dev_gubbins`;

CREATE TABLE `users` (
    `userId` int NOT NULL AUTO_INCREMENT,
    `username` varchar(255) NOT NULL,

    PRIMARY KEY (`userId`)
) ENGINE=InnoDB;

CREATE TABLE `googleLogins` (
    `googleSubject` varchar(255) NOT NULL,
    `userId` int NOT NULL,
    
    PRIMARY KEY (`googleSubject`),
    FOREIGN KEY (`userId`) REFERENCES `users`(`userId`),
) ENGINE=InnoDB;