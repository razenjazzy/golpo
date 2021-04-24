<section class="section section_custom">
  <div class="section-header">
    <h1><i class="far fa-credit-card"></i> <?php echo $page_title; ?></h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><?php echo $this->lang->line("Subscription"); ?></div>
      <div class="breadcrumb-item"><?php echo $page_title; ?></div>
    </div>
  </div>

  <?php $this->load->view('admin/theme/message'); ?>

  <div class="section-body">
    <div class="row">
      <div class="col-12">
          <form action="<?php echo base_url("payment/accounts_action"); ?>" method="POST">
          <input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $this->session->userdata('csrf_token_session'); ?>">
          <div class="card">
            <div class="card-body">

                <div class="row">
                  <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for=""><i class="fas fa-at"></i> <?php echo $this->lang->line("Paypal Email");?> </label>
                        <input name="paypal_email" value="<?php echo isset($xvalue['paypal_email']) ? $xvalue['paypal_email'] :""; ?>"  class="form-control" type="email">              
                        <span class="red"><?php echo form_error('paypal_email'); ?></span>
                    </div>
                  </div>

                  <div class="col-12 col-md-4">
                    <div class="form-group">
                      <label for="paypal_payment_type" ><i class="fas fa-hand-holding-usd"></i>  <?php echo $this->lang->line('Paypal Recurring Payment');?></label>
                        
                        <div class="form-group">
                          <?php 
                          $paypal_payment_type =isset($xvalue['paypal_payment_type'])?$xvalue['paypal_payment_type']:"";
                          if($paypal_payment_type == '') $smtp_type='manual';
                          ?>
                          <label class="custom-switch mt-2">
                            <input type="checkbox" name="paypal_payment_type" value="recurring" class="custom-switch-input"  <?php if($paypal_payment_type=='recurring') echo 'checked'; ?>>
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description"><?php echo $this->lang->line('Enable');?></span>
                            <span class="red"><?php echo form_error('paypal_payment_type'); ?></span>
                          </label>
                        </div>
                    </div> 
                  </div>

                  <div class="col-12 col-md-4">
                    <div class="form-group">
                      <label for=""><i class="fas fa-vial"></i> <?php echo $this->lang->line('Paypal Sandbox Mode');?></label>
                      <br>
                      <?php 
                      $paypal_mode =isset($xvalue['paypal_mode'])?$xvalue['paypal_mode']:"";
                      if($paypal_mode == '') $paypal_mode='live';
                      ?>
                      <label class="custom-switch mt-2">
                        <input type="checkbox" name="paypal_mode" value="sandbox" class="custom-switch-input"  <?php if($paypal_mode=='sandbox') echo 'checked'; ?>>
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description"><?php echo $this->lang->line('Enable');?></span>
                        <span class="red"><?php echo form_error('paypal_mode'); ?></span>
                      </label>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-12 col-md-6">
                    <div class="form-group">
                      <label for=""><i class="fas fa-key"></i>  <?php echo $this->lang->line("Stripe Secret Key");?></label>
                      <input name="stripe_secret_key" value="<?php echo isset($xvalue['stripe_secret_key']) ? $xvalue['stripe_secret_key'] :""; ?>" class="form-control" type="text">  
                      <span class="red"><?php echo form_error('stripe_secret_key'); ?></span>
                    </div>
                  </div>

                  <div class="col-12 col-md-6">
                    <div class="form-group">
                      <label for=""><i class="fab fa-keycdn"></i> <?php echo $this->lang->line("Stripe Publishable Key");?></label>
                      <input name="stripe_publishable_key" value="<?php echo isset($xvalue['stripe_publishable_key']) ? $xvalue['stripe_publishable_key'] :""; ?>" class="form-control" type="text">  
                      <span class="red"><?php echo form_error('stripe_publishable_key'); ?></span>
                    </div>
                  </div>
                </div>

                 <div class="row">
                  <div class="col-12 col-md-8">
                    <div class="form-group">
                      <label for=""><i class="fas fa-key"></i>  <?php echo $this->lang->line("Mollie API Key");?></label>
                      <input name="mollie_api_key" value="<?php echo isset($xvalue['mollie_api_key']) ? $xvalue['mollie_api_key'] :""; ?>" class="form-control" type="text">  
                      <span class="red"><?php echo form_error('mollie_api_key'); ?></span>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-6 col-md-6">
                    <div class="form-group">
                      <label for=""><i class="fas fa-key"></i>  <?php echo $this->lang->line("Razorpay Key ID");?></label>
                      <input name="razorpay_key_id" value="<?php echo isset($xvalue['razorpay_key_id']) ? $xvalue['razorpay_key_id'] :""; ?>" class="form-control" type="text">  
                      <span class="red"><?php echo form_error('razorpay_key_id'); ?></span>
                    </div>
                  </div>

                  <div class="col-6 col-md-6">
                    <div class="form-group">
                      <label for=""><i class="fas fa-key"></i> <?php echo $this->lang->line("Razorpay Key Secret");?></label>
                      <input name="razorpay_key_secret" value="<?php echo isset($xvalue['razorpay_key_secret']) ? $xvalue['razorpay_key_secret'] :""; ?>" class="form-control" type="text">  
                      <span class="red"><?php echo form_error('razorpay_key_secret'); ?></span>
                    </div>
                  </div>
                </div>


                <div class="row">
                  <div class="col-6 col-md-6">
                    <div class="form-group">
                      <label for=""><i class="fas fa-key"></i>  <?php echo $this->lang->line("Paystack Secret Key");?></label>
                      <input name="paystack_secret_key" value="<?php echo isset($xvalue['paystack_secret_key']) ? $xvalue['paystack_secret_key'] :""; ?>" class="form-control" type="text">  
                      <span class="red"><?php echo form_error('paystack_secret_key'); ?></span>
                    </div>
                  </div>

                  <div class="col-6 col-md-6">
                    <div class="form-group">
                      <label for=""><i class="fas fa-key"></i> <?php echo $this->lang->line("Paystack Public Key");?></label>
                      <input name="paystack_public_key" value="<?php echo isset($xvalue['paystack_public_key']) ? $xvalue['paystack_public_key'] :""; ?>" class="form-control" type="text">  
                      <span class="red"><?php echo form_error('paystack_public_key'); ?></span>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-12 col-md-6">
                    <div class="form-group">
                      <label for=""><i class="fas fa-coins"></i>  <?php echo $this->lang->line("Currency");?></label>
                      <?php $default_currency = isset($xvalue['currency']) ? $xvalue['currency'] : "USD"; ?>               
                      <select name='currency' class='form-control select2' style='width:100% !important;'>
                      <?php
                      foreach ($currecny_list_all as $key => $value)
                      {
                        $paypal_supported = in_array($key, $currency_list) ? " - PayPal & Stripe" : "";
                        if($default_currency==$key) $selected_curr = "selected='selected'";
                        else $selected_curr = '';
                        echo '<option value="'.$key.'" '.$selected_curr.' >'.str_replace('And', '&', ucwords($value)).$paypal_supported.'</option>';
                      }
                      ?>
                      </select>
                      <span class="red"><?php echo form_error('currency'); ?></span>
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="form-group">
                      <label for=""><i class="fas fa-file-invoice-dollar"></i> <?php echo $this->lang->line('Enable manual payment');?></label>
                      <br>
                      <?php 
                        $manual_payment =isset($xvalue['manual_payment'])?$xvalue['manual_payment']:"";
                        if($manual_payment == "") $manual_payment = "no";
                      ?>
                      <label class="custom-switch mt-2">
                        <input type="checkbox" name="manual_payment" class="custom-switch-input" value="yes" <?php if ($manual_payment == "yes") echo "checked"; ?>>
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description"><?php echo $this->lang->line('Enable');?></span>
                        <span class="red"><?php echo form_error('manual_payment'); ?></span>
                      </label>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div id="manual-payins" class="col-12">
                    <div class="form-group">
                      <label><i class="fa fa-info"></i> <?php echo $this->lang->line('Manual payment instructions'); ?></label>
                      <textarea name="manual_payment_instruction" class="summernote form-control" style="height: 200px !important"><?php echo set_value('manual_payment_instruction', isset($xvalue['manual_payment_instruction']) ? $xvalue['manual_payment_instruction'] : ""); ?></textarea>
                      <span class="red"><?php echo form_error('manual_payment_instruction'); ?></span>
                    </div>
                  </div>                    
                </div>
            </div>

            <div class="card-footer bg-whitesmoke">
              <button class="btn btn-primary btn-lg" id="save-btn" type="submit"><i class="fas fa-save"></i> <?php echo $this->lang->line("Save");?></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
