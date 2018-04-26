-- Add the database user to access the yec database. 
-- ATTENTION: Excute the following statements with root privillege.
CREATE USER 'yecuser'@'localhost' IDENTIFIED BY 'yec123!Q@W#E';
GRANT ALL PRIVILEGES ON *.* TO 'yecuser'@'localhost' WITH GRANT OPTION;

