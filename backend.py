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
