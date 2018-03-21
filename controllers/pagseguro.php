<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Pagseguro extends Main_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Orders_model');
        $this->load->model('Addresses_model');
        $this->load->model('Countries_model');
    }

    public function index() {
        $this->lang->load('pagseguro/pagseguro');

        if ( ! file_exists(EXTPATH .'pagseguro/views/pagseguro.php')) { 								//check if file exists in views folder
            show_404(); 																		// Whoops, show 404 error page!
        }

        $payment = $this->extension->getPayment('pagseguro');

        // START of retrieving lines from language file to pass to view.
        $data['code'] 			= $payment['name'];
        $data['title'] 			= !empty($payment['ext_data']['title']) ? $payment['ext_data']['title'] : $payment['title'];
        $data['description'] 	= !empty($payment['ext_data']['description']) ? $payment['ext_data']['description'] : $this->lang->line('text_description');
        
        // END of retrieving lines from language file to send to view.

        $order_data = $this->session->userdata('order_data');                           // retrieve order details from session userdata
        $data['payment'] = !empty($order_data['payment']) ? $order_data['payment'] : '';
        $data['minimum_order_total'] = is_numeric($payment['ext_data']['order_total']) ? $payment['ext_data']['order_total'] : 0;
        $data['order_total'] = $this->cart->total();
 
		if ($this->input->post('pagseguro_token')) {
			$data['pagseguro_token'] = $this->input->post('pagseguro_token');
		} else {
			$data['pagseguro_token'] = '';
		}

	    if (isset($this->input->post['pagseguro_cc_number'])) {
            $data['pagseguro_cc_number'] =  $this->input->post('pagseguro_cc_number');
        } else {
            $data['pagseguro_cc_number'] = '';
        }

        if (isset($this->input->post['pagseguro_cc_exp_month'])) {
            $data['pagseguro_cc_exp_month'] = $this->input->post('pagseguro_cc_exp_month');
        } else {
            $data['pagseguro_cc_exp_month'] = '';
        }

        if (isset($this->input->post['pagseguro_cc_exp_year'])) {
            $data['pagseguro_cc_exp_year'] = $this->input->post('pagseguro_cc_exp_year');
        } else {
            $data['pagseguro_cc_exp_year'] = '';
        }

        if (isset($this->input->post['pagseguro_cc_cvc'])) {
            $data['pagseguro_cc_cvc'] = $this->input->post('pagseguro_cc_cvc');
        } else {
            $data['pagseguro_cc_cvc'] = '';
        }
        // pass array $data and load view files
        // var_dump($data);
        $data['api_mode'] = $payment['ext_data']['api_mode'];

        $this->load->model('Pagseguro_model');
        $response = $this->Pagseguro_model->createCharge($payment['ext_data']);
        $data['sessao_id'] = $response;
        $data['parcela'] = $payment['ext_data']['card_par'];
        $cart_contents = $this->session->userdata('cart_contents');
        $data['total'] = $cart_contents['order_total']; 


        //var_dump($cart_contents);
        return $this->load->view('pagseguro/pagseguro', $data, TRUE);
    }

    public function confirm() {
        
        $this->lang->load('pagseguro/pagseguro');


        $estadosBrasileiros = array(
            'AC'=>'Acre',
            'AL'=>'Alagoas',
            'AP'=>'Amapá',
            'AM'=>'Amazonas',
            'BA'=>'Bahia',
            'CE'=>'Ceará',
            'DF'=>'Distrito Federal',
            'ES'=>'Espírito Santo',
            'GO'=>'Goiás',
            'MA'=>'Maranhão',
            'MT'=>'Mato Grosso',
            'MS'=>'Mato Grosso do Sul',
            'MG'=>'Minas Gerais',
            'PA'=>'Pará',
            'PB'=>'Paraíba',
            'PR'=>'Paraná',
            'PE'=>'Pernambuco',
            'PI'=>'Piauí',
            'RJ'=>'Rio de Janeiro',
            'RN'=>'Rio Grande do Norte',
            'RS'=>'Rio Grande do Sul',
            'RO'=>'Rondônia',
            'RR'=>'Roraima',
            'SC'=>'Santa Catarina',
            'SP'=>'São Paulo',
            'SE'=>'Sergipe',
            'TO'=>'Tocantins'
            );

        $order_data = $this->session->userdata('order_data'); 						// retrieve order details from session userdata
        $cart_contents = $this->session->userdata('cart_contents'); 												// retrieve cart contents

        $cart['cc_number'] = $this->input->post('pagseguro_cc_number');
        $cart['cc_exp_month'] = $this->input->post('pagseguro_cc_exp_month');
        $cart['cc_exp_year'] = $this->input->post('pagseguro_cc_exp_year');
        $cart['cc_cvc'] = $this->input->post('pagseguro_cc_cvc');
        $cart['cc_hash'] = $this->input->post('pagseguro_cc_hash');
        $cart['cc_brand_name'] = $this->input->post('pagseguro_cc_brand_name');
        $cart['cc_token'] = $this->input->post('pagseguro_cc_token');
        $cart['cc_name'] = $this->input->post('pagseguro_cc_name');
        $cart['cc_date'] = $this->input->post('pagseguro_cc_date');
        $cart['cc_cpf'] = $this->input->post('pagseguro_cc_cpf');

        $parce = $this->input->post('pagseguro_cc_par');
        $array = explode('#',$parce);

        $cart['cc_parc_quantity'] = $array[0];
        $cart['cc_parc_installmentAmount'] = $array[1];
        $cart['cc_parc_totalAmount'] = $array[2];

		$cart['order_type'] = $this->location->orderType();
        $cart['address_id'] = $this->customer->getAddressId();                                        // retrieve customer default address id from customer library
		
		$addresses = $this->Addresses_model->getAddresses($this->customer->getId());              
        
        $key = array_search($addresses[$cart['address_id']]['state'], $estadosBrasileiros);
        $cep = explode('-',$addresses[$cart['address_id']]['postcode']);

        $cart['address_1']     = $addresses[$cart['address_id']]['address_1'];
        $cart['address_2']     = $addresses[$cart['address_id']]['address_2'];
        $cart['city']         =  $addresses[$cart['address_id']]['city'];
        $cart['state']         = $key;
        $cart['postcode']      = $cep[0].$cep[1];
        $cart['country_id']    = $addresses[$cart['address_id']]['country_id'];
       
        
        $this->load->model('Pagseguro_model');
        $response = $this->Pagseguro_model->valide($order_data, $cart_contents, $cart);

        var_dump($response);
        if (empty($order_data) AND empty($cart_contents)) {
            return FALSE;
        }

        if (!empty($order_data['ext_payment']) AND !empty($order_data['payment']) AND $order_data['payment'] == 'pagseguro') { 											// else if payment method is cash on delivery

            $ext_payment_data = !empty($order_data['ext_payment']['ext_data']) ? $order_data['ext_payment']['ext_data'] : array();

            if (!empty($ext_payment_data['order_total']) AND $cart_contents['order_total'] < $ext_payment_data['order_total']) {
                $this->alert->set('danger', $this->lang->line('alert_min_total'));
                return FALSE;
            }

	        // if (isset($response->error->message)) {
			// 	if ($response->error->type === 'card_error') $this->alert->set('danger', $response->error->message);
			// } else if (isset($response->status)) {

			// 	if ($response->status !== 'succeeded') {
			// 		$order_data['status_id'] = $ext_payment_data['order_status'];
			// 	} else if (isset($ext_payment_data['order_status']) AND is_numeric($ext_payment_data['order_status'])) {
			//         $order_data['status_id'] = $ext_payment_data['order_status'];
		    //     } else {
			// 		$order_data['status_id'] = $this->config->item('default_order_status');
			// 	}

			// 	if (!empty($response->paid)) {
			// 		$comment = sprintf($this->lang->line('text_payment_status'), $response->status, $response->id);
			// 	} else {
			// 		$comment = "{$response->failure_message} {$response->id}";
			// 	}

		    //     $order_history = array(
			//         'object_id'  => $order_data['order_id'],
			//         'status_id'  => $order_data['status_id'],
			//         'notify'     => '0',
			//         'comment'    => $comment,
			//         'date_added' => mdate('%Y-%m-%d %H:%i:%s', time()),
		    //     );

		    //     $this->load->model('Statuses_model');
		    //     $this->Statuses_model->addStatusHistory('order', $order_history);

			// 	$this->load->model('Orders_model');
			// 	if ($this->Orders_model->completeOrder($order_data['order_id'], $order_data, $cart_contents)) {
			// 		redirect('checkout/success');									// redirect to checkout success page with returned order id
		    //     }
			// }

			// return FALSE;
        }
    }
}

/* End of file Pagseguro.php */
/* Location: ./extensions/Pagseguro/controllers/Pagseguro.php */