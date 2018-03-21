<?php
    require_once "../../../vendor/autoload.php";
    $pagseguro_email = 'kevincosta13679@outlook.com';
    $pagseguro_token = 'C34FCB36824D4C38A750142FD5C211B6';

    \PagSeguro\Library::initialize();
    \PagSeguro\Library::cmsVersion()->setName("Nome")->setRelease("1.0.0");
    \PagSeguro\Library::moduleVersion()->setName("Nome")->setRelease("1.0.0");

    \PagSeguro\Configuration\Configure::setEnvironment('sandbox');//production or sandbox
    \PagSeguro\Configuration\Configure::setAccountCredentials(
            $pagseguro_email,
            $pagseguro_token
    );
    \PagSeguro\Configuration\Configure::setCharset('UTF-8');// UTF-8 or ISO-8859-1
    \PagSeguro\Configuration\Configure::setLog(true, 'log_pagseguro.log');
    
    try {
        if (\PagSeguro\Helpers\Xhr::hasPost()) {
            $response = \PagSeguro\Services\Transactions\Notification::check(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );
        } else {
            throw new \InvalidArgumentException($_POST);
        }
        
        $pedido_id = '7BCD9F39-8CE8-4393-9F93-B2BB07D3275C';
        $pagamento_id_externo = $response->getCode();
        $pagamento_evento = 'transaction';

        $status_lista = [
            1=>"Aguardando pagamento", 
            2=>"Pagamento em análise", 
            3=>"Pago", 
            4=>"Pagamento disponível", 
            5=>"Pagamento em disputa", 
            6=>"Pagamento devolvido", 
            7=>"Pagamento cancelado", 
            8=>"Pagamento debitado", 
            9=>"Pagamento em retenção temporária"
            ];

        $status_codigo = $response->getStatus();
        $status_descricao = $status_lista[$status_codigo];

        $pagamento_situacao = $status_codigo.":".$status_descricao;
    
    } 
    catch (Exception $e) {
        echo 'Erro ao inserir retorno do pagamento!';
    }
?>