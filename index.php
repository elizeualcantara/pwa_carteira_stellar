<!DOCTYPE html>
<html lang="en">
<head>
  <title>Formulario Stellar E7</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="manifest" href="./manifest.json">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-VFH91CNXJF"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-VFH91CNXJF');
</script>

</head>
<body>

<div class="container">
  <br> 
  <h3>Consulta Extrato Stellar</h3>
  <hr style="width:100%; border-width:3px">
  <p>Informe a Chave Pública Stellar para consultar o extrato de movimentação financeira da Carteira</p>
  <form action="extrato_token.php" class="needs-validated" method="post">
    <div class="form-group">
      <label for="uname">Chave Pública Stellar:</label>
      <input type="text" class="form-control" id="token" placeholder="Cole aqui a Chave Pública Stellar" name="token" required>
    </div>
    <button type="submit" class="btn btn-primary">Consultar Extrato da Carteira</button>

  </form>

<br>
<hr style="width:100%; border-width:3px">

<p><a href="https://www.e7.com.br">Powered by E7</a>
<br>
<font color=gray style="font-size:13px">Desenvolvimento: <a href="mailto:elizeu@elizeu.com.br"><font color=gray style="font-size:13px">Elizeu Alcantara</font></a> / <a href="mailto:emerson_lobo@hotmail.com"><font color=gray style="font-size:13px">Emerson Lobo</font></a></font>
</p>
<br>

</div>

<script>
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
      navigator.serviceWorker.register('./service-worker.js');
    });
  }
</script>

</body>
</html>
