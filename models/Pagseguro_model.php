<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

require FCPATH . 'vendor/autoload.php';

class Pagseguro_model extends TI_Model{
    
    public function __construct() {
		parent::__construct();

		$this->load->library('cart');
        $this->load->library('currency');
    }
    


    public function createCharge($order_data){

        
		\PagSeguro\Library::initialize();
		\PagSeguro\Library::cmsVersion()->setName("Nome")->setRelease("1.0.0");
		\PagSeguro\Library::moduleVersion()->setName("Nome")->setRelease("1.0.0");
		
		\PagSeguro\Configuration\Configure::setEnvironment($order_data['transaction_mode']);//production or sandbox
		\PagSeguro\Configuration\Configure::setAccountCredentials(
			$order_data['email_vendor'],
			$order_data['token_vendor']
		);
		\PagSeguro\Configuration\Configure::setCharset('UTF-8');// UTF-8 or ISO-8859-1
		\PagSeguro\Configuration\Configure::setLog(true, 'log_pagseguro.log');
		
		try {
			$sessionCode = \PagSeguro\Services\Session::create(
				\PagSeguro\Configuration\Configure::getAccountCredentials()
			);
			
            $sessao_id = $sessionCode->getResult();
            
            return $sessao_id;

		} catch (Exception $e) {
			die($e->getMessage());
        }
	}
	
	public function valide($order_data, $cart_contents, $cart){
 
		$ddd = substr($order_data['telephone'], 0, 2);
		$tele = substr($order_data['telephone'], 2);
		$parcela;
		$total;
		$taxa;

		if ($cart_contents['totals']['delivery']['amount'] != null){
			$taxa = (float) $cart_contents['totals']['delivery']['amount'];
		}else{
			$taxa = 0;
		}

		if($order_data['ext_payment']['ext_data']['card_par'] === 'true'){
			$parcela = $cart['cc_parc_quantity'];
			$total =(float) $cart['cc_parc_installmentAmount'];
		}else{
			$parcela = 1;
			$total = $cart_contents['cart_total'];
		}


		\PagSeguro\Library::initialize();
		\PagSeguro\Library::cmsVersion()->setName("Nome")->setRelease("1.0.0");
		\PagSeguro\Library::moduleVersion()->setName("Nome")->setRelease("1.0.0");
	
		\PagSeguro\Configuration\Configure::setEnvironment($order_data['ext_payment']['ext_data']['transaction_mode']);//production or sandbox
		\PagSeguro\Configuration\Configure::setAccountCredentials(
				$order_data['ext_payment']['ext_data']['email_vendor'],
				$order_data['ext_payment']['ext_data']['token_vendor']
		);
		\PagSeguro\Configuration\Configure::setCharset('UTF-8');// UTF-8 or ISO-8859-1
		\PagSeguro\Configuration\Configure::setLog(true, 'log_pagseguro.log');
		try {
			$creditCard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();
			$creditCard->setMode('DEFAULT');
			$creditCard->setCurrency("BRL");      
			$creditCard->setSender()->setHash($cart['cc_hash']);
			$creditCard->setToken($cart['cc_token']);
			$creditCard->setReceiverEmail($order_data['ext_payment']['ext_data']['email_vendor']);
			$creditCard->setReference($order_data['order_id']);
			$creditCard->setNotificationUrl('http://localhost/teste_restaurante/index.php/checkout');
			$creditCard->setSender()->setName($order_data['first_name'].' '.$order_data['last_name']);
			$creditCard->setSender()->setDocument()->withParameters('CPF', $cart['cc_cpf']);
			$creditCard->setSender()->setPhone()->withParameters($ddd, $tele);
			$creditCard->setSender()->setEmail($order_data['email']);
			
	
			$creditCard->setShipping()->setAddress()->withParameters(
				$cart['address_1'],
				$cart['country_id'],
				$cart['address_2'],
				$cart['postcode'],
				$cart['city'],
				$cart['state'],
				'BRA',
				''
			);

			$creditCard->setExtraAmount($taxa);

			$creditCard->setInstallment()->withParameters($parcela, $total);
			$creditCard->setBilling()->setAddress()->withParameters(
				$cart['address_1'],
				$cart['country_id'],
				$cart['address_2'],
				$cart['postcode'],
				$cart['city'],
				$cart['state'],
				'BRA',
				''    
			);

			$creditCard->setHolder()->setName($cart['cc_name']); // Igual ao cartão de credito
			$creditCard->setHolder()->setBirthdate($cart['cc_date']);
			$creditCard->setHolder()->setPhone()->withParameters($ddd, $tele);
			$creditCard->setHolder()->setDocument()->withParameters('CPF', $cart['cc_cpf']);
			
			
			$max = count($cart_contents);
			$array;
			for ($i=0; $i < $max; $i++) { 
				$array[$i] = key($cart_contents);
				next($cart_contents);
			}

			for ($i=4; $i < $max; $i++) { 
				$produto = $cart_contents[$array[$i]];
				$creditCard->addItems()->withParameters(
					$produto['id'],
					$produto['name'],
					$produto['qty'],
					$produto['price']
				);
			}
			
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
	
			return $status_lista[$status['status']];
			
		} 
		catch (Exception $e) { 
			return $e->getMessage();
		}
	}
    
}
