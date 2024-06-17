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
                        <strong>ຂາຍສີນຄ້າ</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">
            </div>
        </div>
        <div class="wrapper wrapper-content">
          <div class="ibox float-e-margins" id="app">
            <div class="ibox-title la" style="display: flex;justify-content: space-between;">
                <h5><strong>ຂາຍສີນຄ້າ</strong></h5>
                <a href="<?= ($BASE) ?>/sale"><h5><strong>ປະຫວັດການຂາຍ</strong></h5></a>
            </div>
            <form id="sale-form">  
            <div class="ibox-content">   
                    <div class="form-group">
                        <label class="col-sm-1 control-label la">ບາໂຄດ</label>
                        <input type="hidden" name="id" value="<?= ($id) ?>">
                        <div class="col-sm-2" style="display: flex;">
                            <input name="barcode" v-model="barcode" type="text" ref="onFocus" @keyup="addCart(event.target.value)" class="form-control">

                            <span class="col-sm-6 control-label">
                                <button class="btn btn-info la" v-on:click="submitForm" type="button">ບັນທຶກການສັ່ງຊື້ <i class="fa fa-save"></i></button>
                            </span>
                        </div>
                       
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover datatables-content">
                            <thead>
                                <tr style="background-color: aqua;">
                                    <th class="la">ລາຍການ</th>
                                    <th class="la">ປະເພດ</th>
                                    <th class="la">ຈຳນວນ</th>
                                    <th class="la">ລາຄາ</th>
                                    <th class="la text-right">ລວມລາຄາ</th>
                                    <th class="la text-center">ຈັດການ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template  v-for="(item,index) in items">
                                    <tr>
                                        <td>{{ item.product_name }}
                                        <input type="hidden"name="barcode[]" v-bind:value="item.barcode">
                                        <input type="hidden"name="product_name[]" v-bind:value="item.product_name">
                                        <input type="hidden"name="qty[]" v-bind:value="item.qty">
                                        <input type="hidden"name="category[]" v-bind:value="item.cate_name">
                                        <input type="hidden"name="price[]" v-bind:value="item.sale_price">
                                        </td> 
                                        <td>{{ item.cate_name }}</td> 
                                        <td><strong style="font-size: 18px;">{{ item.qty }}</strong></td> 
                                        <td>{{ item.sale_price }}</td> 
                                        <td class="text-right">
                                            {{ item.total_price }}
                                        </td>
                                        <td class="text-center" style="cursor: pointer;" v-on:click="remove(item.barcode)"><i class="fa fa-trash"></i></td>
                                    </tr>
                                </template>
                                    <tr v-if="items.length > 0">
                                        <td colspan="5" class="text-right">ລວມລາຄາ: {{ total_amount }}
                                            <input type="hidden"name="total_amount" v-bind:value="total_amount">
                                        </td>
                                    </tr>

                                <div style="display: flex;">
                                    <span class="col-sm-6 control-label"></span>
                                    <span class="col-sm-1 control-label">
                                        <input type="radio" id="Cash" checked value="Cash" name="payment_type">
                                        <label for="Cash" class="la"> ຈ່າຍສົດ</label>
                                    </span>
                                    <span class="col-sm-2 control-label">
                                        <input type="radio" id="One Pay" value="One Pay" name="payment_type">
                                        <label for="One Pay">One Pay</label>
                                    </span>
                                </div>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
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
            barcode:'',
            items:[],
            cart_count:0,
            total_amount:0,
        },
        mounted(){
            this.onFocus();
            this.fetchCart();
            this.cartCount();
        },
        methods:{
            onFocus:function() {
                this.$refs.onFocus.focus();
            },

            addCart:function(barcode){
                axios.get('<?= ($BASE) ?>/sale/add-to-cart/'+barcode)
                .then((res)=>{
                    var data = res.data;
                    if(data.success){
                        this.cart_count = data.cart_count;
                        this.barcode = '';
                        this.fetchCart();
                    }else{
                        alert('fail response data');
                    }
                })
            },

            fetchCart:function(){
                axios.get('<?= ($BASE) ?>/admin/cart')
                .then(res => {
                    var data            = res.data;
                    this.items          = data.data;
                    this.total_amount   = data.total_amount;
                    var self            = this;
                })
            },

	        cartCount:function(){
                axios.get('<?= ($BASE) ?>/admin/cart/count')
                .then(res => {
                    var data = res.data;
                    if(data.success){
                        this.cart_count = data.cart_count;
                    }
                })
            },

            remove:function(barcode){
                axios.get('<?= ($BASE) ?>/admin/cart/remove/'+barcode)
                .then(res => {
                    var data = res.data;
                    if(data.success){
                        this.fetchCart();
                    }
                })
            },

            submitForm:function(){
                    axios.post('<?= ($BASE) ?>/admin/sale-action',$("#sale-form").serialize())
                    .then((response)=>{
                        var data = response.data;
                        if(data.success){
                            Swal.fire('ຂາຍສຳເລັດ',data.message,'success');
                            this.fetchCart();
                            setTimeout(()=>{
                                window.location.href="<?= ($BASE) ?>/sale/bill/"+data.bill_no
                            },2000)
                            
                        }else{
                            Swal.fire('Error','Some thing went wrong!','error');
                        }
                    })
                },

        }
    })
</script>
</body>
</html>

