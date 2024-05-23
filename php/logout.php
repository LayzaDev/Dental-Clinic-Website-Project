<?php
  // inicia a sessao
  session_start();  
  // apaga as variaveis de sessao
  session_unset();
  // destroi a sessao
  session_destroy();
  // exclui o cookie da sessao
  setcookie(session_name(), "", 1, "/");

  header('Location: ../index.html');
  exit();
?>