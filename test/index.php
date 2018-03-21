<!DOCTYPE html>
<html lang="pt-br">
<head>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
</head>
<body>
    <script>    
        function gerarToken(){
            var brand = null;
			
            var sessao_id = document.getElementById('sessao_id').value;
            var numero = document.getElementById('cartao_numero').value;
            var codigo = document.getElementById('cartao_codigo').value;
            var mes = document.getElementById('cartao_mes').value;
            var ano = document.getElementById('cartao_ano').value;
            var bin = document.getElementById('cartao_bin').value;
            
            try{
                    debugger
                PagSeguroDirectPayment.setSessionId(sessao_id);
                console.log(sessao_id);
                document.getElementById('cartao_hash').value = PagSeguroDirectPayment.getSenderHash();
                PagSeguroDirectPayment.getBrand({
                        cardBin: bin,
                        success: function(response) {
                            brand = response.brand;
                            document.getElementById('cartao_bandeira').value = brand.name;
                            var param = {
                                            cardNumber: numero,
                                            cvv: codigo,
                                            expirationMonth: mes,
                                            expirationYear: ano,
                                            success: function(response) {
                                                 document.getElementById('cartao_token').value = response.card.token;
                                            },
                                            error: function(response) {
                                                alert("Erro ao gerar token");
                                            },
                                            complete: function(response) {}
                                        }
                            param.brand = brand.name;
                            PagSeguroDirectPayment.createCardToken(param);
                        },
                        error: function(response) {
                            alert("Erro ao pegar bandeira");
                        },
                        complete: function(response) {}
                });
            }
            catch(err) {
                alert(err.message);
            }
        }
    </script>
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
			$sessionCode = \PagSeguro\Services\Session::create(
				\PagSeguro\Configuration\Configure::getAccountCredentials()
			);
			
			$sessao_id = $sessionCode->getResult();
        
		} catch (Exception $e) {
			die($e->getMessage());
		}
	?>
        <p>Este botão chama a função javascript gerarToken() para que sejam gerados o hash e o token</p>
	<button onClick="gerarToken()">Gerar Hash e Token</button>
        <form action="autoriza.php" method="POST">
		<label>Sessão ID (Vem da chamada PHP)</label>
		<input type="text" name="sessao_id" id="sessao_id" value="<?php echo $sessao_id;?>">
		</br>
		<label>Numero do cartão (Em SandBox é 4111111111111111)</label>
		<input type="text" name="cartao_numero" id="cartao_numero" value="4111111111111111">
		</br>
		<label>Código (Em SandBox é 123)</label>
		<input type="text" name="cartao_codigo" id="cartao_codigo" value="123">
		</br>
		<label>Mês (Em SandBox é 12)</label>
		<input type="text" name="cartao_mes" id="cartao_mes" value="12">
		</br>
		<label>Ano (Em SandBox é 2030)</label>
		<input type="text" name="cartao_ano" id="cartao_ano" value="2030">
		</br>
		<label>Bin (Em SandBox é 411111)</label>
		<input type="text" name="cartao_bin" id="cartao_bin" value="411111">
                <p>Os dados acima são os necessários para gerar o token do cartão</p>
                </br>
		<label>Bandeira</label>
		<input type="text" name="cartao_bandeira" id="cartao_bandeira">
		</br>
		<label>Hash</label>
		<input type="text" name="cartao_hash" id="cartao_hash">
		</br>
		<label>Token</label>
		<input type="text" name="cartao_token" id="cartao_token">
		</br>
                <p>Os próximos dados são necessários para a autorização do pagamento</p>
                <label>Email que vai receber notificações</label>
                <input type="text" name="email_notificacoes" id="email_notificacoes" value="seuemail@email.com.br">
                </br>
                <label>Referência da compra</label>
		<input type="text" name="pedido_id" id="pedido_id" value="Pedido 123">
		</br>
                <label>Url de retorno</label>
		<input type="text" name="url_retorno" id="url_retorno" value="https://seusite.com.br/retorno.php?pedido_id=123">
		</br>
                <label>Nome do comprador</label>
		<input type="text" name="comprador_nome" id="comprador_nome" value="João comprador">
		</br>
                <label>CPF do comprador</label>
		<input type="text" name="comprador_cpf" id="comprador_cpf" value="12946213196">
		</br>
                <label>DDD do comprador</label>
		<input type="text" name="comprador_ddd" id="comprador_ddd" value="51">
		</br>
                <label>Telefone do comprador</label>
		<input type="text" name="comprador_telefone" id="comprador_telefone" value="988887777">
		</br>
                <label>Email do comprador (Em Sandbox deve ter o final @sandbox...)</label>
		<input type="text" name="comprador_email" id="comprador_email" value="c36241994342408943266@sandbox.pagseguro.com.br">
		</br>
                <label>Endereço de envio da mercadoria</label>
		<input type="text" name="endereco_endereco" id="endereco_endereco" value="Av Brasil">
		</br>
                <label>Numero</label>
		<input type="text" name="endereco_numero" id="endereco_numero" value="123">
		</br>
                <label>Bairro</label>
		<input type="text" name="endereco_bairro" id="endereco_bairro" value="Centro">
		</br>
                <label>Cep</label>
		<input type="text" name="endereco_cep" id="endereco_cep" value="95785000">
		</br>
                <label>Cidade</label>
		<input type="text" name="endereco_cidade" id="endereco_cidade" value="Harmonia">
		</br>
                <label>Estado UF</label>
		<input type="text" name="endereco_estado" id="endereco_estado" value="RS">
		</br>
                <label>Pais</label>
                <input type="text" name="endereco_pais" id="endereco_pais" value="BRA">
                </br>
                <label>Valor extra</label>
                <input type="text" name="valor_extra" id="valor_extra" value="10">
                </br>
                <label>Quantidade de parcelas</label>
                <input type="text" name="parcelas_quantidade" id="parcelas_quantidade" value="1">
                </br>
                <label>Valor total do pedido</label>
                <input type="text" name="valor_total" id="valor_total" value="110">
                </br>
                <label>Endereço de cobrança</label>
		<input type="text" name="cobranca_endereco" id="cobranca_endereco" value="Av Brasil">
		</br>
                <label>Numero</label>
		<input type="text" name="cobranca_numero" id="cobranca_numero" value="123">
		</br>
                <label>Bairro</label>
		<input type="text" name="cobranca_bairro" id="cobranca_bairro" value="Centro">
		</br>
                <label>Cep</label>
		<input type="text" name="cobranca_cep" id="cobranca_cep" value="95785000">
		</br>
                <label>Cidade</label>
		<input type="text" name="cobranca_cidade" id="cobranca_cidade" value="Harmonia">
		</br>
                <label>Estado UF</label>
		<input type="text" name="cobranca_estado" id="cobranca_estado" value="RS">
		</br>
                <label>Pais</label>
                <input type="text" name="cobranca_pais" id="cobranca_pais" value="BRA">
                </br>
                <label>Nome do titular do cartão</label>
                <input type="text" name="cartao_nome" id="cartao_nome" value="João comprador no cartão">
                </br>
                <label>Nascimento do titular do cartão</label>
                <input type="text" name="cartao_nascimento" id="cartao_nascimento" value="01/01/1990">
                </br>
                <label>DDD do titular do cartão</label>
                <input type="text" name="cartao_ddd" id="cartao_ddd" value="51">
                </br>
                <label>Telefone do titular do cartão</label>
                <input type="text" name="cartao_telefone" id="cartao_telefone" value="988887777">
                </br>
                <label>CPF do titular do cartão</label>
                <input type="text" name="cartao_cpf" id="cartao_cpf" value="12946213196">
                </br>
                <label>Produto sequencial com 3 casas</label>
                <input type="text" name="produto_sequencial" id="produto_sequencial" value="001">
                </br>
                <label>Produto descrição</label>
                <input type="text" name="produto_descricao" id="produto_descricao" value="Produto comprado na minha loja">
                </br>
                <label>Produto quantidade</label>
                <input type="text" name="produto_quantidade" id="produto_quantidade" value="1">
                </br>
                <label>Produto valor</label>
                <input type="text" name="produto_valor" id="produto_valor" value="100">
                </br>
                <input type="submit" value="Pagar">
	</form>
        
</body>

</html>