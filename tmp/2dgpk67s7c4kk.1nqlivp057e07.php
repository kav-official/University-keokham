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
        <div class="wrapper wrapper-content" id="app">
          <div class="row la">
            <div class="col-lg-12">
              <div class="ibox float-e-margins">
                <div class="ibox-content la">
                  <h1>ຍິນດີຕ້ອນຮັບ <strong><?= ($LOGON_USER_NAME) ?></strong> ສູ່ ລະບົບຈັດການ <?= ($SITE_NAME) ?></h1>
                </div>
              </div>
             </div>
            </div>
          </div>
         </div>
        </div>
       <?php echo $this->render('backend/inc/footer.html',NULL,get_defined_vars(),0); ?>
      </div>
    </div>
  <?php echo $this->render('backend/inc/script.html',NULL,get_defined_vars(),0); ?>
  <script type="text/javascript">
  </script>
</body>
</html>

