
<img src="img/Color.png" width="70px" class="lor">
<div class="pagenum">
</div>
<div class="logo" >
    <img src="logo/nextgen.png">
</div>

<?php if ($dataItem->vat == true): ?>
    <p class="" style="margin-left: 410px; margin-top: -40px;font-size: 24px; font-weight: bold"><?='ใบกำกับภาษี / ใบเสร็จรับเงิน'?></p>
<?php else:; ?>
    <p class="" style="margin-left: 510px; margin-top: -60px;font-size: 24px; font-weight: bold"><?= 'ใบเสร็จรับเงิน' ?></p>
<?php endif; ?>
<p class="" style="margin-left:540px; font-size: 24px; font-weight: bold"><?= $pang; ?></p>

<div class="row" >
    <div class="col-xs-7">
        <div class="row" >
            <div class="col-xs-12" >
                <br>
                    <b ><?= !empty($company['name']) ? $company['name'] : '-' ?></b><br>
                    <p><?= !empty($company['address']) ? $company['address'] : ' ' ?> <?= !empty($company['road']) ? $company['road'] : ' ' ?>
                        <br>
                        <?= !empty($company['sub_district']) ? $company['sub_district'] : ' ' ?>
                        <?= !empty($company['district']) ? $company['district'] : ' ' ?>
                        <?= !empty($company['province']) ? $company['province'] : ' ' ?>
                        <?= !empty($company['zip_code']) ? $company['zip_code'] : ' ' ?>
                        <br>
                        โทร. <?= !empty($company['phone']) ? $company['phone'] : ' ' ?>
                        เลขประจำตัวผู้เสียภาษี. <?= !empty($company['tax_id']) ? $company['tax_id'] : ' ' ?>
                    </p>

                <b>ข้อมูลผู้สั่งซื้อ</b><br>
                <?php if(isset($customer)):?>
                    <div style="margin-top: 5px;">
                        <strong>ชื่อลูกค้า</strong> <?= !empty($customer['name']) ? $customer['name'] : '-' ?></div>
                    <div style="margin-top: 3px;">
                        <strong>ที่อยู่.&nbsp;
                            &nbsp;&nbsp;</strong><span <?php if(!empty($customer['school_name']))?>><?= !empty($customer['school_name']) ? $customer['school_name'] : '-' ?></span> <?= !empty($customer['address']) ? $customer['address'] : '-' ?></div>
                    <div style="margin-top: 3px;"><strong>เบอร์โทร. </strong> <?= !empty($customer['phone']) ? $customer['phone'] : '-' ?></div>
                    <div style="margin-top: 3px;"><strong>เลขประจำตัวผู้เสียภาษี </strong> <?= !empty($customer['bill_id']) ? $customer['bill_id'] : '-' ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-xs-4">
        <div style="border: 1px solid #ddd;margin-bottom: 5px"></div>
        <table width="100%" style="font-size: 14px; ">
            <tbody>
            <tr>
                <th>วันที่สั่งซื้อ</th>
                <td><?= $dataItem['order_date'] ?></td>
            </tr>
            <tr>
                <th>เลขที่ใบสั่งซื้อ</th>
                <td><?= $dataItem['bill_id'] ?></td>
            </tr>
            </tbody>
        </table>
        <div style="border: 1px solid #ddd;margin-top: 5px"></div>
    </div>
</div>