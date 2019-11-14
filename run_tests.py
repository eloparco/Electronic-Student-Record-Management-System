import os

with open('config/database/database.ini', 'w') as f:
	f.write('host = localhost\n'
		'name = student_record_management_test\n'
		'user = root\n'
		'pass = ')

cmd = 'php vendor/bin/codecept run'
os.system(cmd)

with open('config/database/database.ini', 'w') as f:
	f.write('host = localhost\n'
		'name = student_record_management\n'
		'user = root\n'
		'pass = ')
