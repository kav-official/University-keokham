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
                <h2>ບິນຂາຍສິນຄ້າ</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active la">
                        <strong>ບິນຂາຍສິນຄ້າ</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">
            </div>
        </div>

        <div class="wrapper wrapper-content">
          <div class="ibox float-e-margins">
             
            <div class="ibox-content">
              <div class="ibox-title text-center la" style="text-align: center;">
                <div class="print-header" style="display: flex; justify-content: space-between;">
                  <div class="item-right text-right">
                    <h3 style="font-family: Phetsarath OT" onclick="history.back()"><a class="btn btn-info"><< ກັບຄືນ</a></h3>
                  </div>
                </div>
              </div>
              <div class="table-responsive" id="DivIdToPrint">
                <table class="table table-striped table-bordered table-hover datatables-content">
                  <thead>
                    <tr>
                      <th class="la">ລຳດັບ</th>
                      <th class="la">ເລກບິນ</th>
                      <th class="la">ລາຍການ</th>
                      <th class="la">ປະເພດ</th>
                      <th class="la">ຈຳນວນ</th>
                      <th class="la">ລາຄາ</th>
                      <th class="la text-right">ລາຄາລວມ</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $ctr=0; foreach (($items?:[]) as $row): $ctr++; ?>
                    <tr id="item-<?= ($row['id']) ?>">
                      <td><?= ($ctr) ?> </td>
                      <td><?= ($row['bill_no']) ?> </td>
                      <td style="font-family: Phetsarath OT"><?= ($row['product_name']) ?> </td>
                      <td style="font-family: Phetsarath OT"><?= ($row['category']) ?> </td>
                      <td><?= ($row['qty']) ?> </td>
                      <td><?= (number_format($row['price'])) ?> </td>
                       <td class="text-right"><?= (number_format($row['price']*$row['qty'])) ?> </td>
                    </tr>
                  <?php endforeach; ?> 
                  <br>
                    <tr>
                      <td colspan="10" class="text-right" style="font-family: Phetsarath OT">ລວມລາຄາທັງໝົດ: <?= (number_format($item->total_amount)) ?> ກີບ</td>
                    </tr>       
                  </tbody>
                </table>
              </div>
            </div>
            <div class="btn-printer text-center" style="padding: 10px;">
                <button type="button" class="btn btn-success" onclick="printDiv()"> Print <i class="fa fa-print"></i></button>
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

