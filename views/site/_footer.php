
<div class="texttotal"> รวมทั้งสิ้น</div>
<div class="textprice"><?= number_format($Totaling, 2) ?> บาท</div>
<?php if ($dataItem['vat']==true): ?>
<div class="textvat"> ภาษีมูลค่าเพิ่ม 7 %</div>
<div class="textprice"><?= number_format($Totaling * 7/107, 2) ?> บาท</div>
<div class="textnotvat"> ราคาไม่รวมภาษีมูลค่าเพิ่ม</div>
<div class="textprice"><?= number_format($Totaling *100 /107, 2) ?> บาท</div>
<?php endif; ?>
<div class="textall"> รวมจำนวนเป็นเงิน</div>
<div class="textprice"><?= number_format($Totaling, 2) ?> บาท</div>
<div class="linefooter"></div>
<div class="asone"><?= $totalTH ?></div>

<div class="row" style="">
    <div class="col-xs-5">
        <p>&nbsp;</p>
    </div>
    <div class="col-xs-6">
    </div>
</div>
<table class="table" style="padding-top: 20px; font-size: 12px;">
    <tr>
        <td style="padding-left:30px;">.............................</td>
        <td style="padding-left:10px;">.............................</td>
        <td style="padding-left:180px;">.............................</td>
        <td style="padding-left:10px;">.............................</td>
    </tr>
    <tr>
        <td style="padding-left: 60px; padding-top: 5px;">ผู้จ่ายเงิน</td>
        <td style="padding-left: 50px; padding-top: 5px;">วันที่</td>
        <td style="padding-left: 210px; padding-top: 5px;">ผู้รับเงิน</td>
        <td style="padding-left: 50px; padding-top: 5px;">วันที่</td>
    </tr>
</table>
