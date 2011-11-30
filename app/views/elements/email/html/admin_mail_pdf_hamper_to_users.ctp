<div class="date" style="background:#7CAF00;
                color:#fff;
                padding:5px 8px;
                width:auto;
                float:right;">
<?php __('Inviata il'); ?>:
<?php echo digi_date(date('D j M Y, H:i')); ?>
</div>
<h1 style="font-size:14px;">

Riepilogo ordine per il paniere <?php echo $hamper['Hamper']['name'] ?> <br>
di <?php echo $hamper['Seller']['name']; ?> <br>
del <?php echo digi_date($hamper['Hamper']['delivery_date_on']); ?><br>
</h1>
<br>
<h1 style="font-size:12px;"> Ciao <?php echo $userFullName ?> <br> </h1>
<br>
Devi ritirare i prodotti ordinati presso  <?php echo $hamper['Hamper']['delivery_position']; ?><br>
dal <?php echo digi_date($hamper['Hamper']['delivery_date_on']); ?><br>
al <?php echo digi_date($hamper['Hamper']['delivery_date_off']); ?>.<br>
Il termine ultimo per il pagamento è <?php echo digi_date($hamper['Hamper']['checkout_date']); ?><br>

<br/><br/>


In allegato riepilogo ordine