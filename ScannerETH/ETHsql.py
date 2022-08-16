import secp256k1
import mysql.connector
from rich import print
import random

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="ethereum"
)
mycursor = mydb.cursor()    
def random_scan():
    while True:
        dec =int(random.randrange(1, 115792089237316195423570985008687907852837564279074904382605163141518161494336))
        addr = secp256k1.privatekey_to_ETH_address(dec)
        HEX = "%064x" % dec
        sql = "INSERT INTO `addresses`( `address`, `privatekey`) VALUES (%s, %s)"
        val = (addr, HEX)
        mycursor.execute(sql,val)
        mydb.commit()
        print(addr, HEX, "record inserted.")


        
def sequential_scan():
    z=int(input("'start range Min 1-115792089237316195423570985008687907852837564279074904382605163141518161494335 -> "))
    y=int(input("stop range Max 115792089237316195423570985008687907852837564279074904382605163141518161494336 -> "))

    P = z
    while P<y:
        P+=1
        dec = P
        addr = secp256k1.privatekey_to_ETH_address(dec)
        HEX = "%064x" % dec
        sql = "INSERT INTO `addresses`( `address`, `privatekey`) VALUES (%s, %s)"
        val = (addr, HEX)
        mycursor.execute(sql,val)
        mydb.commit()
        print(addr, HEX, "record inserted.")


print ("[green]\n 1 for Random Scan [/green]\n [blue]2 for Sequential Scan [/blue]")
method_input = input("\n : Type 1-2 to begin :")
if method_input=="1":
    random_scan()
elif method_input=="2":
    sequential_scan()