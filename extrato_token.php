<?php
date_default_timezone_set('america/sao_paulo');

session_start();

$conta = trim($_REQUEST['token']);

if ($conta=="") {
    header("Location: index.php"); 
    exit();
}
// DEBUG
//$conta = 'GCS74AAJPK3K3FWUMO7N2RR6UJDXDS6BUEESVQHFNZ5CMQTE5TI5OK7M';

$carteira_anterior="";
$historico_atual="";
$historico_anterior="";

if (isset($_GET['token'])) {
  // ESTA VINDO DE LINK DE UM EXTRATO EXISTENTE, PORTANTO RECUPERA A CARTEIRA ORIGINAL PARA O HISTORY.BACK
  $carteira_anterior = $_SESSION["carteira"];


  if (isset($_GET['historico'])) {
    // ESTA VINDO DE LINK DE UM EXTRATO EXISTENTE, PORTANTO DEFINE O HISTORY.BACK
    $historico = $_GET["historico"];

    switch ($historico) {

      case "1":
        $historico_atual = "2";
        $_SESSION["carteira2"] = $conta;
        $link_conta_anterior = $_SESSION["carteira1"];
        $historico_anterior = "0";
        break;
      case "2":
        $historico_atual = "3";
        $_SESSION["carteira3"] = $conta;
        $link_conta_anterior = $_SESSION["carteira2"];
        $historico_anterior = "1";
        break;
      case "3":
        $historico_atual = "4";
        $_SESSION["carteira4"] = $conta;
        $link_conta_anterior = $_SESSION["carteira3"];
        $historico_anterior = "2";
        break;
      case "4":
        $historico_atual = "5";
        $_SESSION["carteira5"] = $conta;
        $link_conta_anterior = $_SESSION["carteira4"];
        $historico_anterior = "3";
        break;
      case "5":
        $historico_atual = "6";
        $_SESSION["carteira6"] = $conta;
        $link_conta_anterior = $_SESSION["carteira5"];
        $historico_anterior = "4";
        break;
      case "6":
        $historico_atual = "7";
        $_SESSION["carteira7"] = $conta;
        $link_conta_anterior = $_SESSION["carteira6"];
        $historico_anterior = "5";
        break;
      case "7":
        $historico_atual = "8";
        $_SESSION["carteira8"] = $conta;
        $link_conta_anterior = $_SESSION["carteira7"];
        $historico_anterior = "6";
        break;
      case "8":
        $historico_atual = "9";
        $_SESSION["carteira9"] = $conta;
        $link_conta_anterior = $_SESSION["carteira8"];
        $historico_anterior = "7";
        break;
      case "9":
        $historico_atual = "10";
        $_SESSION["carteira10"] = $conta;
        $link_conta_anterior = $_SESSION["carteira9"];
        $historico_anterior = "8";
        break;
      case "10":
        $historico_atual = "11";
        $_SESSION["carteira11"] = $conta;
        $link_conta_anterior = $_SESSION["carteira10"];
        $historico_anterior = "9";
        break;


    }
  }
}

if ($historico_atual=="") {
  $historico_atual="1";
  $_SESSION["carteira1"]  = $conta;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Consulta Extrato Stellar E7</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="manifest" href="./manifest.json">
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
 
<?php

$context = stream_context_create(array(
    'http' => array('ignore_errors' => true)
));

$dados_conta = file_get_contents('https://api.stellar.expert/api/explorer/public/payments?account='.$conta.'&order=desc&limit=100', false, $context);

// VERIFICA SE RETORNOU DADOS HTTP 200
if ($http_response_header[0] != 'HTTP/1.1 200 OK') {
    echo "<br><br><p> &nbsp; &nbsp;CHAVE PUBLICA STELLAR INVÁLIDA.</p><br> &nbsp; &nbsp;<a href='index.php' class='btn btn-primary' role='button'>Voltar</a>";
    exit;
}

// ARMAZENA A CARTEIRA ATUAL, PARA PERMITIR NAVEGACAO HISTORY.BACK
$_SESSION["carteira"]   = $conta;

// TRANSFORMAR RESPOSTA EM FORMATO JSON PARA O FORMATO ARRAY DO PHP
$dados_json = json_decode($dados_conta, true);

// PEGANDO DA MATRIX _embedded
$dados = $dados_json['_embedded'];

?>

<div class="container-fluid">
  <br>
  <h3>Extrato de Movimentação Financeira Stellar</h3>
  <hr style="width:100%; border-width:3px">

  <div class="row">
    <div class="col-md-8">
      <font color='#008ae6'>Dados atualizados em <?php echo date("d/m/Y H:i:s"); ?> (Mostrando os últimos 100 movimentos)</font>
      <br>
      <img  src='wallet.png' width='30' height='30'  style='vertical-align:  text-bottom; padding: 5px;'> <font color='#008ae6'>Carteira</font> <font color='gray'><?php echo substr($conta,0,10) . "..." . substr($conta,(strlen($conta)-10),strlen($conta)); ?></font>
    </div>

    <div class="col-md-4" align="right">
        <BR>
      
        <?php if (($carteira_anterior !="") and ($_GET['historico'] > 0)) { ?>
        <a href='extrato_token.php?token=<?php echo $link_conta_anterior; ?>&historico=<?php echo $historico_anterior; ?>' class="btn btn-primary" role="button">Voltar</a>
        <?php } ?>
        <a href="index.php" class="btn btn-primary" role="button">Nova Consulta</a>
        &nbsp;&nbsp;
    </div>    
  </div>

  <br>


  <table class="table-dark table-striped table-responsive table-condensed">
    <thead>
      <tr>
        <th>&nbsp;Data</th>
        <th>Movimento</th>
        <th>Moeda</th>
        <th>Valor</th>
      </tr>
    </thead>
    <tbody>

<?php
 
$grid="";

for($i = 0; $i < sizeof($dados["records"]); $i++)
{

    $id="";
    $ts="";  
    $data_transacao="";
    $from="";  
    $to="";   
    $origem="";  
    $destino=""; 
    $origem_destino=""; 
    $status_transacao="";  
    $cor_status_transacao="";  
    $asset="";  
    $asset_completo="";
    $amount="";  
    $amount_completo="";

    $id     =$dados["records"][$i]["id"];
    $ts     =$dados["records"][$i]["ts"];
    $from   =$dados["records"][$i]["from"];
    $to     =$dados["records"][$i]["to"];
    $asset  =$dados["records"][$i]["asset"];
    $amount =$dados["records"][$i]["amount"];

    // TRATAMENTOS

    $id = substr($id,0,4) . "..." . substr($id,(strlen($id)-4),strlen($id));
    $data_transacao = substr($ts,8,2) . "/" . substr($ts,5,2) ;
    $status_transacao = ($from==$conta) ? 'Enviado para ' : 'Recebido de ';
    $cor_status_transacao = ($from==$conta) ? '#ff4d4d' : '#00e600';
    $sinal_status_transacao = ($from==$conta) ? '-' : '+';
    
    $origem_destino = ($from==$conta) ? substr($to,0,4) . "..." . substr($to,(strlen($to)-4),strlen($to)) : substr($from,0,4) . "..." . substr($from,(strlen($from)-4),strlen($from)) ; 
    $carteira_origem_destino = ($from==$conta) ? $to : $from;

    //$origem = ($from==$conta) ? '<font color="#66c2ff">SEU TOKEN</font>' : substr($from,0,4) . "..." . substr($from,(strlen($from)-4),strlen($from)); 
    //$destino = ($from==$conta) ? substr($to,0,4) . "..." . substr($to,(strlen($to)-4),strlen($to)) : '<font color="#66c2ff">SEU TOKEN</font>'; 

    $asset_completo = explode("-", $asset);
    $asset = $asset_completo[0]; 

    if(strpos($amount, '.') !== false) {
        $amount_completo = explode(".", $amount);
        $amount = $amount_completo[0] . "." . substr($amount_completo[1],0,4) ; 
    } else {
        // nao explode
    }

    $grid .= "<tr>";
    $grid .= "<td>&nbsp;" . $data_transacao . "&nbsp;</td>";
    $grid .= "<td><a href='extrato_token.php?token=". $carteira_origem_destino ."&historico=". $historico_atual ."'><font color='" . $cor_status_transacao . "'>" . $status_transacao . "<u>". $origem_destino . "</u></font></a></td>";
    $grid .= "<td nowrap><img  src='moeda.png' width='20' height='20'> " . $asset . "</td>";
    $grid .= "<td>&nbsp;<font color='" . $cor_status_transacao . "'>" . $sinal_status_transacao . $amount . "</font></td>";
    $grid .= "</tr>";

}

echo $grid;

?>    

    </tbody>
  </table>


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
