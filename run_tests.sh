# use test database
cat << 'EOF' > config/database/database.ini
host = localhost
name = student_record_management_test
user = root
pass = 
EOF

# start apache and mysql
service apache2 status &> /dev/null || sudo service apache2 start
service mysql status &> /dev/null || sudo service mysql start

# run tests
java -jar -Dwebdriver.chrome.driver=./chromedriver selenium-server-standalone-3.141.59.jar &
php vendor/bin/codecept run $1 $2 $3
kill $!

# use production database
cat << 'EOF' > config/database/database.ini
host = localhost
name = student_record_management
user = root
pass = 
EOF

