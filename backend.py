#!/usr/bin/python
import easysnmp
import time, datetime
import threading
import sqlite3
import exceptions
import sys
from easysnmp import *


class my_threads(threading.Thread) :
    def __init__(self, ip, community, version, port):#apply OOPs concept , if fails start with function calls
        threading.Thread.__init__(self)
        self.ip = ip
        self.community = community
        self.version = version
        self.port = port
        
    def run(self):
        while True:#while-count to count number of failed attmepts
            my_failed_attempts = 0
            try:
                session = Session(hostname=self.ip, community = self.community, version = self.version, timeout =5, retries=2)
            except easysnmp.exceptions.EasySNMPTimeoutError:
                my_failed_attempts += my_failed_attempts

            
            T = int(time.time())
            probe = datetime.datetime.utcfromtimestamp(T)
            next_probe = probe + datetime.timedelta(seconds=60)
            connector= sqlite3.Connection('mydatabase.db', timeout=7)
            selector= connector.cursor()
            selector.execute('''UPDATE status SET IP = ?,PORT=?,COMMUNITY=?,VERSION=?,FIRST_PROBE=?,LATEST_PROBE=?,Failed_attempts=? WHERE IP =?''',self.ip,self.port,self.community,self.version,probe,next_probe,failed_attempts,self.ip)
            print('connected to device having ip address',self.ip,'at',probe)
            connector.commit()

            all = session.walk('1.3.6.1.2.1.17.4')#this command is used to perform an snmp walk to retrive address port an status of the networking device
            ports = session.walk('IF-MIB::ifName')#where ifname is the oid value 1.3.6.1.2.1.31.1.1.1.1 which give us object type i.e. name of the interface to which the device is connected to
            mac=[]
            index_of_oid=[]

            for i in range(len(all)):
                oid = all[i].oid
                oid_type = all[i].snmp_type
                capacity = len(oid.split('.'))
                if (capacity >= 12 and oid_type == 'OCTETSTR'):
                    mac.append(all[i].value)
                if(oid_type == 'INTEGER' and "mib-2.17.4.3.1.2" in oid):
                    index_of_oid.append(all[i].value)
            
            j = 0
            for j in range(len(index_of_oid)):
                if (index_of_oid[j] == u'0'):
                    index_of_oid[j] = str(1).decode('UTF-8')
            mac = [(':'.join('%02x' % ord(k) for k in macs)) for macs in mac]
            dict = {}#assign a dictionary
            for l in range(len(mac)):
                dict[mac[l]] = index_of_oid[l]
            
            dict1 = {'index':'port'}#key value pairs which we want to assign
            for port in ports:
                dict1[port.index_of_oid] = port.value
            
            my_port_name = []
            for index in index_of_oid:
                if index in dict1.keys():
                    my_port_name.append(dict1[index])
            
            m = 0
            for n in my_port_name:
                print "mac address:",mac[m], "vlan:", index_of_oid[m], "port", n, "\n"
                connector.execute("INSERT INTO List VALUES(NULL,?,?,?,?)",(self.ip, index_of_oid[m], n, mac[m]));
                m += 1
            connector.commit()
            time.sleep(60)
probing = sqlite3.connect('mydatabase.db', timeout=10)

o = probing.cursor()
o.execute("CREATE TABLE IF NOT EXISTS List (ID INTEGER PRIMARY KEY AUTOINCREMENT, IP varchar(30), VLAN varchar(30), PORT varchar(30), MACS varchar(100))")
probing.commit()

capacity = o.execute("SELECT COUNT(*) FROM info")
p = capacity.fetchall()
q = str((0,))
r = o.execute("SELECT name FROM sqlite_master WHERE type='table' AND name = 'info'")
s = len(r.fetchall())

if str(p != q) or (s) != 0:
    o.execute("SELECT * FROM info")
    u = o.fetchall()
    threads = []
    for v in u:
        ip = v[0]
        community = v[1]
	port = v[2]
	version = int(v[3])
	
        thread = switch_threads(ip, community, port, version)
        thread.start()
        threads.append(thread)
    for w in threads:
        w.join


