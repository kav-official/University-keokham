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
          
            <div class="ibox-content">
                 <div class="ibox-title la">
                  <div class="row">
                      <div class="ibox-title la">
                        <a href="<?= ($BASE) ?>/report/sale?filter=day" class="btn btn-info">ລາຍງານຍອດຂາຍປະຈຳວັນ</a>
                        <a href="<?= ($BASE) ?>/report/sale?filter=month" class="btn btn-primary">ລາຍງານຍອດຂາຍປະຈຳເດືອນ</a>
                        <a href="<?= ($BASE) ?>/report/sale?filter=year" class="btn btn-warning">ລາຍງານຍອດຂາຍປະຈຳປີ</a>
                      </div>
                    <div class="text-rigth la text-right">
                      <a href="#" onclick="printDiv()" class="btn btn-success mr-3">Print ລາຍງານ</a>
                    </div>
                  </div>

                </div>
              <div class="table-responsive" id="DivIdToPrint">
                <table class="table table-striped table-bordered table-hover datatables-content" id="print-table">
                  <thead>
                    <tr>
                      <th class="la" style="font-family: Noto Sans Lao;">ລຳດັບ</th>
                      <th class="la" style="font-family: Noto Sans Lao;">ເລກທີບິນສັ່ງຊຶ້</th>
                      <th class="la" style="font-family: Noto Sans Lao;">ພະນັກງານຂາຍ</th>
                      <th class="la" style="font-family: Noto Sans Lao;">ປະເພດການຈ່າຍ</th>
                      <th class="la" style="font-family: Noto Sans Lao;">ຈຳນວນເງີນ</th>
                      <th class="la" style="font-family: Noto Sans Lao;">ວັນທີຂ່າຍ</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $ctr=0; foreach (($items?:[]) as $row): $ctr++; ?>
                    <tr id="item-<?= ($row['id']) ?>">
                      <td><?= ($ctr) ?> </td>
                      <td>
                        <a href="<?= ($BASE) ?>/report/bill/<?= ($row['bill_no']) ?>"><?= ($row['bill_no']) ?> </a>
                      </td>
                      <td><?= ($row['employee']) ?> </td>
                      <td><?= ($row['payment_type'] == 'Cash' ? 'ເງີນສົດ':'One Pay') ?> </td>
                      <td><?= ($row['total_amount']) ?> </td>
                      <td><?= (date('d/m/Y', strtotime($row['created_at']))) ?></td>
                    </tr>
                  <?php endforeach; ?>       
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
         <?php echo $this->render('backend/inc/footer.html',NULL,get_defined_vars(),0); ?>
      </div>
    </div>
  <?php echo $this->render('backend/inc/script.html',NULL,get_defined_vars(),0); ?>
    <script type="text/javascript">
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
          // var htmlTable = '' + '<style type="text/css">' 
            // + 'table {' + 'font-family: "Phetsarath OT"; margin-top:7px;font-size:12px' 
            // +'}#table{border-collapse: collapse;width: 100%;}#table td, #table th {border: 1px solid #ddd;padding: 0px 3px 0px 3px;}#table th { padding-top: 12px;padding-bottom: 12px;text-align: left;}</style>';
          var htmlTable = '' + '<style type="text/css">@font-face {font-family: "Phetsarath OT"; src: url("./../../uploads/fonts/Phetsarath OT.ttf");}table {font-family: "Phetsarath OT"; margin-top:7px;' +'}' + '#print-table,.print-table {border-collapse: collapse;width: 100%;}#print-table td, #print-table th,.print-table td,.print-table th {border: 1px solid #000000;padding-left: 3px;padding-right: 3px;}.bill-font{font-size: 17px;}</style>';
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

