<div class="date" style="background:#7CAF00;
                color:#fff;
                padding:5px 8px;
                width:auto;
                float:right;">
<?php __('Inviata il'); ?>:
<?php echo digi_date(date('D j M Y, H:i')); ?>
</div>
<h1 style="font-size:14px;">

Riepilogo ordini per il paniere <?php echo $hamper['Hamper']['name'] ?> <br>
di <?php echo $hamper['Seller']['name']; ?> <br>
del <?php echo digi_date($hamper['Hamper']['delivery_date_on']); ?><br>
</h1>
<br>
<h1 style="font-size:12px;"> Ciao <?php echo $userFullName ?> <br> </h1>
<br>
<br/>
In allegato il riepilogo dell'ordine