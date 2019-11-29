# track-a-MAC
The aim with this project is to create a solution that allows us to track where MAC numbers connect to our network. This will be done by probing the network switches periodically, and retrieving their ForwardingTables (or equivalent). Using the collected information, we want to have a solution that we can search (WEB/RESTapi) for a specific MAC address (including wildcards). If a match is found, the response should return what switches, vlans and ports are aware of the MAC address, and if possible identify what port is the connection port. 


Extended descrirption: This projects role is to create a solution which can probe the networking devices and get the information regarding it.
Our project consists of the following files
1.config.php - used to create a database once for all so that other files can include it, reduces code for other files.
2.addDevice.php - is used to add device info of the format 'IP Port Community Version'
3.removeDevices.php - is used to remove devices from the database table created in addDevices.php
4.backend - It is written in backend. It's role is to probe the networking devices using snmp communication protocol.
It takes help of oid values to find the port, interface, mac numbers etc of the probed device.
The devices are probed every 60 secs with a retry of 2 and timeout of 5 secs.
Once the devices are probed the info is stored in the database where further it is accessed by ListDevices.php and List.php.
Here we implement the backend in python.
5.ListDevices.php - List the entire info of the added devices.
6.List.php - Displays the info of the connected mac's, ports etc of the devices that are currently being probed.
Execution:
$cd <Directory_where_the_project_is_stored>
#open a new terminal and run php server
$php -S localhost:5000
$php config.php
$curl 'http://localhost:5000/addDevices.php?IP=,Port=,Community=,Version='
#follow the above command for other .php files just replace the filename and input format
#below is the command for running the backend
$python backend.py

this project lets me my inner devil come out
