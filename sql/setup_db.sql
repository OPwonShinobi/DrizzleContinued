-- IMPORTANT:
-- Please use root accout to excute the "create_db_user" before setting up the database;

-- Create database
CREATE DATABASE IF NOT EXISTS yecdata;

-- Use database
USE yecdata;

-- Create School table
CREATE TABLE IF NOT EXISTS School(
	ID            INTEGER(8)   NOT NULL PRIMARY KEY AUTO_INCREMENT,
	SchoolName    VARCHAR(60)  NOT NULL,
	Country       VARCHAR(40)  NOT NULL,
	StateProvince VARCHAR(40)  NOT NULL,
	City          VARCHAR(60)  NOT NULL
);


-- Create user table
-- User's school must already exist in db
CREATE TABLE IF NOT EXISTS User(
	ID            INTEGER(8)   NOT NULL PRIMARY KEY AUTO_INCREMENT,
	Password      VARCHAR(256) NOT NULL,
	FirstName     VARCHAR(30)  NOT NULL,
	LastName      VARCHAR(30)  NOT NULL,
	NickName      VARCHAR(20)  NOT NULL DEFAULT 'anonymous',
	PhotoId       INTEGER(8)   NOT NULL DEFAULT 0,
	SchoolID      INTEGER(8)   NOT NULL,
	Email
	  VARCHAR(64)  NOT NULL UNIQUE,
	Authorization INTEGER(1)   NOT NULL DEFAULT 0,
	FOREIGN KEY(SchoolID) REFERENCES School(ID)
);

CREATE TABLE IF NOT EXISTS OutsideBC (
	ID            INTEGER(8)   NOT NULL PRIMARY KEY AUTO_INCREMENT,
	FirstName     VARCHAR(30)  NOT NULL,
	LastName      VARCHAR(30)  NOT NULL,
	Country       VARCHAR(40)  NOT NULL,
	State         VARCHAR(40)  NOT NULL,
	City          VARCHAR(60)  NOT NULL,
	Email         VARCHAR(60)  NOT NULL UNIQUE
);

-- Lists categories of actions user can select
-- Note that any changes here will cascade to actions with that option
CREATE TABLE IF NOT EXISTS ActionCategory (
    CategoryName   VARCHAR(128) NOT NULL,
    CategoryDescription  VARCHAR(256) NOT NULL,
    PRIMARY KEY(CategoryName)
);

-- Create action table
-- updates with actioncategory table
-- deleting entries from actioncategory will be allowed & affect this table
-- but for truncating / dropping actioncategory before action table is changed,
-- do the following:
-- SET FOREIGN_KEY_CHECKS = 0;
--    TRUNCATE / DROP TABLE actioncategory;
-- 	  TRUNCATE / DROP TABLE action; 
-- SET FOREIGN_KEY_CHECKS = 1;
CREATE TABLE IF NOT EXISTS Action(
	ID           INTEGER(8) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	Description  TEXT       NOT NULL,
	Points       Integer(2) NOT NULL,
  	DateEntered  TIMESTAMP  NOT NULL,
	Active       Boolean    DEFAULT TRUE,
	Category	 VARCHAR(128) NOT NULL,
	FOREIGN KEY(Category) REFERENCES ActionCategory(CategoryName) ON UPDATE CASCADE ON DELETE CASCADE
);

-- Create UserAction table
-- if any user is deleted (not truncated or dropped) 
--    their entry will be deleted from here too
-- if any action is deleted (not truncated or dropped) that entry
--    that entry will be deleted from here too
CREATE TABLE IF NOT EXISTS UserAction(
	UserID       Integer(8) NOT NULL,
	ActionID     Integer(8) NOT NULL,
	CompleteTime TIMESTAMP NULL,
	PRIMARY KEY(UserID, ActionID),
	FOREIGN KEY(UserID) REFERENCES User(ID) ON DELETE CASCADE,
	FOREIGN KEY(ActionID) REFERENCES Action(ID) ON DELETE CASCADE
);

-- Create Accomplishment table
-- if any user is deleted (not truncated or dropped) 
--    their entry will be deleted from here too
-- if any action is deleted (not truncated or dropped) that entry
--    that entry will be deleted from here too
CREATE TABLE IF NOT EXISTS Accomplishment(
	UserID       Integer(8) NOT NULL,
	ActionID     Integer(8) NOT NULL,
	CompleteTime TIMESTAMP NOT NULL,
	PRIMARY KEY(UserID, ActionID, CompleteTime),
	FOREIGN KEY(UserID) REFERENCES User(ID) ON DELETE CASCADE,
	FOREIGN KEY(ActionID) REFERENCES Action(ID) ON DELETE CASCADE
);

-- Create Admin table
CREATE TABLE IF NOT EXISTS Administrator (
	ID            INTEGER(8)   NOT NULL PRIMARY KEY AUTO_INCREMENT,
	Username      VARCHAR(20)  NOT NULL,
	Password      VARCHAR(256) NOT NULL,
	Email         VARCHAR(64)  NOT NULL UNIQUE,
	Authorization INTEGER(1)   NOT NULL DEFAULT 0
);

-- Create Forgot table
CREATE TABLE IF NOT EXISTS Forgot (
    Email         VARCHAR(64)  NOT NULL UNIQUE,
    selector      VARCHAR(256),
    expires TIMESTAMP
);

-- Notification
CREATE TABLE IF NOT EXISTS Notification (
    Message   VARCHAR(256),
    PostTime  TIMESTAMP
);

-- Create OldAccomplishment table
CREATE TABLE IF NOT EXISTS OldAccomplishment (
	UserID       Integer(8) NOT NULL,
	ActionID     Integer(8) NOT NULL,
	CompleteTime TIMESTAMP   NOT NULL
); 

-- Create image table - Roger
CREATE TABLE IF NOT EXISTS Images (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `image` longblob NOT NULL,
 `created` datetime NOT NULL,
 `favflag` int DEFAULT 0,
 `userID` int NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO ActionCategory VALUES ('Activism', 'You do stuff, usually around the community');
INSERT INTO ActionCategory VALUES ('Transportation', 'Getting around comes around');
INSERT INTO ActionCategory VALUES ('Energy', 'Conservation of energy is not only a law but is encouraged');
INSERT INTO ActionCategory VALUES ('Reduce Reuse Recycle', 'The 3 Rs');
INSERT INTO ActionCategory VALUES ('Food', 'Eat money. Save better');
INSERT INTO ActionCategory VALUES ('Social Media', 'Tell your friends. Help spread the word!');
INSERT INTO ActionCategory VALUES ('Outdoors', 'Natural green is best green!');

-- Insert initial action data
INSERT INTO Action VALUES (NULL, 'Organized a park cleanup', 5,CURRENT_TIMESTAMP, TRUE,'Activism');
INSERT INTO Action VALUES (NULL, 'Raised awareness for an environmental issue', 4,CURRENT_TIMESTAMP, TRUE,'Activism');
INSERT INTO Action VALUES (NULL, 'Went for a nature walk or hike', 2,CURRENT_TIMESTAMP, TRUE,'Transportation');
INSERT INTO Action VALUES (NULL, 'Picked up garbage at the local beach', 4,CURRENT_TIMESTAMP, TRUE,'Activism');
INSERT INTO Action VALUES (NULL, 'Introduced a compost bin to your home', 3,CURRENT_TIMESTAMP, TRUE,'Activism');
INSERT INTO Action VALUES (NULL, 'Carpooled', 2,CURRENT_TIMESTAMP, TRUE,'Transportation');
INSERT INTO Action VALUES (NULL, 'Recycled a used item', 2,CURRENT_TIMESTAMP, TRUE,'Reduce Reuse Recycle');
INSERT INTO Action VALUES (NULL, 'Rode my bike to school or work', 2,CURRENT_TIMESTAMP, TRUE,'Transportation');
INSERT INTO Action VALUES (NULL, 'Created a community or school garden', 5,CURRENT_TIMESTAMP, TRUE,'Activism');
INSERT INTO Action VALUES (NULL, 'Bought and used a reusable water bottle', 1,CURRENT_TIMESTAMP, TRUE,'Reduce Reuse Recycle');
INSERT INTO Action VALUES (NULL, 'Turned off all electronics at nighttime', 2,CURRENT_TIMESTAMP, TRUE,'Energy');
INSERT INTO Action VALUES (NULL, 'Went vegetarian or vegan for a day', 3,CURRENT_TIMESTAMP, TRUE,'Food');
INSERT INTO Action VALUES (NULL, 'Volunteered for an environmental organization', 5,CURRENT_TIMESTAMP, TRUE,'Activism');
INSERT INTO Action VALUES (NULL, 'Took public transit instead of driving', 2,CURRENT_TIMESTAMP, TRUE,'Transportation');
INSERT INTO Action VALUES (NULL, 'Fundraised for an environmental charity', 5,CURRENT_TIMESTAMP, TRUE,'Activism');
INSERT INTO Action VALUES (NULL, 'Practiced \"leave no trace\" when camping', 3,CURRENT_TIMESTAMP, TRUE,'Outdoors');
INSERT INTO Action VALUES (NULL, 'Donate used items to a charity', 3,CURRENT_TIMESTAMP, TRUE,'Reduce Reuse Recycle');
INSERT INTO Action VALUES (NULL, 'Retweeted a Drizzle tweet', 1,CURRENT_TIMESTAMP, TRUE,'Social Media');
INSERT INTO Action VALUES (NULL, 'Shared a Drizzle Facebook post', 1,CURRENT_TIMESTAMP, TRUE,'Social Media');
-- INSERT INTO Action VALUES (NULL, 'An obsolete action', 1,CURRENT_TIMESTAMP, FALSE,'Default');

-- Insert the super admin account
-- This account is recommend to be used to add other admins only
INSERT INTO Administrator VALUES (NULL, 'yecadmin', '$2y$12$9DVHJ2/TGJ6zzoucPLM5AO3bV2pQcl3sR911sOp/1lk1G1VoYz6aW', 'yecadmin@drizzlesociety.org', 9);
