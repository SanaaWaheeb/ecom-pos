<div class="row">
    <div class="row">
        <div class="form-group col-md-4">
            <label for="mail_driver" class="form-label"><?php echo e(__('Mail Driver')); ?></label>
            <?php echo e(Form::text('mail_driver', isset($setting['MAIL_DRIVER']) ? $setting['MAIL_DRIVER'] : null,  ['class' => 'form-control', 'placeholder' => __('Enter Mail Driver'), 'id' => 'mail_driver'])); ?>


        </div>
        <?php if($email_setting == 'custom'): ?>
        <div class="form-group col-md-4">
            <label for="mail_host" class="form-label"><?php echo e(__('Mail Host')); ?></label>
            <?php echo e(Form::text('mail_host', isset($setting['MAIL_HOST']) ? $setting['MAIL_HOST'] : null, ['class' => 'form-control', 'placeholder' => __('Enter Mail Host'), 'id' => 'mail_host'])); ?>

        </div>
        <?php elseif($email_setting == 'gmail'): ?>
        <div class="form-group col-md-4">
            <label for="mail_host" class="form-label"><?php echo e(__('Mail Host')); ?></label>
            <input type="text" name="mail_host" id="mail_host" value="smtp.gmail.com" class="form-control" readonly="readonly" >
        </div>
        <?php elseif($email_setting == 'outlook'): ?>
        <div class="form-group col-md-4">
            <label for="mail_host" class="form-label"><?php echo e(__('Mail Host')); ?></label>
            <input type="text" name="mail_host" id="mail_host" value="smtp.office365.com" class="form-control" readonly="readonly" >
        </div>
        <?php elseif($email_setting == 'yahoo'): ?>
        <div class="form-group col-md-4">
            <label for="mail_host" class="form-label"><?php echo e(__('Mail Host')); ?></label>
            <input type="text" name="mail_host" id="mail_host" value="smtp.mail.yahoo.com" class="form-control" readonly="readonly" >
        </div>
        <?php elseif($email_setting == 'sendgrid'): ?>
        <div class="form-group col-md-4">
            <label for="mail_host" class="form-label"><?php echo e(__('Mail Host')); ?></label>
            <input type="text" name="mail_host" id="mail_host" value="smtp.sendgrid.net" class="form-control" readonly="readonly" >
        </div>
        <?php elseif($email_setting == 'amazon'): ?>
        <div class="form-group col-md-4">
            <label for="mail_host" class="form-label"><?php echo e(__('Mail Host')); ?></label>
            <input type="text" name="mail_host" id="mail_host" value="email-smtp.us-east-1.amazonaws.com" class="form-control" readonly="readonly" >
        </div>
        <?php elseif($email_setting == 'mailgun'): ?>
        <div class="form-group col-md-4">
            <label for="mail_host" class="form-label"><?php echo e(__('Mail Host')); ?></label>
            <input type="text" name="mail_host" id="mail_host" value="smtp.mailgun.org" class="form-control" readonly="readonly" >
        </div>
        <?php elseif($email_setting == 'smtp.com'): ?>
        <div class="form-group col-md-4">
            <label for="mail_host" class="form-label"><?php echo e(__('Mail Host')); ?></label>
            <input type="text" name="mail_host" id="mail_host" value="smtp.smtp.com" class="form-control" readonly="readonly" >
        </div>
        <?php elseif($email_setting == 'zohomail'): ?>
        <div class="form-group col-md-4">
            <label for="mail_host" class="form-label"><?php echo e(__('Mail Host')); ?></label>
            <input type="text" name="mail_host" id="mail_host" value="smtp.zoho.com" class="form-control" readonly="readonly" >
        </div>
        <?php elseif($email_setting == 'mailtrap'): ?>
        <div class="form-group col-md-4">
            <label for="mail_host" class="form-label"><?php echo e(__('Mail Host')); ?></label>
            <input type="text" name="mail_host" id="mail_host" value="smtp.mailtrap.io" class="form-control" readonly="readonly" >
        </div>
        <?php elseif($email_setting == 'mandrill'): ?>
        <div class="form-group col-md-4">
            <label for="mail_host" class="form-label"><?php echo e(__('Mail Host')); ?></label>
            <input type="text" name="mail_host" id="mail_host" value="smtp.mandrillapp.com" class="form-control" readonly="readonly" >
        </div>
        <?php elseif($email_setting == 'smtp'): ?>
        <div class="form-group col-md-4">
            <label for="mail_host" class="form-label"><?php echo e(__('Mail Host')); ?></label>
            <?php echo e(Form::text('mail_host', isset($setting['MAIL_HOST']) ? $setting['MAIL_HOST'] : null, ['class' => 'form-control', 'placeholder' => __('Enter Mail Host'), 'id' => 'mail_host'])); ?>

        </div>
        <?php elseif($email_setting == 'sparkpost'): ?>
        <div class="form-group col-md-4">
            <label for="mail_host" class="form-label"><?php echo e(__('Mail Host')); ?></label>
            <input type="text" name="mail_host" id="mail_host" value="smtp.sparkpostmail.com" class="form-control" readonly="readonly" >

        </div>
        <?php endif; ?>

        <?php if($email_setting == 'custom'): ?>
        <div class="form-group col-md-4">
            <label for="mail_port" class="form-label"><?php echo e(__('Mail Port')); ?></label>
            <?php echo e(Form::text('mail_port', isset($setting['MAIL_PORT']) ? $setting['MAIL_PORT'] : null, ['class' => 'form-control', 'placeholder' => __('Enter Mail Port'), 'id' => 'mail_port'])); ?>

        </div>
        <?php elseif($email_setting == 'smtp'): ?>
        <div class="form-group col-md-4">
            <label for="mail_port" class="form-label"><?php echo e(__('Mail Port')); ?></label>
            <?php echo e(Form::text('mail_port',  isset($setting['MAIL_PORT']) ? $setting['MAIL_PORT'] : null,  ['class' => 'form-control', 'placeholder' => __('Enter Mail Port'), 'id' => 'mail_port'])); ?>

        </div>
        <?php else: ?>
        <div class="form-group col-md-4">
            <label for="mail_port" class="form-label"><?php echo e(__('Mail Port')); ?></label>
            <input type="text" name="mail_port" id="mail_port" value="587" class="form-control" readonly="readonly" >
        </div>
        <?php endif; ?>
        <?php if($email_setting == 'custom'): ?>
        <div class="form-group col-md-4">
                  <label for="mail_username" class="form-label"><?php echo e(__('Mail Username')); ?></label>
                  <?php echo e(Form::text('mail_username',   isset($setting['MAIL_USERNAME']) ? $setting['MAIL_USERNAME'] : null,  ['class' => 'form-control', 'placeholder' => __('Enter Mail Username'), 'id' => 'mail_username'])); ?>

        </div>
        <?php elseif($email_setting == 'gmail'): ?>
              <div class="form-group col-md-4">
                  <label for="mail_username" class="form-label"><?php echo e(__('Your Gmail email address')); ?></label>
                  <?php echo e(Form::text('mail_username',   isset($setting['MAIL_USERNAME']) ? $setting['MAIL_USERNAME'] : null,  ['class' => 'form-control', 'placeholder' => __('Your Gmail Email Address'), 'id' => 'mail_username'])); ?>

              </div>
        <?php elseif($email_setting == 'smtp'): ?>
        <div class="form-group col-md-4">
          <label for="mail_username" class="form-label"><?php echo e(__('Mail Username')); ?></label>
          <?php echo e(Form::text('mail_username',   isset($setting['MAIL_USERNAME']) ? $setting['MAIL_USERNAME'] : null,  ['class' => 'form-control', 'placeholder' => __('Enter Mail Username'), 'id' => 'mail_username'])); ?>

        </div>
        <?php elseif($email_setting == 'outlook'): ?>
        <div class="form-group col-md-4">
        <label for="mail_username" class="form-label"><?php echo e(__(' Your Outlook/Office 365 email address')); ?></label>
          <?php echo e(Form::text('mail_username',   isset($setting['MAIL_USERNAME']) ? $setting['MAIL_USERNAME'] : null,  ['class' => 'form-control', 'placeholder' => __(' Your Outlook/Office 365 Email Address'), 'id' => 'mail_username'])); ?>

        </div>
        <?php elseif($email_setting == 'yahoo'): ?>
        <div class="form-group col-md-4">
        <label for="mail_username" class="form-label"><?php echo e(__('Your Yahoo email address')); ?></label>
          <?php echo e(Form::text('mail_username',   isset($setting['MAIL_USERNAME']) ? $setting['MAIL_USERNAME'] : null,  ['class' => 'form-control', 'placeholder' => __('Your Yahoo Email Address'), 'id' => 'mail_username'])); ?>

        </div>
        <?php elseif($email_setting == 'sendgrid'): ?>
        <div class="form-group col-md-4">
        <label for="mail_username" class="form-label"><?php echo e(__('Your SendGrid username or API key')); ?></label>
          <?php echo e(Form::text('mail_username',   isset($setting['MAIL_USERNAME']) ? $setting['MAIL_USERNAME'] : null,  ['class' => 'form-control', 'placeholder' => __('Your SendGrid Username or API Key'), 'id' => 'mail_username'])); ?>

        </div>
        <?php elseif($email_setting == 'amazon'): ?>
        <div class="form-group col-md-4">
        <label for="mail_username" class="form-label"><?php echo e(__('Your AWS IAM username or access key ID')); ?></label>
          <?php echo e(Form::text('mail_username',   isset($setting['MAIL_USERNAME']) ? $setting['MAIL_USERNAME'] : null,  ['class' => 'form-control', 'placeholder' => __('Your AWS IAM Username or Access Key ID'), 'id' => 'mail_username'])); ?>

        </div>
        <?php elseif($email_setting == 'mailgun'): ?>
        <div class="form-group col-md-4">
        <label for="mail_username" class="form-label"><?php echo e(__('Your Mailgun SMTP username')); ?></label>
          <?php echo e(Form::text('mail_username',   isset($setting['MAIL_USERNAME']) ? $setting['MAIL_USERNAME'] : null,  ['class' => 'form-control', 'placeholder' => __('Your Mailgun SMTP Username'), 'id' => 'mail_username'])); ?>

        </div>
        <?php elseif($email_setting == 'smtp.com'): ?>
        <div class="form-group col-md-4">
        <label for="mail_username" class="form-label"><?php echo e(__('Your Mailgun SMTP username')); ?></label>
          <?php echo e(Form::text('mail_username',   isset($setting['MAIL_USERNAME']) ? $setting['MAIL_USERNAME'] : null,  ['class' => 'form-control', 'placeholder' => __('Your Mailgun SMTP Username'), 'id' => 'mail_username'])); ?>

        </div>
        <?php elseif($email_setting == 'zohomail'): ?>
        <div class="form-group col-md-4">
        <label for="mail_username" class="form-label"><?php echo e(__('Your Zoho Mail email address')); ?></label>
          <?php echo e(Form::text('mail_username',   isset($setting['MAIL_USERNAME']) ? $setting['MAIL_USERNAME'] : null,  ['class' => 'form-control', 'placeholder' => __('Your Zoho Mail Email Address'), 'id' => 'mail_username'])); ?>

        </div>

        <?php elseif($email_setting == 'mandrill'): ?>
        <div class="form-group col-md-4">
        <label for="mail_username" class="form-label"><?php echo e(__('Your Mandrill API key')); ?></label>
          <?php echo e(Form::text('mail_username',   isset($setting['MAIL_USERNAME']) ? $setting['MAIL_USERNAME'] : null,  ['class' => 'form-control', 'placeholder' => __('Your Mandrill API Key'), 'id' => 'mail_username'])); ?>

        </div>
        <?php elseif($email_setting == 'mailtrap'): ?>
        <div class="form-group col-md-4">
        <label for="mail_username" class="form-label"><?php echo e(__('Your Mailtrap username')); ?></label>
          <?php echo e(Form::text('mail_username',   isset($setting['MAIL_USERNAME']) ? $setting['MAIL_USERNAME'] : null,  ['class' => 'form-control', 'placeholder' => __('Your Mailtrap Username'), 'id' => 'mail_username'])); ?>

        </div>
        <?php elseif($email_setting == 'sparkpost'): ?>
        <div class="form-group col-md-4">
        <label for="mail_username" class="form-label"><?php echo e(__('Your SparkPost SMTP username')); ?></label>
          <?php echo e(Form::text('mail_username',   isset($setting['MAIL_USERNAME']) ? $setting['MAIL_USERNAME'] : null,  ['class' => 'form-control', 'placeholder' => __('Your SparkPost SMTP Username'), 'id' => 'mail_username'])); ?>

        </div>
        <?php endif; ?>


        <div class="form-group col-md-4">
            <label for="mail_password" class="form-label"><?php echo e(__('Mail Password')); ?></label>
            <?php echo e(Form::text('mail_password',  isset($setting['MAIL_PASSWORD']) ? $setting['MAIL_PASSWORD'] : null,  ['class' => 'form-control', 'placeholder' => __('Enter Mail Password'), 'id' => 'mail_password'])); ?>

        </div>
        <?php if($email_setting == 'custom'): ?>
        <div class="form-group col-md-4">
            <label for="" class="form-label"><?php echo e(__('Mail Encryption')); ?></label>
            <?php echo e(Form::text('mail_encryption',isset($setting['MAIL_ENCRYPTION']) ? $setting['MAIL_ENCRYPTION'] : null, ['class' => 'form-control', 'placeholder' => __('Enter Mail Encryption'), 'id' => 'mail_encryption'])); ?>

        </div>
        <?php elseif($email_setting == 'smtp'): ?>
        <div class="form-group col-md-4">
            <label for="mail_encryption" class="form-label"><?php echo e(__('Mail Encryption')); ?></label>
            <?php echo e(Form::text('mail_encryption',isset($setting['MAIL_ENCRYPTION']) ? $setting['MAIL_ENCRYPTION'] : null, ['class' => 'form-control', 'placeholder' => __('Enter Mail Encryption'), 'id' => 'mail_encryption'])); ?>

        </div>
        <?php else: ?>
        <div class="form-group col-md-4">
            <label for="mail_encryption" class="form-label"><?php echo e(__('Mail Encryption')); ?></label>
            <input type="text" name="mail_encryption" id="mail_encryption" value="tls" class="form-control" readonly="readonly" >
        </div>
        <?php endif; ?>
        <div class="form-group col-md-4">
            <label for="mail_from_address" class="form-label"><?php echo e(__('Mail From Address')); ?></label>
            <?php echo e(Form::text('mail_from_address',isset($setting['MAIL_FROM_ADDRESS']) ? $setting['MAIL_FROM_ADDRESS'] : null, ['class' => 'form-control ', 'placeholder' => __('Enter Mail From Address'), 'id' => 'mail_from_address'])); ?>

        </div>
        <div class="form-group col-md-4">
            <label for="mail_from_name" class="form-label"><?php echo e(__('Mail From Name')); ?></label>
            <?php echo e(Form::text('mail_from_name', isset($setting['MAIL_FROM_NAME']) ? $setting['MAIL_FROM_NAME'] : null, ['class' => 'form-control', 'placeholder' => __('Enter Mail From Name'), 'id' => 'mail_from_name'])); ?>

        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        $('input[readonly="readonly"]').css('background-color', '#e9ecef');
    });
</script>
<?php /**PATH C:\xampp\htdocs\ecommerce-pos\resources\views/setting/email_fields.blade.php ENDPATH**/ ?>