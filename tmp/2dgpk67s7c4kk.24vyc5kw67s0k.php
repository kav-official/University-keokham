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
          <div class="ibox float-e-margins">
            <div class="ibox-title la">
                <h5><?= ($strAction) ?></h5>
            </div>

            <div class="ibox-content">            
                <form class="form-horizontal la" id="submit-form" action="<?= ($BASE) ?>/product" method="<?= ($method) ?>">
                    <input type="hidden" name="id" value="<?= ($id ?? '') ?>">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="image">ຮູບພາບ</label>
                         <div class="col-sm-10">
                            <input type="file" accept="image/png, image/jpeg" class="form-control banner-image"><br>
                            <div class="banner-image-hidden">
                                <a href="<?= ($item->image ?? '') ?>" data-fancybox="gallery">
                                    <img src="<?= ($item->image ?? '') ?>" width="50">
                                </a>
                                <input type="hidden" name="image" value="<?= ($item->image ?? '') ?>">
                            </div>
                         </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">ບາໂຄດ</label>
                        <div class="col-sm-2" style="display: flex;">
                            <input name="barcode" type="text" class="form-control barcode" value="<?= ($item->barcode ?? '') ?>">
                            <button type="button" class="btn btn-success btn-barcode">ສ້າງບາໂຄດ</button>
                        </div>
                    </div>

                      <div class="form-group">
                        <label class="col-sm-2 control-label">ລະຫັດສິນຄ້າ</label>
                        <div class="col-sm-2">
                            <input name="product_no" type="text" class="form-control" value="<?= ($item->product_no ?? '') ?>">
                             <div class="error"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">ປະເພດສິນຄ້າ</label>
                        <div class="col-sm-10">
                            <select name="category_id" class="form-control">
                                <option value="">- select -</option>
                                <?= ($custom->renderArraySelect($arrCategory,$item->category_id ?? ''))."
" ?>
                            </select>
                             <div class="error"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">ຜູ້ສະໜອງ</label>
                        <div class="col-sm-10">
                            <select name="supplier_id" class="form-control">
                                <option value="">- select -</option>
                                <?= ($custom->renderArraySelect($arrSupplier,$item->supplier_id ?? ''))."
" ?>
                            </select>
                             <div class="error"></div>
                        </div>
                    </div>
                  
                    <div class="form-group">
                        <label class="col-sm-2 control-label">ຊື່ສິນຄ້າ</label>
                        <div class="col-sm-10">
                            <input name="name" type="text" class="form-control" value="<?= ($item->name ?? '') ?>">
                             <div class="error"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">ຈຳນວນ</label>
                        <div class="col-sm-10">
                            <input name="qty" type="number" class="form-control" value="<?= ($item->qty ?? '') ?>">
                             <div class="error"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">ລາຄາຊື້</label>
                        <div class="col-sm-10">
                            <input name="base_price" type="number" class="form-control" value="<?= ($item->base_price ?? '') ?>">
                             <div class="error"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">ລາຄາຂ່າຍ</label>
                        <div class="col-sm-10">
                            <input name="sale_price" type="number" class="form-control" value="<?= ($item->sale_price ?? '') ?>">
                             <div class="error"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">ວັນທີໝົດອາຍຸ</label>
                        <div class="col-sm-2">
                            <input name="date_expirt" type="date" class="form-control" value="<?= ($item->date_expirt ?? '') ?>">
                             <div class="error"></div>
                        </div>
                    </div>
                
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <button class="btn-sumit btn btn-primary la" type="submit">ບັນທືກ <i class="fa"></i></button>
                            <a class="btn btn-white ls" href="<?= ($BASE) ?>/product">ຍົກເລີກ</a>                                        
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
    $(document).on('click','.btn-barcode',function(){
        let barcode = Math.floor((Math.random() * 100000000000) + 1);
        $(this).closest('.form-group').find('.barcode').val(barcode);
    })
    
    $(document).on('change', '.banner-image',function(){
        var obj = $(this);
        var formData = new FormData();
        formData.append("banner",this.files[0]);
        $.ajax({
            url        : '<?= ($BASE) ?>/uploads/product',
            type       : 'POST',
            data       : formData,
            processData: false,
            contentType: false,
            success : function(data){
            obj.closest('div').find('.banner-image-hidden').remove();
            obj.after('<div class="banner-image-hidden"><a href="'+data.file_name+'" data-fancybox="gallery"><img src="'+data.file_name+'" width="50"></a><input type="hidden" name="image" value="'+data.file_name+'"></div>');
            }
        });
    });
    
    $(document).ready(function(){
        $('#submit-form').submit(function(e){
            var form = $(e.target);
            if(form.is("#submit-form")){ // check if this is the form that you want (delete this check to apply this to all forms)
                e.preventDefault();
                if ($("#submit-form").valid()) {
                    $.ajax({
                        type: form.attr("method"),            
                        url: form.attr("action"), 
                        data: form.serialize(), // serializes the form's elements.              
                        beforeSend: function() {
                         $("button.btn-sumit").prop('disabled', true);
                         $('button.btn-sumit').css('cursor','not-allowed');
                         $('button.btn-sumit i.fa').addClass( "fa-refresh fa-spin" );
                        },  
                        success: function(data) {
                            if (data.success == true) {
                                Swal.fire({
                                    title: "Success",
                                    icon: "success",
                                    text:data.message,
                                    confirmButtonColor: "#000000",
                                    confirmButtonText: "Yes,Ok",
                                }).then((result)=>{
                                    if(result.isConfirmed){
                                        window.location.href = '<?= ($BASE) ?>/product';
                                    }
                                });
                            } else {
                                Swal.fire("Error!", data.message, "error");
                                $('button.btn-sumit i.fa').removeClass( "fa-refresh fa-spin" );
                                $('button.btn-sumit').removeAttr('style');
                                $("button.btn-sumit").prop('disabled', false);
                            }
                        },
                        error: function () {
                            Swal.fire("Error!", "Error during proccessing!", "error");
                            $('button.btn-sumit i.fa').removeClass( "fa-refresh fa-spin" );
                            $('button.btn-sumit').removeAttr('style');
                            $("button.btn-sumit").prop('disabled', false);
                        },
                    });
                }
            }
        });

        $("#submit-form").validate({
            rules: {
                product_no: {
                    required: true
                },
                category_id: {
                    required: true
                },
                supplier_id: {
                    required: true
                },
                name: {
                    required: true
                },
                qty: {
                    required: true
                },
                base_price: {
                    required: true
                },
                sale_price: {
                    required: true
                },
                date_expirt: {
                    required: true
                },
            },
            messages: {
                product_no: {
                    required: "ກະລຸນາປ້ອນຂໍ້ມູນ.",
                },
                category_id: {
                    required: "ກະລຸນາປ້ອນຂໍ້ມູນ.",
                },
                name: {
                    required: "ກະລຸນາປ້ອນຂໍ້ມູນ.",
                },
                qty: {
                    required: "ກະລຸນາປ້ອນຂໍ້ມູນ.",
                },
                base_price: {
                    required: "ກະລຸນາປ້ອນຂໍ້ມູນ.",
                },
                sale_price: {
                    required: "ກະລຸນາປ້ອນຂໍ້ມູນ.",
                },
                date_expirt: {
                    required: "ກະລຸນາປ້ອນຂໍ້ມູນ.",
                },
            },
            errorPlacement: function(error, element) {
                error.appendTo(element.closest('div.form-group').find('div.error'));
            },
            success: function(label) {
                label.remove();
            },
            highlight: function(element, errorClass) {
                $(element).parent().next().find("." + errorClass).removeClass("checked");
            }
        });
    });
</script>
</body>
</html>

