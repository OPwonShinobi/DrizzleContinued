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
-- Create action table
CREATE TABLE IF NOT EXISTS Action(
	ID           INTEGER(8) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	Description  TEXT       NOT NULL,
	Points       Integer(2) NOT NULL,
  DateEntered  TIMESTAMP  NOT NULL,
	Active       Boolean    DEFAULT TRUE
);

-- Create UserAction table
CREATE TABLE IF NOT EXISTS UserAction(
	UserID       Integer(8) NOT NULL,
	ActionID     Integer(8) NOT NULL,
	PRIMARY KEY(UserID, ActionID),
	FOREIGN KEY(UserID) REFERENCES User(ID),
	FOREIGN KEY(ActionID) REFERENCES Action(ID)
);

-- Create Accomplishment table
CREATE TABLE IF NOT EXISTS Accomplishment(
	UserID       Integer(8) NOT NULL,
	ActionID     Integer(8) NOT NULL,
	CompleteTime DATETIME   NOT NULL,
	PRIMARY KEY(UserID, ActionID, CompleteTime),
	FOREIGN KEY(UserID) REFERENCES User(ID),
	FOREIGN KEY(ActionID) REFERENCES Action(ID)
);

-- Create Admin table
CREATE TABLE IF NOT EXISTS Admin(
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
    expires DATETIME
);

-- Notification
CREATE TABLE IF NOT EXISTS Notification (
    Message   VARCHAR(256),
    PostTime  DATETIME
);

-- Create OldAccomplishment table
CREATE TABLE IF NOT EXISTS OldAccomplishment (
	UserID       Integer(8) NOT NULL,
	ActionID     Integer(8) NOT NULL,
	CompleteTime DATETIME   NOT NULL
); 

-- Insert initial action data
INSERT INTO Action VALUES (NULL, 'Organized a park cleanup', 5,CURRENT_TIMESTAMP, TRUE);
INSERT INTO Action VALUES (NULL, 'Raised awareness for an environmental issue', 4,CURRENT_TIMESTAMP, TRUE);
INSERT INTO Action VALUES (NULL, 'Went for a nature walk or hike', 2,CURRENT_TIMESTAMP, TRUE);
INSERT INTO Action VALUES (NULL, 'Picked up garbage at the local beach', 4,CURRENT_TIMESTAMP, TRUE);
INSERT INTO Action VALUES (NULL, 'Introduced a compost bin to your home', 3,CURRENT_TIMESTAMP, TRUE);
INSERT INTO Action VALUES (NULL, 'Carpooled', 2,CURRENT_TIMESTAMP, TRUE);
INSERT INTO Action VALUES (NULL, 'Recycled a used item', 2,CURRENT_TIMESTAMP, TRUE);
INSERT INTO Action VALUES (NULL, 'Rode my bike to school or work', 2,CURRENT_TIMESTAMP, TRUE);
INSERT INTO Action VALUES (NULL, 'Created a community or school garden', 5,CURRENT_TIMESTAMP, TRUE);
INSERT INTO Action VALUES (NULL, 'Bought and used a reusable water bottle', 1,CURRENT_TIMESTAMP, TRUE);
INSERT INTO Action VALUES (NULL, 'Turned off all electronics at nighttime', 2,CURRENT_TIMESTAMP, TRUE);
INSERT INTO Action VALUES (NULL, 'Went vegetarian or vegan for a day', 3,CURRENT_TIMESTAMP, TRUE);
INSERT INTO Action VALUES (NULL, 'Volunteered for an environmental organization', 5,CURRENT_TIMESTAMP, TRUE);
INSERT INTO Action VALUES (NULL, 'Took public transit instead of driving', 2,CURRENT_TIMESTAMP, TRUE);
INSERT INTO Action VALUES (NULL, 'Fundraised for an environmental charity', 5,CURRENT_TIMESTAMP, TRUE);
INSERT INTO Action VALUES (NULL, 'Practiced \"leave no trace\" when camping', 3,CURRENT_TIMESTAMP, TRUE);
INSERT INTO Action VALUES (NULL, 'Donate used items to a charity', 3,CURRENT_TIMESTAMP, TRUE);
INSERT INTO Action VALUES (NULL, 'Retweeted a Drizzle tweet', 1,CURRENT_TIMESTAMP, TRUE);
INSERT INTO Action VALUES (NULL, 'Shared a Drizzle Facebook post', 1,CURRENT_TIMESTAMP, TRUE);
INSERT INTO Action VALUES (NULL, 'An obsolete action', 1,CURRENT_TIMESTAMP, FALSE);


-- Insert the super admin account
-- This account is recommend to be used to add other admins only
INSERT INTO Admin VALUES (NULL, 'yecadmin', '$2y$12$9DVHJ2/TGJ6zzoucPLM5AO3bV2pQcl3sR911sOp/1lk1G1VoYz6aW', 'yecadmin@drizzlesociety.org', 9);

