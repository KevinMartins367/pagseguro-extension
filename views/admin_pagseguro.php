<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-title" class="col-sm-3 control-label"><?php echo lang('label_title'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="title" id="input-title" class="form-control" value="<?php echo set_value('title', $title); ?>" />
							<?php echo form_error('title', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-description" class="col-sm-3 control-label"><?php echo lang('label_description'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="description" id="input-description" class="form-control" value="<?php echo set_value('description', $description); ?>" />
							<?php echo form_error('description', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-transaction-mode" class="col-sm-3 control-label"><?php echo lang('label_transaction_mode'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-3 btn-group-toggle" data-toggle="buttons">
								<?php if ($transaction_mode === 'production') { ?>
									<label class="btn btn-success active"><input type="radio" name="transaction_mode" value="production" <?php echo set_radio('transaction_mode', 'production', TRUE); ?>><?php echo lang('text_live'); ?></label>
									<label class="btn btn-danger"><input type="radio" name="transaction_mode" value="sandbox" <?php echo set_radio('transaction_mode', 'sandbox'); ?>><?php echo lang('text_test'); ?></label>
								<?php } else { ?>
									<label class="btn btn-success"><input type="radio" name="transaction_mode" value="production" <?php echo set_radio('transaction_mode', 'production'); ?>><?php echo lang('text_live'); ?></label>
									<label class="btn btn-danger active"><input type="radio" name="transaction_mode" value="sandbox" <?php echo set_radio('transaction_mode', 'sandbox', TRUE); ?>><?php echo lang('text_test'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('transaction_mode', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-api-mode" class="col-sm-3 control-label"><?php echo lang('label_api_mode'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-3 btn-group-toggle" data-toggle="buttons">
								<?php if ($api_mode === 'https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js') { ?>
									<label class="btn btn-success active"><input type="radio" name="api_mode" value="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js" <?php echo set_radio('api_mode', 'https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js', TRUE); ?>><?php echo lang('text_live'); ?></label>
									<label class="btn btn-danger"><input type="radio" name="api_mode" value="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js" <?php echo set_radio('api_mode', 'https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js'); ?>><?php echo lang('text_test'); ?></label>
								<?php } else { ?>
									<label class="btn btn-success"><input type="radio" name="api_mode" value="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js" <?php echo set_radio('api_mode', 'https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js'); ?>><?php echo lang('text_live'); ?></label>
									<label class="btn btn-danger active"><input type="radio" name="api_mode" value="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js" <?php echo set_radio('api_mode', 'https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js', TRUE); ?>><?php echo lang('text_test'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('transaction_mode', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-card-par" class="col-sm-3 control-label"><?php echo lang('label_card_par'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-3 btn-group-toggle" data-toggle="buttons">
								<?php if ($card_par === 'true') { ?>
									<label class="btn btn-success active"><input type="radio" name="card_par" value="true" <?php echo set_radio('card_par', 'true', TRUE); ?>><?php echo lang('text_parc_true'); ?></label>
									<label class="btn btn-danger"><input type="radio" name="card_par" value="false" <?php echo set_radio('card_par', 'false'); ?>><?php echo lang('text_parc_false'); ?></label>
								<?php } else { ?>
									<label class="btn btn-success"><input type="radio" name="card_par" value="true" <?php echo set_radio('card_par', 'true'); ?>><?php echo lang('text_parc_true'); ?></label>
									<label class="btn btn-danger active"><input type="radio" name="card_par" value="false" <?php echo set_radio('card_par', 'false', TRUE); ?>><?php echo lang('text_parc_false'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('transaction_mode', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-email-vendor" class="col-sm-3 control-label"><?php echo lang('label_email_vendor'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="email_vendor" id="input-email-vendor" class="form-control" value="<?php echo set_value('email_vendor', $email_vendor); ?>" />
							<?php echo form_error('email_vendor', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-token-vendor" class="col-sm-3 control-label"><?php echo lang('label_token_vendor'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="token_vendor" id="input-token-vendor" class="form-control" value="<?php echo set_value('token_vendor', $token_vendor); ?>" />
							<?php echo form_error('token_vendor', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-order-total" class="col-sm-3 control-label"><?php echo lang('label_order_total'); ?>
							<span class="help-block"><?php echo lang('help_order_total'); ?></span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="order_total" id="input-order-total" class="form-control" value="<?php echo set_value('order_total', $order_total); ?>" />
							<?php echo form_error('order_total', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-order-status" class="col-sm-3 control-label"><?php echo lang('label_order_status'); ?>
							<span class="help-block"><?php echo lang('help_order_status'); ?></span>
						</label>
						<div class="col-sm-5">
							<select name="order_status" id="input-order-status" class="form-control">
								<?php foreach ($statuses as $stat) { ?>
								<?php if ($stat['status_id'] === $order_status) { ?>
									<option value="<?php echo $stat['status_id']; ?>" selected="selected"><?php echo $stat['status_name']; ?></option>
								<?php } else { ?>
									<option value="<?php echo $stat['status_id']; ?>"><?php echo $stat['status_name']; ?></option>
								<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('order_status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-priority" class="col-sm-3 control-label"><?php echo lang('label_priority'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="priority" id="input-priority" class="form-control" value="<?php echo $priority; ?>" />
							<?php echo form_error('priority', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-status" class="col-sm-3 control-label"><?php echo lang('label_status'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($status == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="status" value="0" <?php echo set_radio('status', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="status" value="1" <?php echo set_radio('status', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="status" value="0" <?php echo set_radio('status', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="status" value="1" <?php echo set_radio('status', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>