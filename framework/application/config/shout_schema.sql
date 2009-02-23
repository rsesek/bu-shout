CREATE TABLE IF NOT EXISTS comments
(
	id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	submission_id int(11) NOT NULL,
	body text NOT NULL,
	ip varchar(40) NOT NULL,
	date datetime NOT NULL,
	KEY submission_id (submission_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS submissions
(
	id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	title varchar(64) NOT NULL,
	body text NOT NULL,
	ip varchar(40) NOT NULL,
	date datetime NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS users
(
	id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	username varchar(32) NOT NULL,
	password varchar(32) NOT NULL
) ENGINE=MyISAM;


ALTER TABLE comments ADD CONSTRAINT comments_ibfk_1 FOREIGN KEY (submission_id) REFERENCES submissions (id) ON DELETE CASCADE ON UPDATE CASCADE;
