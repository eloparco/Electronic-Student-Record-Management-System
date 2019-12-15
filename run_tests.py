import os
import subprocess
import sys
import time

with open('config/database/database.ini', 'w') as f:
	f.write('host = localhost\n'
		'name = student_record_management_test\n'
		'user = root\n'
		'pass = ')
os.environ["PATH"] += ";C:\\xampp\\mysql\\bin"
cmd = ['vendor\\bin\\codecept.bat', 'run']
for i in range(1, len(sys.argv)):
	cmd.append(sys.argv[i])
bg_proc = "java -jar -Dwebdriver.chrome.driver=.\chromedriver.exe selenium-server-standalone-3.141.59.jar"
bg_service = subprocess.Popen(bg_proc, creationflags=subprocess.DETACHED_PROCESS)
time.sleep(2) # be sure selenium is running
subprocess.call(cmd, env=os.environ)
bg_service.kill()

with open('config/database/database.ini', 'w') as f:
	f.write('host = localhost\n'
		'name = student_record_management\n'
		'user = root\n'
		'pass = ')
