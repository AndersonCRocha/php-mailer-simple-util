<?php

namespace EmailUtils;

require('PHPMailer/src/PHPMailer.php');
require('PHPMailer/src/SMTP.php');
require('PHPMailer/src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailFactory
{
  private $mail;
  private $addressesTo;
  private $errors;

  private function __construct()
  {
    $this->mail = new PHPMailer();
    $this->addressesTo = [];
    $this->errors = [];

    $this->mail->CharSet = 'UTF-8';

    $this->mail->isSMTP();
    $this->mail->SMTPAuth = true;
    $this->mail->SMTPSecure = 'tls';
    
    $this->mail->Port = 587;
    $this->mail->Host = 'smtp.gmail.com';
    $this->mail->Username = 'meuemail@gmail.com';
    $this->mail->Password = 'minhasenha123';
    
    $this->mail->setFrom('meuemail@gmail.com', 'Meu Nome');
  }

  public static function new(): self
  {
    return new static();
  }

  public function to($address, $name): self 
  {
    $this->addressesTo[] = [
      'address' => $address,  
      'name' => $name
    ];

    return $this;
  }

  public function subject($subject): self
  {
    $this->mail->Subject = $subject;

    return $this;
  }

  public function content($content, $isHtml = false): self
  {
    $this->mail->isHTML($isHtml);
    $this->mail->Body = $content;

    return $this;
  }

  public function replyTo($address, $name): self 
  {
    $this->mail->addReplyTo($address, $name);

    return $this;
  }

  public function cc($address, $name): self 
  {
    $this->mail->addCC($address, $name);

    return $this;
  }

  public function bcc($address, $name): self 
  {
    $this->mail->addBCC($address, $name);

    return $this;
  }

  public function embeddedImage($path, $cid): self
  {
    $this->mail->addEmbeddedImage($path, $cid);

    return $this;
  }

  public function attachment($path, $filename): self
  {
    $this->mail->addAttachment($path, $filename);

    return $this;
  }

  public function stringAttachment($file, $filename): self
  {
    $this->mail->addStringAttachment($file, $filename);

    return $this;
  }

  public function send()
  {
    if (
      empty($this->mail->Body)
      || empty($this->mail->Subject)
    ) {
      throw new Exception('Content and Subject are required');
    }

    foreach ($this->addressesTo as $user) {
      $this->mail->addAddress($user['address'], $user['name']);

      try {
        $this->mail->send();

        if (!empty($this->mail->ErrorInfo)) {
          $this->errors[] = $this->mail->ErrorInfo;
        }
      } catch (Exception $e) {
        $this->errors[] =  "Mailer Error ({$user['address']}) {$this->mail->ErrorInfo}";
      }
    
      $this->mail->clearAddresses();
    }

    return [
      'success' => empty($this->errors),
      'messages' => $this->errors
    ];
  }

}