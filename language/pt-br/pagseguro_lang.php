<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

$lang['_text_title'] 			                = 'Pagseguro';
$lang['text_tab_general'] 	                    = 'Geral';
$lang['text_description'] 	                    = 'Pagar com cartão de crédito usando Stripe';
$lang['text_live'] 	                            = 'Ativo';
$lang['text_test'] 	                            = 'Teste';
$lang['text_parc_true'] 	                    = 'Aceitar';
$lang['text_parc_false'] 	                    = 'Não aceitar';
$lang['text_cc_number'] 	                    = 'Somente os NÚMEROS';
$lang['text_cc_name'] 	                        = 'João da Silva';
$lang['text_cc_date'] 	                        = '01/01/1990';
$lang['text_cc_cpf'] 	                        = 'Somente os NÚMEROS';
$lang['text_exp_month'] 	                    = '12';
$lang['text_exp_year'] 	                        = '2018';
$lang['text_cc_cvc'] 	                        = 'CVC';
$lang['text_stripe_charge_description'] 	    = '%s Cobrar por %s';
$lang['text_payment_status'] 	                = 'Forma de pagamento %s (%s)';

$lang['label_title'] 	                        = 'Título';
$lang['label_description'] 	                    = 'Descrição';
$lang['label_transaction_mode']                 = 'Modo de transação';
$lang['label_api_mode']                         = 'API';
$lang['label_email_vendor'] 	                = 'Seu e-mail';
$lang['label_token_vendor']                     = 'Seu token';
$lang['label_order_total'] 	                    = 'Valor minimo do pedido';
$lang['label_order_status']                     = 'Status do pedido';
$lang['label_priority'] 	                    = 'Prioridade';
$lang['label_status'] 	                        = 'Status';
$lang['label_card_number'] 	                    = 'NÚMERO DO CARTÃO';
$lang['label_card_expiry'] 	                    = 'DATA DE VALIDADE';
$lang['label_card_cvc'] 	                    = 'CVC';
$lang['button_valide'] 	                        = 'Validar';
$lang['label_card_name'] 	                    = 'Nome do titular';
$lang['label_card_date'] 	                    = 'Data de nascimento do titular';
$lang['label_card_cpf'] 	                    = 'CPF do titular';
$lang['label_card_par'] 	                    = 'Parcelamento';

$lang['help_order_total'] 		                = 'O valor total que o pedido deve atingir antes desta forma de pagamento se torna ativo';
$lang['help_order_status'] 	                    = 'Status do pedido padrão quando Stripe é o método de pagamento selecionado';

$lang['alert_min_order_total'] 	                = 'Você precisa gastar %s ou mais para usar este método de pagamento</p>';
$lang['alert_error_contacting']                 = '<p class="alert-danger">Ocorreu um problema ao contactar o gateway de pagamento. Por favor, tente novamente.</p>';

/* End of file cod_lang.php */
/* Location: ./extensions/cod/language/english/cod_lang.php */