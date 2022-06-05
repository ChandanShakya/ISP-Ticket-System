CREATE TABLE IF NOT EXISTS `users` (
	`id` int NOT NULL AUTO_INCREMENT,
	`username` varchar(255) NOT NULL,
	`email` varchar(255) NOT NULL,
	`password` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=UTF8MB4;

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES (1, 'admin', 'admin@admin.com','admin');
INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES (2, 'chandan', 'chandan@user.com','chandan');
INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES (3, 'sanisha', 'sanisha@sanisha.com','sanisha');
INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES (4, 'kabir', 'kabir@user.com','kabir');

CREATE TABLE IF NOT EXISTS `tickets` (
	`id` int NOT NULL AUTO_INCREMENT,
	`title` varchar(255) NOT NULL,
	`msg` text NOT NULL,
	`phone` varchar(10) NOT NULL,
	`created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`status` enum('open','closed','resolved') NOT NULL DEFAULT 'open',
	`uid` int NOT NULL,
	PRIMARY KEY (`id`),
	foreign key (uid) references users(id) on delete cascade
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=UTF8MB4;

INSERT INTO `tickets` (`id`, `title`, `msg`, `phone`, `created`, `status`,`uid`) VALUES (1, 'Test Ticket', 'This is your first ticket.', '9843177804', '2022-06-05 13:06:17', 'open', 1);

CREATE TABLE IF NOT EXISTS `tickets_comments` (
	`id` int NOT NULL AUTO_INCREMENT,
	`ticket_id` int NOT NULL,
	`msg` text NOT NULL,
	`created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`uid` int NOT NULL,
	PRIMARY KEY (`id`),
	foreign key (ticket_id) references tickets(id) on delete cascade,
	foreign key (uid) references users(id)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=UTF8MB4;

INSERT INTO `tickets_comments` (`id`, `ticket_id`, `msg`, `created`,`uid`) VALUES (1, 1, 'This is a test comment.', '2022-06-05 16:23:39', 1);
