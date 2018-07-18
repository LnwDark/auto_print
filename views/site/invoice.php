
<!--<img src="http://gdurl.com/5fgT" width="70px" class="lor">-->

<table class="table " width="100%" style="font-size: 14px;">
    <thead>
    <tr>
        <th class=" text-center">#</th>
        <th class="col-xs-6 text-left">ชื่อ-นามสกุล</th>
        <th class="col-xs-2 text-left">ชั้น / ห้อง</th>
        <th class="col-xs-2 text-right">จำนวน</th>
        <th class="col-xs-2 text-right">ราคา</th>
    </tr>
    </thead>
    <tbody>

    <?php
    for ($i = $start; $i <= $end; $i++):
        ?>
        <tr style="border-top:none; ">
            <td class="text-center"><?= $i + 1 ?></td>
            <td><?= $model[$i]['name'] ?></td>
            <td><?= $model[$i]['class'] ?></td>
            <td class="text-right"><?= $model[$i]['amount'] ?></td>
            <td class="text-right"><?= $model[$i]['price'] ?></td>
        </tr>
    <?php endfor; ?>
    </tbody>
</table>




