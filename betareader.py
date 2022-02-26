import csv
import tkinter as tk
from datetime import datetime
from playsound import playsound
import mysql.connector

#Upload csv file to arrays
file = open("cards.csv")
csvreader = csv.reader(file)

header = next(csvreader)
rows = []
for row in csvreader:
    rows.append(row)

#initialize list of possible shortcuts
shortcuts=["1","2","3","4","5","6","7","0"]

def readSwipe():    
    #Read card for ID number
    cardinfo = input("Please swipe your card")
    if(cardinfo=="1"):
        print("exiting")
        return
    studentid = cardinfo[45:54]
    #print(id)

    #use shortcut function
    if(cardinfo in shortcuts):
        shortcut(cardinfo)

    #Check arrays for ID number
    for row in rows:
        if(row[0]==studentid):
            if(len(row[7])==0):
                fetchdata(row)
                signout(row)
                movetoslots(row)
                getstatus(row)
                if(row[5]=="White"):
                    print(row[8]+" "+row[1]+" "+row[2]+" signed in (NECP)")
                else:
                    print(row[8]+" "+row[1]+" "+row[2]+" signed out")
                print("")
            else:
                signin(row)                
                clearcard(row)
                clearslots(row)
                if(row[5]=="White"):
                    print(row[10]+" "+row[1]+" "+row[2]+" signed out (NECP)")
                else:
                    print(row[10]+" "+row[1]+" "+row[2]+" signed in")
                print("")
        
    with open("cards.csv", 'w', newline='') as csvfile:
        csvwriter = csv.writer(csvfile)
        # writing the fields 
        csvwriter.writerow(header) 
            
        # writing the data rows 
        csvwriter.writerows(rows)
    
    #Check for error with swiping card
    if((len(cardinfo)!=60)and(len(cardinfo)!=1)):
        playsound('error.wav')
        window = tk.Tk()
        label = tk.Label(
            text="Error\nPlease swipe again",
            font=("Arial", 50),
            fg="red",
            bg="white",
            width=25,
            height=10
        )
        label.pack()
        #Make the window jump above all
        window.attributes('-topmost',True)
        window.mainloop()
    readSwipe()
#end def read

#for signing out of the building
def signout(row):
    #Access date and Time
    now = datetime.now()
    date = now.strftime("%m/%d/%Y")
    #print(date)
    time = now.strftime("%H:%M:%S")
    #print(time)
    row[7]=date
    row[8]=time
    return row

#for signing into the building
def signin(row):
    now = datetime.now()
    returntime = now.strftime("%H:%M:%S")
    row[10]=returntime
    studentinfo = row[2] + row[1] + ".csv"
    sfile = open(studentinfo)
    csvreader2 = csv.reader(sfile)

    logheader = next(csvreader2)
    studentrows = []
    for srow in csvreader2:
        studentrows.append(srow)

    with open(studentinfo, 'w', newline='') as csvfile:
        csvwriter=csv.writer(csvfile)
        csvwriter.writerow(logheader) 
        csvwriter.writerow(row)
        for srow in studentrows:
            csvwriter.writerow(srow)
    for i in range(6,13):
      row[i]=''
    return row  

#shortcut function
def shortcut(cardinfo):
    #list of people signed out
    if(cardinfo=="2"):
        print("Signed out right now:")
        for row in rows:
            listout(row) 
        print("") 
    #performing card check
    if(cardinfo=="3"):
        print("Signed out before 6:30:")
        for row in rows:
            cardcheck(row)
        print("")
    #check curfew
    if(cardinfo=="4"):
        cardcolor=input("Which card color would you like to check?")
        cardcolor=cardcolor.capitalize()
        print(cardcolor+" cards signed out right now:")
        for row in rows:
            curfew(row,cardcolor)
        print("")
    #edit a card
    if(cardinfo=="5"):
        searchname=input("What is the email of the student you are searching for? Do not add '@bsu.edu")
        searchname = searchname+"@bsu.edu"
        for row in rows:
            if(row[3]==searchname):
                if(len(row[7])!=0):
                    changecard(row)
                    print("Card has been changed")
                    print("")
                else:
                    print("Error: Student has not signed out")
                    print("")
    #clear a card
    if(cardinfo=="6"):
        searchname=input("What is the email of the student you are searching for? Do not add '@bsu.edu")
        searchname = searchname+"@bsu.edu"
        for row in rows:
            if(row[3]==searchname):
                clearcard(row)
                clearslots(row)
                for i in range(6,13):
                    row[i]=''
                print("Card has been cleared")
                print("")
    #clear a card
    if(cardinfo=="7"):
        safeguard=input("ARE YOU SURE??? type 'yes' to confirm")
        if(safeguard=="yes"):
            for row in rows:
                for i in range(6,13):
                    row[i]=''
                clearslots(row)
            with open("cards.csv", 'w', newline='') as csvfile:
                csvwriter = csv.writer(csvfile)
                # writing the fields 
                csvwriter.writerow(header) 
                # writing the data rows 
                csvwriter.writerows(rows)
            print("All cards have been cleared")
            print("")
        else:
            print("Cancelling clear")
            print("")

    #pull up list of shortcuts
    if(cardinfo=="0"):
        print("List of shortcuts:")
        print("1 - exit program")
        print("2 - list of everyone signed out right now")
        print("3 - list of everyone signed out before 6:30")
        print("4 - list of people signed out with a particular card color")
        print("5 - Edit someone's card")
        print("6 - Clear someone's card")
        print("7 - Clear ALL cards")

#list of people signed out
def listout(row):
    if(len(row[7])!=0):
        print(row[1]+" "+row[2])

#cardcheck function
def cardcheck(row):
    if((row[8]<'18:30:00')and(len(row[8])!=0)):
        print(row[1]+" "+row[2])

#curfew function
def curfew(row,cardcolor):
    if((len(row[7])!=0)and(row[5]==cardcolor)):
        print(row[1]+" "+row[2])

#fetch data from database
def fetchdata(row):
  con = mysql.connector.connect(
    host="localhost", 
    user="root",
    password="", 
    database="phplogin"
    )
  cursor = con.cursor()

  query = "select * from cards"
  cursor.execute(query)

  forms = cursor.fetchall()
    
  line=[] 
  stnum=int(row[0])
  # fetch all columns
  for block in forms:
    for x in block:
      line.append(x)
    if(line[0]=="Other"):
      line.pop(0)
    else:
      line.pop(1)
    if(stnum == line[4]):
      row[6]=line[0]
      row[11]=line[1]
      row[9]=line[2]
      row[12]=line[3]
    line=[]

#Clears line in cards database
def clearcard(row):
    mydb = mysql.connector.connect(
    host="localhost", 
    user="root",
    password="", 
    database="phplogin"
    )

    mycursor = mydb.cursor()

    line=[]
    line.append(row[0])

    sql = "DELETE FROM cards WHERE id = %s"
    adr = (line)

    mycursor.execute(sql, adr)

    mydb.commit()

#Clears line in slots database
def clearslots(row):
    mydb = mysql.connector.connect(
    host="localhost", 
    user="root",
    password="", 
    database="phplogin"
    )

    mycursor = mydb.cursor()

    line=[]
    line.append(row[0])

    sql = "DELETE FROM slots WHERE id = %s"
    adr = (line)

    mycursor.execute(sql, adr)

    mydb.commit()

#Writes information into slots database
def movetoslots(row):
    mydb = mysql.connector.connect(
    host="localhost", 
    user="root",
    password="", 
    database="phplogin"
    )

    mycursor = mydb.cursor()

    sql = "INSERT INTO slots (destination, companion, return1, sp, id, email, firstname, lastname, floor, signout) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"
    val = (row[6],row[11],row[9],row[12],row[0],row[3],row[1],row[2],row[4],row[8])
    mycursor.execute(sql, val)

    mydb.commit()

#gets status from comments and writes it to slots
def getstatus(row):
  con = mysql.connector.connect(
    host="localhost", 
    user="root",
    password="", 
    database="phplogin"
    )
  cursor = con.cursor()

  query = "select * from comments"
  cursor.execute(query)

  forms = cursor.fetchall()
    
  line=[] 
  stnum=int(row[0])
  # fetch all columns
  for block in forms:
    for x in block:
      line.append(x)
    if(line[0]=="Other"):
      line.pop(0)
    else:
      line.pop(1)
    if(stnum == line[0]):
      status=line[1]

    line=[]
    mycursor = con.cursor()

    sql = "INSERT INTO slots (status) VALUES (%s)"
    val = (status)
    mycursor.execute(sql, val)

    con.commit()

#Changes value on someon'es card
def changecard(row):
    schangeindex="0"
    validchange = ["6","9","11","12"]
    while(schangeindex not in validchange):
        schangeindex=input("What index would you like to change? 6-Destination, 9-Expected Return Time, 11-Companion, 12-SP")
    changevalue=input("What would you like to change this value to? For time, enter in 'XX:XX:XX' format")
    ichangeindex=int(schangeindex)
    row[ichangeindex]=changevalue
    clearslots(row)
    clearcard(row)
    movetoslots(row)

    #writes change to cards database
    mydb = mysql.connector.connect(
    host="localhost", 
    user="root",
    password="", 
    database="phplogin"
    )

    mycursor = mydb.cursor()

    sql = "INSERT INTO cards (destination, companion, return1, sp, id, email, firstname, lastname, floor, signout) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"
    val = (row[6],row[11],row[9],row[12],row[0],row[3],row[1],row[2],row[4],row[8])
    mycursor.execute(sql, val)

    mydb.commit()

    return row

#Run first instance of the program
readSwipe()

file.close()