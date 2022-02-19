def hello(n):
    if(n>1):
        print("hello")
        hello(n/2)
        hello(n/2)

hello(16)