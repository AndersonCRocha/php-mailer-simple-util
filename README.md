# Simple utility for sending emails with PHPMailer

## How to use:

- Install [PHPMailer](https://github.com/PHPMailer/PHPMailer)
- Change SMTP server settings in EmailFactory.php \_\_construct()
  ```
  $this->mail->Host = 'smtp.gmail.com';
  $this->mail->Username = 'meuemail@gmail.com';
  $this->mail->Password = 'minhasenha123';
  $this->mail->setFrom('meuemail@gmail.com', 'Meu Nome');
  ```
- Change mail info in mail-test.php
- Run server: `php -S host:port`
- Open: `host:port/mail-test.php`
