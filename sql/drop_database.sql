-- !!IMPORTANT!!
-- This operation will drop the whole database of yecdata and can not be reverted. 
-- Please backup all the data before excuting this script.


-- Drop Accomplishment table
USE yecdata;

DROP TABLE IF EXISTS Accomplishment;
DROP TABLE IF EXISTS UserAction;
DROP TABLE IF EXISTS Action;
DROP TABLE IF EXISTS ActionCategory;
DROP TABLE IF EXISTS Forgot;
DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS OutsideBC;
DROP TABLE IF EXISTS School;
DROP TABLE IF EXISTS Administrator;
DROP TABLE IF EXISTS Notification;
DROP TABLE IF EXISTS OldAccomplishment;
DROP TABLE IF EXISTS Images;
DROP TABLE IF EXISTS RegionLock;
-- Drop the data base
DROP DATABASE IF EXISTS yecdata;

