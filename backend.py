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
            #MACs VLAN oid?
