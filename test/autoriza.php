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
        $creditCard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();
        $creditCard->setMode('DEFAULT');
        $creditCard->setCurrency("BRL");      
        $creditCard->setSender()->setHash($_POST['cartao_hash']);
        $creditCard->setToken($_POST['cartao_token']);
        $creditCard->setReceiverEmail($_POST['email_notificacoes']);
        $creditCard->setReference($_POST['pedido_id']);
        $creditCard->setNotificationUrl($_POST['url_retorno']);
        $creditCard->setSender()->setName($_POST['comprador_nome']);
        $creditCard->setSender()->setDocument()->withParameters('CPF', $_POST['comprador_cpf']);
        $creditCard->setSender()->setPhone()->withParameters($_POST['comprador_ddd'], $_POST['comprador_telefone']);
        $creditCard->setSender()->setEmail($_POST['comprador_email']);
        

        $creditCard->setShipping()->setAddress()->withParameters(
            $_POST['endereco_endereco'],
            $_POST['endereco_numero'],
            $_POST['endereco_bairro'],
            $_POST['endereco_cep'],
            $_POST['endereco_cidade'],
            $_POST['endereco_estado'],
            $_POST['endereco_pais'],
            ''
        );
        $creditCard->setExtraAmount($_POST['valor_extra']);
        
        $creditCard->setInstallment()->withParameters($_POST['parcelas_quantidade'], $_POST['valor_total']);
        $creditCard->setBilling()->setAddress()->withParameters(
            $_POST['cobranca_endereco'],
            $_POST['cobranca_numero'],
            $_POST['cobranca_bairro'],
            $_POST['cobranca_cep'],
            $_POST['cobranca_cidade'],
            $_POST['cobranca_estado'],
            $_POST['cobranca_pais'],
            ''    
        );
        $creditCard->setHolder()->setName($_POST['cartao_nome']); // Igual ao cartão de credito
        $creditCard->setHolder()->setBirthdate($_POST['cartao_nascimento']);
        $creditCard->setHolder()->setPhone()->withParameters($_POST['cartao_ddd'], $_POST['cartao_telefone']);
        $creditCard->setHolder()->setDocument()->withParameters('CPF', $_POST['cartao_cpf']);
        
        $creditCard->addItems()->withParameters(
            $_POST['produto_sequencial'],
            $_POST['produto_descricao'],
            $_POST['produto_quantidade'],
            $_POST['produto_valor']
        );
        
        $result = $creditCard->register(\PagSeguro\Configuration\Configure::getAccountCredentials());

        $array = (array) $result;
        $json = explode('\u0000', json_encode($array, true));
        
        $substr = substr($json["10"], 0, 11);
        $text = $substr;
        $respost = explode('"',$text);
        
        $status['status'] = $respost[2];
        
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

        
            print_r($status_lista[$status['status']]);
        } 
        catch (Exception $e) { 
            echo "</br> <strong>";
            die($e->getMessage());
        }
?>