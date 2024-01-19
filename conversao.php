<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
    <body>
        <main>
            <h1>Conversor de moeda</h1>
            <?php 
            //cotacao copiada do google
            // $cotação = 5.17;

            $inicio = date('m-d-Y', strtotime("-7 days"));
            $fim = date("m-d-Y");
            $url ='https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\''. $inicio .'\'&@dataFinalCotacao=\''. $fim .'\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao'; //colocar \ antes da ' datas  para interpolar 

            $dados = json_decode(file_get_contents($url), true);
            
            $cotação = $dados["value"][0]["cotacaoCompra"];

            $padrao = numfmt_create("pt_BR",NumberFormatter::CURRENCY);

            date_default_timezone_set("America/Sao_Paulo");
            $fim2 = date("d-m-Y");
            echo  "<p>COTAÇÃO: $fim2 -> <strong>" . numfmt_format_currency($padrao,$cotação,"USD") . "</strong> </p> ";

            // quanto R$ vc tem ?
            $real = $_REQUEST["din"]; //?? 0;
        
            //equivalencia em dolar 
            $dolar = $real / $cotação;
        
            //Mostar o resultado 
            //echo "Seus R\$". number_format($ral,2,",",".") . "equivalem a US\$ . number_format($ral,2,",",".")";
        
            //Formatação de moedas com intenacinalização!
            //Biblioteca intl (internallization PHP) se estiver no XAMP entrar no aquivo PHP/php.ini  titar a ; do intl
        
            $padrao = numfmt_create("pt_BR",NumberFormatter::CURRENCY);
        
            echo "<p>Seus " . numfmt_format_currency($padrao,$real,"BRL") . " equivalem a <strong>" . numfmt_format_currency($padrao,$dolar,"USD") . "</strong></p>";
            ?>
            <button onclick="javascript:history.go(-1)">Voltar</button>
        </main>     
    </body>
</html>



