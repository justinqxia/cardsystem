# import required modules
import mysql.connector
  
# create connection object
con = mysql.connector.connect(
  host="147.226.187.252", user="justin",
  password="xia", database="phplogin")
  
# create cursor object
cursor = con.cursor()

# assign data query
query = "select * from cards"
  
# executing cursor
cursor.execute(query)
  
# display all records
forms = cursor.fetchall()
  
line=[]  
rows=[]

# fetch all columns
for row in forms:
  for x in row:
    line.append(x)
  if(line[0]=="Other"):
    line.pop(0)
  else:
    line.pop(1) 
  rows.append(line)
  print(line[4])
  line=[]
    
print(rows)


#sql = "UPDATE customers SET address = %s WHERE address = %s"
#val = ("Valley 345", "Canyon 123")

#cursor.execute(sql, val)

#con.commit()

#print(cursor.rowcount, "record(s) affected")
      
# closing cursor connection
cursor.close()
  
# closing connection object
con.close()