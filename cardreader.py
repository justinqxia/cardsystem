import csv
import ctypes
#from tkinter import *
#import tkinter.messagebox
from datetime import datetime

def Mbox(title, text, style):
    return ctypes.windll.user32.MessageBoxW(0, text, title, style)

#Upload csv file to arrays
file = open("cards.csv")
csvreader = csv.reader(file)
header = next(csvreader)
rows = []
for row in csvreader:
    rows.append(row)

def read():    
    #Read card for ID number
    cardinfo = input("Please swipe your card")
    id = cardinfo[45:54]
    #print(id)

    #Check arrays for ID number
    for row in rows:
        if(row[0]==id):
            print("Hello "+row[1])
            #Mbox("Greetings", "Hello "+row[1],1)
    
    #Access date and Time
    now = datetime.now()
    date = now.strftime("%m/%d/%Y")
    print(date)
    time = now.strftime("%H:%M:%S")
    print(time)	
    
    leave = input("press 1 to quit")
    if (leave == "1"):
        quit()
    else:
        read()

read()



#print(rows)


file.close()

studentlog = open('henrycooperstudentlog.csv',"w")
rowwriter = csv.writer(studentlog,dialect='excel',)
rowwriter.