import serial, time
 
# open serial port
ser = serial.Serial('/dev/usb/acm/0',9600,timeout=0)
serialCheckInterval = 1.0 #Check serial port for data every x seconds
time.sleep(1)
ser.write('z')

import os, sys, socket, tweepy, datetime, hashlib, urllib, httplib

# twitter key and token for oauth
consumer_key=""
consumer_secret=""
access_token=""
access_token_secret=""

auth = tweepy.OAuthHandler(consumer_key, consumer_secret)
auth.set_access_token(access_token, access_token_secret)

twitterapi = tweepy.API(auth)

#create a listening socket to communicate with PHP
#if os.path.exists('/tmp/fthrsckt'):
#os.remove('/tmp/fthrsckt') #if socket already exists, remove it
s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
s.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1) #if socket already exists, reuse it
s.bind(('', 81))
#s.bind("/tmp/fthrsckt") #Bind /mnt/BEERSOCKET
s.setblocking(1) # set socket functions to be blocking
s.listen(5) # Create a backlog queue for up to 5 connections.
s.settimeout(serialCheckInterval) # blocking socket functions wait 'serialCheckInterval' seconds.

prevTimeOut=time.time()
prevScanTime=time.time()-10.0
roundActive = 0

run = 1

while(run):
  try: # wait for incoming socket connections.
    conn, addr = s.accept()
    data = conn.recv(1024)  #blocking receive, times out in 5 minutes
    if(len(data)<=1): #invalid data, too short
      if((time.time() - prevTimeOut) < serialCheckInterval):
        continue
    elif(data[0]=='q'):      #exit instruction received. Stop script.
      run=0
      if((time.time() - prevTimeOut) < serialCheckInterval):
        continue
    elif(data[0]=='a'):      #acknowledge request
      ser.write('ack')
      time.sleep(1)
      ack = ser.readline()
      ack = ack.strip();
      conn.send(ack)
      if((time.time() - prevTimeOut) < serialCheckInterval):
        continue
    elif(data[0]=='f'):      #send top forward
      ser.write('f')
    elif(data[0]=='r'):      #send toy right
      ser.write('r')
    elif(data[0]=='b'):      #send toy backward
      ser.write('b')
    elif(data[0]=='l'):      #send toy left
      ser.write('l')
    elif(data[0]=='s'):      #stop toy
      ser.write('s')
    elif(data[0]=='x'):      #bell sound effect
      ser.write('x')
    else:
      print >> sys.stderr, "Error: Received invalid packet on socket: " + data
 
    raise socket.timeout #raise exception to check serial for data immediately
 
  except socket.timeout: #Do serial communication and update settings every SerialCheckInterval
    prevTimeOut=time.time()
 
    while(1): #read all lines on serial interface
      line = ser.readline()
      line = line.strip()
      break
      
    rfid = line
    
    if(rfid!=''):
      if((time.time() - prevScanTime) > 10.0):

        os.chdir('/mnt/fthrwghts')
        urllib.urlretrieve('http://dome.fthrwghts.com/snapshot.jpg', 'snapshot.jpg')
        
        timestamp = str(time.mktime(datetime.datetime.now().timetuple()))[0:10]
        print timestamp
        if(rfid == '5680442'):
          cat = 'Suki'
        elif(rfid == '13557281'):
          cat = 'Verb'
        else:
          cat = 'Demo'    
        seed = '';
        hash = hashlib.md5(timestamp + cat + seed).hexdigest()[0:8]        
        
        params = urllib.urlencode({'timestamp': timestamp, 'cat': cat})
        result = urllib.urlopen("http://fthrwghts.com/static/sql.php", params)
        print result
        
        if(roundActive == 0):
          status = cat + ' wants to play! http://fthrwghts.com/static/sql?hash=' + hash + ' \n Featherweights demo at IUPUI SoI #MASCapstone Event'      
          try:
            twitterapi.status_update_with_media('snapshot.jpg', status=status)
          except tweepy.TweepError, e:
            twitterapi.update_status(status=status)
          print 'Tweeted: ' + status
          roundActive = 1
        else:
          roundActive = 0
        prevScanTime=time.time()
 
  except socket.error, e:
    print >>sys.stderr, "socket error: %s" % e
 
ser.close()            # close  port
conn.shutdown(socket.SHUT_RDWR) # close socket
conn.close()