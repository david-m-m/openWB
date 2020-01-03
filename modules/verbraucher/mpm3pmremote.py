#!/usr/bin/python
import sys
import os
import time
import getopt
import socket
import ConfigParser
import struct
import binascii
verbrauchernr = str(sys.argv[1])
seradd = str(sys.argv[2])
from pymodbus.client.sync import ModbusTcpClient
client = ModbusTcpClient(seradd, port=8899)


sdmid = int(sys.argv[3])

resp = client.read_input_registers(0x0002,4, unit=sdmid)
value1 = resp.registers[0] 
value2 = resp.registers[1] 
all = format(value1, '04x') + format(value2, '04x')
ikwh = int(struct.unpack('>i', all.decode('hex'))[0]) 
ikwh = float(ikwh) * 10
whstring = "/var/www/html/openWB/ramdisk/verbraucher%s_wh" % (verbrauchernr)
f = open(whstring, 'w')
f.write(str(ikwh))
f.close()

resp = client.read_input_registers(0x0004,4, unit=sdmid)
value1 = resp.registers[0] 
value2 = resp.registers[1] 
all = format(value1, '04x') + format(value2, '04x')
ekwh = int(struct.unpack('>i', all.decode('hex'))[0]) 
ekwh = float(ekwh) * 10
whestring = "/var/www/html/openWB/ramdisk/verbraucher%s_whe" % (verbrauchernr)
f = open(whestring, 'w')
f.write(str(ekwh))
f.close()

resp = client.read_input_registers(0x26,2, unit=sdmid)
value1 = resp.registers[0] 
value2 = resp.registers[1] 
all = format(value1, '04x') + format(value2, '04x')
final = int(struct.unpack('>i', all.decode('hex'))[0]) / 100
wstring = "/var/www/html/openWB/ramdisk/verbraucher%s_watt" % (verbrauchernr)
f = open(wstring, 'w')
f.write(str(final))
f.close()


resp = client.read_input_registers(0x0E,2, unit=sdmid)
lla1 = resp.registers[1]
lla1 = float(lla1) / 100
lla1string = "/var/www/html/openWB/ramdisk/verbraucher%s_a1" % (verbrauchernr)
f = open(lla1string, 'w')
f.write(str(lla1))
f.close()
resp = client.read_input_registers(0x10,2, unit=sdmid)
lla2 = resp.registers[1]
lla2 = float(lla2) / 100
lla2string = "/var/www/html/openWB/ramdisk/verbraucher%s_a2" % (verbrauchernr)
f = open(lla2string, 'w')
f.write(str(lla2))
f.close()
resp = client.read_input_registers(0x12,2, unit=sdmid)
lla3 = resp.registers[1]
lla3 = float(lla3) / 100
lla3string = "/var/www/html/openWB/ramdisk/verbraucher%s_a3" % (verbrauchernr)
f = open(lla3string, 'w')
f.write(str(lla3))
f.close()


