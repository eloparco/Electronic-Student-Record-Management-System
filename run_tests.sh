# use test database
cat << 'EOF' > config/database/database.ini
host = localhost
name = student_record_management_test
user = root
pass = 
EOF

php vendor/bin/codecept run

# use production database
cat << 'EOF' > config/database/database.ini
host = localhost
name = student_record_management
user = root
pass = 
EOF

