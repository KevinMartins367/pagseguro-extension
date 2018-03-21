<div class="radio">
	<script type="text/javascript" src="<?php echo set_value('api_mode', $api_mode);?>"></script>

    <label>
        <?php if ($minimum_order_total >= $order_total) { ?>
            <input type="radio" name="payment" value="" <?php echo set_radio('payment', ''); ?> disabled />
        <?php } else if ($payment === $code) { ?>
            <input type="radio" name="payment" value="<?php echo $code; ?>" <?php echo set_radio('payment', $code, TRUE); ?> />
        <?php } else { ?>
            <input type="radio" name="payment" value="<?php echo $code; ?>" <?php echo set_radio('payment', $code); ?> />
        <?php } ?>
        <?php echo $title; ?>
    </label>
    <?php if ($minimum_order_total >= $order_total) { ?>
        <br /><span class="text-info"><?php echo sprintf(lang('alert_min_order_total'), currency_format($minimum_order_total)); ?></span>
    <?php } ?>
</div>
<div id="pagseguro-payment" class="wrap-horizontal" style="<?php echo ($payment === 'pagseguro') ? 'display: block;' : 'display: none;'; ?>">
	<?php if (!empty($pagseguro_token)) { ?>
		<input type="hidden" name="pagseguro_token" value="<?php echo $pagseguro_token; ?>" />
	<?php } ?>

	<div class="row">
	    <div class="col-xs-12">
			<div class="pagseguro-errors"></div>
		</div>
	</div>
	<div class="row">
	    <div class="col-xs-12">
	        <div class="form-group">
	            <label for="input-card-number"><?php echo lang('label_card_number'); ?></label>
	            <div class="input-group">
	                <input type="text" id="input-card-number" class="form-control" name="pagseguro_cc_number" value="<?php echo set_value('pagseguro_cc_number', $pagseguro_cc_number); ?>" placeholder="<?php echo lang('text_cc_number'); ?>" autocomplete="cc-number" size="20" data-pagseguro="number" required />
	                <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
	            </div>
		        <?php echo form_error('pagseguro_cc_number', '<span class="text-danger">', '</span>'); ?>
	        </div>
	    </div>
	</div>
	<div class="row">
	    <div class="col-xs-7 col-md-7">
	        <div class="form-group">
	            <label for="input-expiry-month"><?php echo lang('label_card_expiry'); ?></label>
	            <div class="row">
	                <div class="col-xs-6 col-lg-6">
				        <input type="tel" class="form-control" id="input-expiry-month" name="pagseguro_cc_exp_month" value="<?php echo set_value('pagseguro_cc_exp_month', $pagseguro_cc_exp_month); ?>" placeholder="<?php echo lang('text_exp_month'); ?>" autocomplete="off" size="2" data-pagseguro="exp-month" required data-numeric />
			        </div>
			        <div class="col-xs-6 col-lg-6">
				        <input type="tel" class="form-control" id="input-expiry-year" name="pagseguro_cc_exp_year" value="<?php echo set_value('pagseguro_cc_exp_year', $pagseguro_cc_exp_year); ?>" placeholder="<?php echo lang('text_exp_year'); ?>" autocomplete="off" size="4" data-pagseguro="exp-year" required data-numeric />
			        </div>
		        </div>
		        <?php echo form_error('pagseguro_cc_exp_month', '<span class="text-danger">', '</span>'); ?>
		        <?php echo form_error('pagseguro_cc_exp_year', '<span class="text-danger">', '</span>'); ?>
	        </div>
	    </div>
	    <div class="col-xs-5 col-md-5 pull-right">
	        <div class="form-group">
	            <label for="input-card-cvc"><?php echo lang('label_card_cvc'); ?></label>
	            <input type="tel" class="form-control" id="pagseguro-cc-cvc" name="pagseguro_cc_cvc" value="<?php echo set_value('pagseguro_cc_cvc', $pagseguro_cc_cvc); ?>" placeholder="<?php echo lang('text_cc_cvc'); ?>" autocomplete="off" size="4" data-pagseguro="cvc" required />
		        <?php echo form_error('pagseguro_cc_cvc', '<span class="text-danger">', '</span>'); ?>
	        </div>
	    </div>
		<div class="col-md-7">
							<input type="text"id="pagseguro-cc-hash" name="pagseguro_cc_hash" value="<?php echo set_value('pagseguro_cc_hash', $pagseguro_cc_hash); ?>" autocomplete="off"  data-pagseguro="hash" required hidden/>
							<input type="text" id="pagseguro-cc-brand-name" name="pagseguro_cc_brand_name" value="<?php echo set_value('pagseguro_cc_brand_name', $pagseguro_cc_brand_name); ?>"  autocomplete="off"  data-pagseguro="brand-name" required hidden/>
							<input type="text" id="pagseguro-cc-token" name="pagseguro_cc_token" value="<?php echo set_value('pagseguro_cc_token', $pagseguro_cc_token); ?>" autocomplete="off"  data-pagseguro="token" required hidden/>
			<a class="btn btn-primary" id='button_valide'><?php echo lang('button_valide'); ?></a>		        
		</div>
	</div>
	    <div id="pagseguro-info" class="row">
			<div class="col-xs-12 col-lg-12">
				<div class="form-group">
					<label for="input-card-name"><?php echo lang('label_card_name'); ?></label>
					<div >
						<input type="text" id="input-card-name" class="form-control" name="pagseguro_cc_name" value="<?php echo set_value('pagseguro_cc_name', $pagseguro_cc_name); ?>" placeholder="<?php echo lang('text_cc_name'); ?>" autocomplete="cc-name" data-pagseguro="name" required />
					</div>
					<?php echo form_error('pagseguro_cc_name', '<span class="text-danger">', '</span>'); ?>
				</div>
			</div>
			<div class="col-xs-6 col-lg-6">
				<div class="form-group">
					<label for="input-card-date"><?php echo lang('label_card_date'); ?></label>
					<div class="input-group">
						<input type="text" id="input-card-date" class="form-control" name="pagseguro_cc_date" value="<?php echo set_value('pagseguro_cc_date', $pagseguro_cc_date); ?>" placeholder="<?php echo lang('text_cc_date'); ?>" autocomplete="cc-date" size="20" data-pagseguro="date" required />
					</div>
					<?php echo form_error('pagseguro_cc_date', '<span class="text-danger">', '</span>'); ?>
				</div>
			</div>
			<div class="col-xs-6 col-lg-6">
				<div class="form-group">
					<label for="input-card-cpf"><?php echo lang('label_card_cpf'); ?></label>
					<div class="input-group">
						<input type="text" id="input-card-cpf" class="form-control" name="pagseguro_cc_cpf" value="<?php echo set_value('pagseguro_cc_cpf', $pagseguro_cc_cpf); ?>" placeholder="<?php echo lang('text_cc_cpf'); ?>" autocomplete="cc-cpf" size="20" data-pagseguro="cpf" required />
					</div>
					<?php echo form_error('pagseguro_cc_cpf', '<span class="text-danger">', '</span>'); ?>
				</div>
			</div>
			<div class="col-xs-12 col-lg-12" id="div-parce">
				<div class="form-group">
					<label for="input-card-par"><?php echo lang('label_card_par'); ?></label>
					<div class="form-group">
						<select name="pagseguro_cc_par" id="input-card-par" class="form-control" >
							<option value="">Escolha...</option>
						</select>
					</div>
					<?php echo form_error('pagseguro_cc_par', '<span class="text-danger">', '</span>'); ?>
				</div>
			</div>
	    </div>
</div>
<script type="text/javascript"><!--
	
	$(document).ready(function() {
		$('input[name="payment"]').on('change', function () {
			if (this.value === 'pagseguro') {
				$('#pagseguro-payment').slideDown();
				$('#pagseguro-info').slideUp();
				$('#div-parce').slideUp();
			} else {
				$('#pagseguro-payment').slideUp();
				$('#pagseguro-info').slideUp();
				$('#div-parce').slideUp();
			}
		});

		$('input[name="payment"]:checked').trigger('change');

		$('#button_valide').on('click', function () {
			
			var brand = null;
			var numero = document.getElementById('input-card-number').value;
			var mes = document.getElementById('input-expiry-month').value;
			var ano = document.getElementById('input-expiry-year').value;
			var codigo = document.getElementById('pagseguro-cc-cvc').value;
			var bin = numero.substr(0, 6);
			var parc = <?php echo set_value('parcela', $parcela); ?>;			
            try{
				PagSeguroDirectPayment.setSessionId("<?php echo set_value('sessao_id', $sessao_id);?>");
                var Hash = PagSeguroDirectPayment.getSenderHash();
				document.getElementById('pagseguro-cc-hash').value = Hash;
                PagSeguroDirectPayment.getBrand({
                        cardBin: bin,
                        success: function(response) {
                            brand = response.brand;
							
							var nome = brand.name;
							document.getElementById('pagseguro-cc-brand-name').value = nome;
                            var param = {
                                            cardNumber: numero,
                                            cvv: codigo,
                                            expirationMonth: mes,
                                            expirationYear: ano,
                                            success: function(response) {
                                                var token = response.card.token;
												document.getElementById('pagseguro-cc-token').value = token;

												if (parc === true) {
													$('#div-parce').slideDown();
													
													PagSeguroDirectPayment.getInstallments({
														amount: <?php echo set_value('total', $total);?>,
														brand: nome,
														success: function(response) {
															if (response.installments != null) {
																var data = response.installments[nome];
																var selectbox = $('#input-card-par');
																
																selectbox.find('option').remove();
																$.each(data, function (i, d) {
																	console.log(d);
																	$('<option>').val(d.quantity+'#'+d.installmentAmount+'#'+d.totalAmount).text(d.quantity+' parcelas(valor da parcela: '+ d.installmentAmount +');').appendTo(selectbox);
																});
															}
														},
														error: function(response) {
														console.error(response);
														},
														complete: function(response) { 
														},
													});

												}
												
												$('#pagseguro-info').slideDown();
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
                console.log(err.message);
            }
		})
	});
--></script>


