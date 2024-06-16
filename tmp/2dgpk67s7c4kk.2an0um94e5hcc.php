<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ($SITE_NAME) ?></title>
    <?php echo $this->render('backend/inc/header.html',NULL,get_defined_vars(),0); ?>
</head>
<body class="md-skin">
    <div id="wrapper">
    <?php echo $this->render('backend/inc/nav.html',NULL,get_defined_vars(),0); ?>
        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
          <?php echo $this->render('backend/inc/topnav.html',NULL,get_defined_vars(),0); ?>
        </div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10 la">
                <h2><?= ($strPage) ?></h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active la">
                        <strong>ກວດຊອບສິນຄ້າ</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">
            </div>
        </div>
        <div class="wrapper wrapper-content">
          <div class="ibox float-e-margins" id="app">
            <div class="ibox-title la" style="display: flex;justify-content: space-between;">
                <h5><strong>ກວດຊອບສິນຄ້າ</strong></h5>
                <a href="<?= ($BASE) ?>/import"><h5><strong>ລາຍລະອຽດນຳເຂົ້າ</strong></h5></a>
            </div>
            <div class="ibox-content">            
                <div class="form-group">
                    <label class="col-sm-1 control-label la">ບາໂຄດ</label>
                        <div class="col-sm-2" style="display: flex;">
                            <input name="barcode" type="text" ref="onFocus" v-model="filter" v-on:keyup.enter="getData" class="form-control barcode">
                        </div>

                    <label class="col-sm-1 control-label"></label>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover datatables-content">
                        <thead>
                            <tr>
                            <th class="la">ຮູບສິນຄ້າ</th>
                            <th class="la">ລະຫັດສິນຄ້າ</th>
                            <th class="la">ຊື່ສິນຄ້າ</th>
                            <th class="la">ຈຳນວນທີຕ້ອງການນຳເຂົ້າສາງ</th>
                            <th class="la">ຜູ້ສະໜອງ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template  v-for="(item,index) in items">
                                <tr>
                                    <td>
                                        <img :src="item.image" width="120" alt="item.name">
                                    </td> 
                                    <td>{{ item.product_no }}</td> 
                                    <td>{{ item.name }}</td> 
                                    <td>
                                    <input type="text" :value="item.qty" v-on:keyup.enter="updateProductQTY(item.product_no)" class="form-control">
                                    </td> 
                                    <td>{{ item.supplier }}</td>
                                </tr>
                            </template>
                        </tbody>
                        </table>
                    </div>
                </div>
              
            </div>
        </div>
    </div>
</div>
 <?php echo $this->render('backend/inc/footer.html',NULL,get_defined_vars(),0); ?>
</div>
<?php echo $this->render('backend/inc/script.html',NULL,get_defined_vars(),0); ?>    
<script type="text/javascript">
    new Vue({
        el:'#app',
        data:{
            filter:'',
            items:[],
            tableData:[],
            viSible:false,
            order_no:'',
        },
        mounted(){
            this.onFocus();
        },
        methods:{
            onFocus:function() {
                this.$refs.onFocus.focus();
            },

            getData:function(){
                axios.post('<?= ($BASE) ?>/import/data/'+event.target.value)
                .then((res)=>{
                    var data = res.data;
                    if(data.success){
                        this.items = data.data;
                    }else{
                        alert('fail response data');
                    }
                })
            },
            updateProductQTY:function(product_no){
                const qty = event.target.value;
                    axios.post('<?= ($BASE) ?>/import/update/'+product_no+'/'+qty)
                    .then((res)=>{
                        var data = res.data;
                        if(data.success){
                            Swal.fire('Completed',data.message,'success');
                            this.items = [];
                        }else{
                            alert('fail response data');
                        }
                    })
                },
           }
    })
</script>
</body>
</html>

