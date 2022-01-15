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
    
    #id = cardinfo[45:54]
    id = cardinfo

    #print(id)

    #Check arrays for ID number
    for row in rows:
        if(row[0]==id):
            logfile = row[4]
            print("Hello "+row[1])
            #Mbox("Greetings", "Hello "+row[1],1)
    
    #Access date and Time
    now = datetime.now()
    date = now.strftime("%m/%d/%Y")
    print(date)
    time = now.strftime("%H:%M:%S")
    
    #format time
    meridiem = " A.M."
    hour = int(time[0:2])
    if hour > 12:
        hour -= 12
        meridiem = " P.M."
    hour = str(hour)
    minute = date[3:5]
    time = str(hour + ":" + minute + meridiem)
    print(time)
    
    #TEMPORARY
    #logfile = studentinfo[4]
    companion = input("Who is your companion?")
    destination = input("What is your destination?")
    eta = input("When do you expect to get back?")

    studentlog = open(logfile,"a",newline = '')
    rowwriter = csv.writer(studentlog,dialect='excel',)
    rowwriter.writerow([date,destination,companion,time,eta,'Not Yet Returned'])
    studentlog.close()
    
    leave = input("press 1 to quit")
    if (leave == "1"):
        quit()
    else:
        read()

read()

file.close()
