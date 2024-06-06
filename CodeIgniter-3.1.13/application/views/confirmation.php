<h1 class="confirmation-title">Confirmation d'inscription</h1>
<?php if ($this->session->flashdata('success')): ?>
    <p class="confirmation-error"><?php echo $this->session->flashdata('success'); ?></p>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
    <p class="confirmation-error"><?php echo $this->session->flashdata('error'); ?></p>
<?php endif; ?>

<?php echo form_open('utilisateur/confirmer', array('class' => 'confirmation-form')); ?>
    <div>
        <label for="email">Email</label>
        <input type="text" name="email" value="<?php echo set_value('email'); ?>">
        <?php echo form_error('email'); ?>
    </div>
    <div>
        <label for="code">Code de confirmation</label>
        <input type="text" name="code" value="<?php echo set_value('code'); ?>">
        <?php echo form_error('code'); ?>
    </div>
    <div>
        <button type="submit">Confirmer</button>
    </div>
<?php echo form_close(); ?>
