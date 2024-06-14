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
                        <strong><?= ($strAction) ?></strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">
            </div>
        </div>

        <div class="wrapper wrapper-content">
          <div class="ibox float-e-margins" id="app">
            <div class="ibox-title la">
                <h5><?= ($strAction) ?></h5>
            </div>
            <div class="ibox-content">            
                <form class="form-horizontal la">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">ບາໂຄດ</label>
                                <div class="col-sm-2" style="display: flex;">
                                    <input name="barcode" type="text" v-model="filter" v-on:keyup.enter="getData" class="form-control barcode">
                                </div>
                                <label class="col-sm-6 control-label"></label>
                            <label class="col-sm-2 control-label" style="text-decoration: underline;">OR-0011</label>
                        </div>
                
                        <div class="form-group">
                            <label class="col-sm-2 control-label">ຊື່ສິນຄ້າ</label>
                            <div class="col-sm-2">
                                <input name="name" type="text" class="form-control">
                            </div>
                            <label class="col-sm-1 control-label">ຈຳນວນ</label>
                            <div class="col-sm-2">
                                <input name="qty" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">ລາຄາຊື້</label>
                            <div class="col-sm-2">
                                <input name="base_price" type="text" class="form-control">
                            </div>

                            <label class="col-sm-1 control-label">ລາຄາຂ່າຍ</label>
                            <div class="col-sm-2">
                                <input name="sale_price" type="number" class="form-control">
                            </div>

                            <label class="col-sm-1 control-label">ວັນທີໝົດອາຍຸ</label>
                            <div class="col-sm-2">
                                <input name="date_expirt" type="number" class="form-control">
                            </div>
                        </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn-sumit btn btn-primary la" type="button">ເພີ່ມ <i class="fa"></i></button>                                   
                        </div>
                    </div>
                </form>
            </div>
            <!-- list of data -->
            <div class="ibox-content">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover datatables-content" id="data-table">
                  <thead>
                    <tr>
                      <th class="la">ລະຫັດສິນຄ້າ</th>
                      <th class="la">ຊື່ສິນຄ້າ</th>
                      <th class="la">ຈຳນວນ</th>
                      <th class="la">ລາຄາຂ່າຍ</th>
                      <th class="la">ວັນທີໝົດອາຍຸ</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in items">
                        <td>{{ item.product_no }}</td> 
                        <td>{{ item.name }}</td> 
                        <td>{{ item.qty }}</td> 
                        <td>{{ item.sale_price }}</td> 
                        <td>{{ item.date_expirt }}</td> 
                    </tr>
                  </tbody>
                </table>
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
            items:[]
        },
        mounted(){
            // this.getData();
        },
        methods:{
            getData:function(){
                axios.post('<?= ($BASE) ?>/order/data/'+event.target.value)
                .then((res)=>{
                    var data = res.data;
                    if(data.success){
                        this.items = data;
                        console.log(this.items);
                    }else{
                        console.log('fail response data');
                    }
                })
            },
        }
    })
</script>
</body>
</html>

