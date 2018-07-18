
<?php
$path=\Yii::getAlias('@app'). DIRECTORY_SEPARATOR . 'file_print';
$files = glob($path.'/*.pdf', GLOB_BRACE);
?>
<div class="row">
    <div class="col-md-5">
        <H4>List file</H4>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <td>#</td>
                <td>name file</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($files as$k=>$file):?>
                <tr>
                    <td><?=$k+1?></td>
                    <td>
                        <?php echo  substr($file,39)?>
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <div class="col-md-7">
        <div class="container" id="app">
            <h4> List data firebase</h4>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>id</th>
                    <th>order_id</th>
                    <th>status</th>
                    <th>ma</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(model,index) in orderData">
                    <td>{{index+1}}</td>
                    <td>{{model.id}}</td>
                    <td>{{model.order_id}}</td>
                    <td>{{model.status}}</td>
                    <td><a href="#" @click="Reprint(model.id)" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-refresh"></i>Reprint</a></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


