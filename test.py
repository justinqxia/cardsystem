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

shortcuts=["1","2","3","4","0"]

def read():    
    #Read card for ID number
    cardinfo = input("Please swipe your card")
    if(cardinfo=="1"):
        print("exiting")
        return
    studentid = cardinfo[45:54]
    #print(id)

    #reset variable found
    error=True

    #use shortcut function
    if(cardinfo in shortcuts):
        error=False
        shortcut(cardinfo)

    #Check arrays for ID number
    for row in rows:
        if(row[0]==studentid):
            error=False
            if(len(row[6])==0):
                fetchdata(row)
                signout(row)
                print(row[1]+" "+row[2]+" signed out")
                print("")
            else:
                signin(row)
                print(row[1]+" "+row[2]+" signed in")
                print("")
      
    with open("cards.csv", 'w', newline='') as csvfile:
        csvwriter = csv.writer(csvfile)
        # writing the fields 
        csvwriter.writerow(header) 
            
        # writing the data rows 
        csvwriter.writerows(rows)
    
    #Check for error with swiping card
    if(error==True):
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
    read()
#end def read

#for signing out of the building
def signout(row):
    #Access date and Time
    now = datetime.now()
    date = now.strftime("%m/%d/%Y")
    #print(date)
    time = now.strftime("%H:%M:%S")
    #print(time)
    row[6]=date
    row[7]=time
    return row

#for signing into the building
def signin(row):
    now = datetime.now()
    returntime = now.strftime("%H:%M:%S")
    row[9]=returntime
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
    for i in range(5,12):
      row[i]=''
    return row  

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
    #pull up list of shortcuts
    if(cardinfo=="0"):
        print("List of shortcuts:")
        print("1 - exit program")
        print("2 - list of everyone signed out right now")
        print("3 - list of everyone signed out before 6:30")
        print("4 - list of people signed out with a particular card color")
        print("")

#list of people signed out
def listout(row):
    if(len(row[6])!=0):
        print(row[1]+" "+row[2])

#cardcheck function
def cardcheck(row):
    if((row[7]<'18:30:00')and(len(row[7])!=0)):
        print(row[1]+" "+row[2])

#curfew function
def curfew(row,cardcolor):
    if((len(row[6])!=0)and(row[4]==cardcolor)):
        print(row[1]+" "+row[2])

#fetch data from database
def fetchdata(row):
  con = mysql.connector.connect(
    host="localhost", user="root",
    password="", database="phplogin")
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
      row[5]=line[0]
      row[10]=line[1]
      row[8]=line[2]
      row[11]=line[3]
    line=[]

  #mycursor = con.cursor()

  #sql = "DELETE FROM cards WHERE id = %s"
  #adr = (row[0])

  #mycursor.execute(sql, adr)

  con.commit()
  return row

#Run first instance of the program
read()

file.close()