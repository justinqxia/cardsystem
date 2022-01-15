import csv
import tkinter as tk
from datetime import datetime


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
    if(cardinfo=="1"):
        print("exiting")
        return
    studentid = cardinfo[45:54]
    #print(id)

    #reset variable found
    error=True

    #Check arrays for ID number
    for row in rows:
        if(row[0]==studentid):
            error=False
            print("Hello "+row[1])
            if(len(row[4])==0):
                signout(row)
            else:
                signin(row)        

            
    with open("cards.csv", 'w', newline='') as csvfile:
        csvwriter = csv.writer(csvfile)
        # writing the fields 
        csvwriter.writerow(header) 
            
        # writing the data rows 
        csvwriter.writerows(rows)
    
    #Check for error with swiping card
    if(error==True):
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
#end def run

#for signing out of the building
def signout(row):
    #Access date and Time
    now = datetime.now()
    date = now.strftime("%m/%d/%Y")
    #print(date)
    time = now.strftime("%H:%M:%S")
    #print(time)
    row[4]=date
    row[5]=time
    return row

#for signing into the building
def signin(row):
    now = datetime.now()
    returntime = now.strftime("%H:%M:%S")
    row[6]=returntime
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
    row[4]=''
    row[5]=''
    row[6]=''  
    return row  

#Run first instance of the program
read()



#print(rows)


file.close()
