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
                  <h5><?= ($strAction) ?> (<?= ($entrycount) ?>)</h5>
              </div>
            <div class="ibox-content">
              <div class="ibox-title text-right la">
                <a href="<?= ($BASE) ?>/sale/edit" class="btn btn-success">ຂາຍສິນຄ້າ</a>
              </div>
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover datatables-content">
                  <thead>
                    <tr>
                      <th class="la">ລຳດັບ</th>
                      <th class="la">ເລກບິນ</th>
                      <th class="la">ພະນັກງານຂ່າຍ</th>
                      <th class="la">ຈຳນວນເງີນ</th>
                      <th class="la">ຈ່າຍດ້ວຍ</th>
                      <th class="la">ວັນທີສ້າງ</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $ctr=0; foreach (($items?:[]) as $row): $ctr++; ?>
                    <tr id="item-<?= ($row['id']) ?>">
                      <td><?= ($ctr) ?> </td>
                      <td>
                        <a href="<?= ($BASE) ?>/sale/bill/<?= ($row['bill_no']) ?>"><?= ($row['bill_no']) ?></a>
                      </td>
                      <td><?= ($row['employee'] ?? '-') ?> </td>
                      <td><?= ($row['total_amount']) ?> </td>
                      <td>
                        <?php if ($row['payment_type'] == 'Cash'): ?>
                          ເງີນສົດ
                          <?php else: ?>One Pay
                        <?php endif; ?>
                      </td>
                      <td><?= (date('d/m/Y H:i:s A', strtotime($row['created_at']))) ?></td>
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
</body>
</html>

