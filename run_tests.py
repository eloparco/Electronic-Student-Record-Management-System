import os
import subprocess
import sys

with open('config/database/database.ini', 'w') as f:
	f.write('host = localhost\n'
		'name = student_record_management_test\n'
		'user = root\n'
		'pass = ')
os.environ["PATH"] += ";C:\\xampp\\mysql\\bin"
cmd = 'vendor\\bin\\codecept.bat run ' + sys.argv[1] + ' ' + sys.argv[2]
subprocess.check_call(cmd)

with open('config/database/database.ini', 'w') as f:
	f.write('host = localhost\n'
		'name = student_record_management\n'
		'user = root\n'
		'pass = ')
