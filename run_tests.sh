# use test database
cat << 'EOF' > config/database/database.ini
host = localhost
name = student_record_management_test
user = root
pass = 
EOF

java -jar -Dwebdriver.chrome.driver=./chromedriver selenium-server-standalone-3.141.59.jar &
php vendor/bin/codecept run 

# use production database
cat << 'EOF' > config/database/database.ini
host = localhost
name = student_record_management
user = root
pass = 
EOF

