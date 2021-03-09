<?php

require('./EmailUtils/EmailFactory.php');

use EmailUtils\EmailFactory;

// imagens 'cid' vão como anexo no email
$contentWithImageCid = "
  <img src=\"cid:image_cid\" alt=\"Logo empresa\">
  <h1>Título do email de teste</h1>

  <p>Aqui é um parágrafo e contéum um link que envia pro google bem <a href=\"https://google.com\">aqui</a></p>
";

$fileBlob = file_get_contents('alguma url para arquivo aqui');

$response = EmailFactory::new()
  ->to('dan.sjose20@gmail.com', 'Anderso Rocha')
  ->subject('Assunto do email aqui')
  ->content($contentWithImageCid, true)
  // Para fazer a ligação da imagem do tipo cid com o arquivo presente no servidor
  // Essa imagem além de aparecer na visualização do email, também será incluida como anexo
  ->embeddedImage('path/to/image.jpg', 'image_cid')
  // Para adicionar um anexo ao email pelo caminho dele no servidor
  ->attachment('path/to/image.jpg', 'Image.jpg')
  // para adicionar um arquivo blob como anexo
  ->stringAttachment($fileBlob, 'NomeArquivo.extensao')
  // Realiza o envio do email
  ->send();

var_dump($response);
