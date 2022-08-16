import secp256k1
import mysql.connector
from rich import print
from bloomfilter import BloomFilter, ScalableBloomFilter, SizeGrowthRate
from pathlib import Path
import random

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="bitcoin"
)
mycursor = mydb.cursor()

with open("btc.txt","r") as m: #Your Address List mix of addresses .txt 
    fill = m.read().split()
fill= set(fill)

bloombtc = Path(__file__).resolve() #Your Address List mix of addresses .bf
ressbtc = bloombtc.parents[0] / 'btc.bf'
with open(ressbtc, "rb") as fp:
    bloom_filter = BloomFilter.load(fp)
    
def random_scan():
    while True:
        dec =int(random.randrange(1073741823, 115792089237316195423570985008687907852837564279074904382605163141518161494336))
        uaddr = secp256k1.privatekey_to_address(0, False, dec)
        caddr = secp256k1.privatekey_to_address(0, True, dec)
        HEX = "%064x" % dec
        sql = "INSERT INTO `addresses`( `seed`, `compressed`, `uncompressed`, `privatekey`) VALUES (%s, %s, %s, %s)"
        val = (dec, caddr, uaddr, HEX)
        mycursor.execute(sql,val)
        mydb.commit()
        print(uaddr, caddr, "record inserted.")
        if uaddr in fill or uaddr in bloom_filter:
            wifu = secp256k1.btc_pvk_to_wif(HEX, False)
            print('\nMatch Found UnCompressed')
            print('\nPrivatekey (dec): ', dec,'\nPrivatekey (hex): ', HEX, '\nPrivatekey UnCompressed: ', wifu, '\nPublic Address UnCompressed: ', uaddr)
            f=open("winner.txt","a")
            f.write('\nPrivatekey (dec): ' + str(dec))
            f.write('\nPrivatekey (hex): ' + HEX)
            f.write('\nPrivatekey UnCompressed: ' + wifu)
            f.write('\nPublic Address UnCompressed: ' + uaddr)
        if caddr in fill or caddr in bloom_filter:
            wifc = secp256k1.btc_pvk_to_wif(HEX)
            print('\nMatch Found Compressed')
            print('\nPrivatekey (dec): ', dec,'\nPrivatekey (hex): ', HEX, '\nPrivatekey compressed: ', wifc, '\nPublic Address Compressed: ', caddr)
            f=open("winner.txt","a")
            f.write('\nPrivatekey (dec): ' + str(dec))
            f.write('\nPrivatekey (hex): ' + HEX)
            f.write('\nPrivatekey compressed: ' + wifc)
            f.write('\nPublic Address Compressed: ' + caddr)


        
def sequential_scan():
    z=int(input("'start range Min 1-115792089237316195423570985008687907852837564279074904382605163141518161494335 -> "))
    y=int(input("stop range Max 115792089237316195423570985008687907852837564279074904382605163141518161494336 -> "))

    P = z
    while P<y:
        P+=1
        dec = P
        uaddr = secp256k1.privatekey_to_address(0, False, dec)
        caddr = secp256k1.privatekey_to_address(0, True, dec)
        HEX = "%064x" % dec
        sql = "INSERT INTO `addresses`( `seed`, `compressed`, `uncompressed`, `privatekey`) VALUES (%s, %s, %s, %s)"
        val = (dec, caddr, uaddr, HEX)
        mycursor.execute(sql,val)
        mydb.commit()
        print(dec, caddr, "record inserted.")
        if uaddr in fill or uaddr in bloom_filter:
            wifu = secp256k1.btc_pvk_to_wif(HEX, False)
            print('\nMatch Found UnCompressed')
            print('\nPrivatekey (dec): ', dec,'\nPrivatekey (hex): ', HEX, '\nPrivatekey UnCompressed: ', wifu, '\nPublic Address UnCompressed: ', uaddr)
            f=open("winner.txt","a")
            f.write('\nPrivatekey (dec): ' + str(dec))
            f.write('\nPrivatekey (hex): ' + HEX)
            f.write('\nPrivatekey UnCompressed: ' + wifu)
            f.write('\nPublic Address UnCompressed: ' + uaddr)
        if caddr in fill or caddr in bloom_filter:
            wifc = secp256k1.btc_pvk_to_wif(HEX)
            print('\nMatch Found Compressed')
            print('\nPrivatekey (dec): ', dec,'\nPrivatekey (hex): ', HEX, '\nPrivatekey compressed: ', wifc, '\nPublic Address Compressed: ', caddr)
            f=open("winner.txt","a")
            f.write('\nPrivatekey (dec): ' + str(dec))
            f.write('\nPrivatekey (hex): ' + HEX)
            f.write('\nPrivatekey compressed: ' + wifc)
            f.write('\nPublic Address Compressed: ' + caddr)


print ("[green]\n 1 for Random Scan [/green]\n [blue]2 for Sequential Scan [/blue]")
method_input = input("\n : Type 1-2 to begin :")
if method_input=="1":
    random_scan()
elif method_input=="2":
    sequential_scan()