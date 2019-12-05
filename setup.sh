#!/bin/bash
git clone https://github.com/enricol96/Electronic-Student-Record-Management-System && mv Electronic-Student-Record-Management-System /var/www/html/
service apache2 start
service mysql start
mysql -u root < /var/www/html/Electronic-Student-Record-Management-System/config/database/student_record_management.sql
mysql -u root < /var/www/html/Electronic-Student-Record-Management-System/config/database/esrms_population.sql
tail -f /dev/null
