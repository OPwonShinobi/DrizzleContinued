Description:
1. setup_clean: this script will set up a clean database with just the super admin yecadmin@drizzlesociety.org
2. setup_for_test: this script will set up a database with some randomly generated test data. It maybe useful for demo/presentation before it is actually online.

Usage:
1. ssh into the server.
2. use 'cd' command to switch the working directory to /home/yecuser/html/sql. You can you 'pwd' command to check the working dirctory. 
3. type the script name in command line to run the script you want:
./setup_clean      # run the clean setup without test data.
./setup_for_test   # run the setup with test data.


#NOTE: 
1. Make sure the current working dirctory are correct.
2. The commands above must contain the "./".
3. You MUST enter the password for yecuser to continue. When you are typing the password, nothing will show up in the screen. Just keep typing and hit enter key to finish.
4. If you run the script and get an error of "permission denied", you may need to check whether the script file in "excute" mode:

ls -l <file name>
-rwxr--r--  1 yecuser yecuser   280 May 27 12:54 setup_clean
-rwxr--r--  1 yecuser yecuser   380 May 27 12:54 setup_for_test

if the files is not executable, use the command below to change the mode:
sudo chmod 744 <file>
