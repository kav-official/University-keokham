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
                <a href="<?= ($BASE) ?>/order"><h5><strong>ປະຫວັດການສັ່ງຊື້</strong></h5></a>
            </div>
            <div class="ibox-content">            
                <div class="form-group">
                    <label class="col-sm-1 control-label la">ບາໂຄດ</label>
                        <div class="col-sm-2" style="display: flex;">
                            <input name="barcode" type="number" ref="onFocus" @keyup.enter="getData" class="form-control">
                        </div>

                    <label class="col-sm-1 control-label"></label>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover datatables-content">
                        <thead>
                            <tr>
                            <th class="la">ຮູບສິນຄ້າ</th>
                            <th class="la">ລະຫັດສິນຄ້າ</th>
                            <th class="la">ຊື່ສິນຄ້າ</th>
                            <th class="la">ຈຳນວນ</th>
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
                                    <input type="number" :value="item.qty" @keyup.enter="addOrder(item.product_no,event.target.value)" class="form-control">
                                    </td> 
                                </tr>
                            </template>
                        </tbody>
                        </table>
                    </div>
                </div>
                <form id="order-form">
                  <div class="form-group text-center">
                  <button class="btn btn-info la" type="button" v-on:click="submitForm" v-if="viSible">ບັນທຶກການສັ່ງຊື້ <i class="fa fa-save"></i></button>
                  </div>
                    <div class="form-group">
                        <div id="DivIdToPrint">
                            <div class="table-responsive">
                                <div class="header-bill text-center la" id="viSible_bill_header">
                                    <div align="center" ><img src="<?= ($BASE) ?>/uploads/logo.png" width="100" style="font-family: Noto Sans Lao;" /></div>
                                    <h3 align="center" style="font-family: Noto Sans Lao;"><strong>ໃບແຈັງບິນສັ່ງຊື້</strong></h3>
                                    <h5 align="center" style="font-family: Noto Sans Lao;">ຮ້ານຂາຍເກີບຂອງຮ້ານ 35</h5>
                                </div>
                                <table class="table table-striped table-bordered table-hover datatables-content text-center">
                                <thead>
                                    <tr>
                                    <th class="la">ລຳດັບ</th>
                                    <th class="la">ລະຫັດສິນຄ້າ</th>
                                    <th class="la">ຊື່ສິນຄ້າ</th>
                                    <th class="la">ຈຳນວນ</th>
                                    <th class="la">ຈັດການ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template  v-for="(item,index) in tableData">
                                        <tr>
                                            <td>{{ index+1 }}</td> 
                                            <input type="hidden"name="product_no[]" v-bind:value="item.product_no">
                                            <input type="hidden"name="qty[]" v-bind:value="item.qty">
                                            <td>{{ item.product_no }}</td> 
                                            <td>{{ item.name }}</td> 
                                            <td>{{ item.qty }}</td> 
                                            <td>
                                                <button type="button" class="btn btn-danger" v-on:click="remove(item.product_no)"> <i class="fa fa-trash"></i></button>
                                            </td> 
                                        </tr>
                                    </template>
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
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
            viSible:true,
            order_no:'',
        },
        mounted(){
            this.onFocus();
            this.fetchOrder();
        },
        methods:{
            onFocus:function() {
                this.$refs.onFocus.focus();
            },

            getData:function(){
                axios.post('<?= ($BASE) ?>/order/data/'+event.target.value)
                .then((res)=>{
                    var data = res.data;
                    if(data.success){
                        this.items = data.data;
                    }else{
                        alert('fail response data');
                    }
                })
            },
            addOrder:function(product_no,qty){
                    axios.get('<?= ($BASE) ?>/order/add/'+product_no+'/'+qty)
                    .then((res)=>{
                        var data = res.data;
                        if(data.success){
                            this.fetchOrder();
                        }else{
                            alert('fail response data');
                        }
                    })
                },
        
             fetchOrder:function(){
                axios.get('<?= ($BASE) ?>/order/get/data')
                .then(res => {
                    var data       = res.data;
                    this.tableData = data.data;
                    // console.log(data);
                })
            },
            remove:function(product_no){
                axios.get('<?= ($BASE) ?>/order/remove/'+product_no)
                .then(res => {
                    var data = res.data;
                    if(data.success){
                        // console.log(data.data);
                        this.fetchOrder();
                    }
                })
            },
            submitForm:function(){
                axios.post('<?= ($BASE) ?>/order-action',$("#order-form").serialize())
                .then((response)=>{
                    var data = response.data;
                    if(data.success){
                        Swal.fire('ຂາຍສຳເລັດ',data.message,'success');
                        setTimeout(()=>{
                            this.fetchOrder();
                        },1000)
                    }else{
                        Swal.fire('Error','Some thing went wrong!','error');
                    }
                })
          },
        }
    })
</script>
 <script type="text/javascript">
        $(document).ready(function(){
            $("#viSible_bill_header").hide();
        });
        function show_bill_header(){
            $("#viSible_bill_header").show();
        }
        function printDiv() 
          {
    
            var data=document.getElementById("DivIdToPrint").innerHTML;
            var myWindow = window.open('', 'Bill','');
            myWindow.document.write('<html><head><title>Bill</title>');
            var htmlHeader = '' + '<style type="text/css">' 
              + 'table {' + 'font-family: "Phetsarath OT"; margin-top:7px;font-size:12px; border:1' 
              +'}#header{border-collapse: collapse;width: 100%;}#header td, #header th {padding: 0px 3px 0px 3px;}#header th { padding-top: 12px;padding-bottom: 12px;text-align: left;}</style>';
            var htmlContent = '' + '<style type="text/css">' 
              + 'table {' + 'font-family: "Phetsarath OT"; margin-top:7px;font-size:12px' 
              +'}#content{border-collapse: collapse;width: 100%;}#content td, #content th {padding: 0px 3px 0px 3px;}#content th { padding-top: 12px;padding-bottom: 12px;text-align: left;}</style>';
            var htmlTable = '' + '<style type="text/css">' 
              + 'table {' + 'font-family: "Phetsarath OT"; margin-top:7px;font-size:12px' 
              +'}#table{border-collapse: collapse;width: 100%;}#table td, #table th {border: 1px solid #ddd;padding: 0px 3px 0px 3px;}#table th { padding-top: 12px;padding-bottom: 12px;text-align: left;}</style>';
            myWindow.document.write('</head><body>');
            myWindow.document.write(data);
            myWindow.document.write('</body></html>');
            myWindow.document.write(htmlHeader);
            myWindow.document.write(htmlContent);
            myWindow.document.write(htmlTable);
            myWindow.document.close();

            myWindow.onload=function(){
                myWindow.focus();
                myWindow.print();
            };

          }
  </script>
</body>
</html>

