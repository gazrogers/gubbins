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
    FOREIGN KEY (`userId`) REFERENCES `users`(`userId`)
) ENGINE=InnoDB;

CREATE TABLE `followGraph` (
    `followed` int NOT NULL,
    `follower` int NOT NULL,

    PRIMARY KEY (`followed`, `follower`),
    FOREIGN KEY (`followed`) REFERENCES `users`(`userId`),
    FOREIGN KEY (`follower`) REFERENCES `users`(`userId`)
) ENGINE=InnoDB;

CREATE TABLE `posts` (
    `postId` int NOT NULL AUTO_INCREMENT,
    `userId` int NOT NULL,
    `content` varchar(255) NOT NULL,
    `created` datetime NOT NULL,

    PRIMARY KEY (`postId`),
    FOREIGN KEY (`userId`) REFERENCES `users`(`userId`)
) ENGINE=InnoDB;