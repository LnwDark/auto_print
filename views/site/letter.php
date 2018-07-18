<?php
$value = $company
?>

<div style="height: 50px">
        <div style="width: 5%;display: inline; float: left">
            <img src="img/NGLogo.jpg" style="width: 40px; height: 40px;">
        </div>
        <div style="display: inline; float: left">
            <span style="font-size: 28px; font-weight: Bold; font-style: Italic">NextSchool<span style="font-style: normal"> <?= $value['name'] ?> </span></span><br>
        </div>
        <div>
            <span style="font-size: 28px"> <?= !empty($value['address'])?$value['address']:'-'?> <?= !empty($value['road'])?$value['road']:'-'?> <?=!empty($value['sub_district'])?$value['sub_district']:'-'?> <?=!empty($value['district'])?$value['district']:'-' ?></span><br>
            <span style="font-size: 28px"> <?=!empty($value['province'])?$value['province']:'-' ?>&nbsp;<?= !empty($value['zip_code'])?$value['zip_code']:'-'?>&nbsp; <?=  !empty($value['phone'])?"โทร.".$value['phone']:'-'?></span>
        </div>
    </div>
    <br>
    <div style="margin-left: 300px; margin-right: 80px; height: 150px">
        <p style="font-size: 26px; margin-top: 10px; font-weight: bold;">กรุณาส่ง <br>
            <span style="font-size: 28px; font-weight: normal"> <?= "อ.".$customer['name']?>&nbsp;<?= 'tel.'.$customer['phone'] ?><br></span>
            <?php if(!empty($customer['school_name'])):?>
            <span style="font-size: 28px; font-weight: normal" > <?= $customer['school_name'] ?>&nbsp; <br></span>
            <?php endif;?>
            <?php if(!empty($customer['address'])):?>
            <span style="font-size: 28px; font-weight: normal"> <?= $customer['address']?></span>
            <?php endif;?>
        </p>
    </div>
