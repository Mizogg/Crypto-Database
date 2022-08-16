# Crypto-Database
Bitcoin and Ethereum with SQL, Python, Xampp

![image](https://user-images.githubusercontent.com/88630056/184959992-fff9078c-c02f-4716-b70c-77dae8dcb0f4.png)

https://www.apachefriends.org/download.html
XAMPP for Windows 7.4.29, 8.0.19 & 8.1.6
https://downloadsapachefriends.global.ssl.fastly.net/7.4.29/xampp-windows-x64-7.4.29-1-VC15-installer.exe?from_af=true

XAMPP for Linux 7.4.29, 8.0.19 & 8.1.6
https://downloadsapachefriends.global.ssl.fastly.net/7.4.29/xampp-linux-x64-7.4.29-1-installer.run?from_af=true

Install once downloaded.

![image](https://user-images.githubusercontent.com/88630056/184960161-f89b7b4f-8f3b-4224-83cb-80c003f59767.png)

2. Delete The contents of C:\xampp\htdocs and replace with php files

3. Run Xmapp
Start Apache and MySQL open your webbrowser and go to http://localhost/phpmyadmin/

4. Create new Database bitcoin

5.Table addresses  with 5 Columns 
id int 255 primary
seed var 255
compressed var 255
uncompressed var 255
privatekey var 255


Now database is ready we can store the data. We will use BTCsql.py

pip install simplebloomfilter
pip install bitarray==1.9.2
pip install mysql-connector

![image](https://user-images.githubusercontent.com/88630056/184960476-99a3fb5d-97e7-45a8-abc0-144dbbac8d76.png)
1. bloomfilter database
2. btc txt database (mine has puzzles)
3. BTCsql.py the main orgram to scan and record results
4. Icelands library 
5. easy start bat

We can go to http://localhost/indexbtc.php to see the result or check what we have scanned.

![image](https://user-images.githubusercontent.com/88630056/184959731-c48faeb1-58c2-4e1b-8371-41712c2908c5.png)