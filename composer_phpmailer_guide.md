# Installing composer and php mailer

## Steps
1. Download composer from https://getcomposer.org/download/`
2. Install composer, default options
2. Git clone https://github.com/PHPMailer/PHPMailer.git in the git project (Electronic-Student-Record-Management-System) directory
3. run cmd in the same directory
4. run : `composer require phpmailer/phpmailer`
5. delete PHPMailer folder

## Test
1. Insert a destination mail in send_mail.php
2. load on a browser send_mail.php , You should receive an email.