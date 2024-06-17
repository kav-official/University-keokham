<?php
use \Mpdf\Mpdf;
class ExportController{
    private $f3,$Svr,$memSvr,$custom,$reSvr;
    function __construct(){
        $this->f3         = Base::instance();
        $this->db         = DBConfig::config();
        $this->custom     = new CustomFunctions();
        $this->productSvr = new ProductServices($this->db);
    }

    function productPDF(){
        $defaultConfig     = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs          = $defaultConfig['fontDir'];

        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData          = $defaultFontConfig['fontdata'];

        $mpdf = new \Mpdf\Mpdf([ 
            'fontDir' => array_merge($fontDirs, [
                __DIR__ . '../../../uploads/fonts',
            ]),
            'fontdata' => $fontData + [
                'Noto' => [
                    'R' => 'NotoSansLao_Condensed-Regular.ttf',
                    'B' => 'NotoSansLao_Condensed-Bold.ttf',
                ]
            ],
            'mode' => 'utf-8',
            'format' => 'A4',
            'use_unicode' => true,
            'default_font' => 'Noto'
        ]);

        $items = $this->productSvr->getSQL('SELECT tblproduct.*,tblcategory.name as category FROM tblproduct INNER JOIN tblcategory ON(tblproduct.category_id=tblcategory.id)',[]);
        $html = '<div style="text-align:center;"><h2>ລາຍງານຂໍ້ມູນຜູ້ໃຊ້ນ້ຳ</h2></div>';    
        $html .= '<table>
                    <thead>
                    <tr>
                      <th class="la">ລະຫັດສິນຄ້າ</th>
                      <th class="la">ປະເພດສິນຄ້າ</th>
                      <th class="la">ຜູ້ສະໜອງ</th>
                      <th class="la">ຊື່ສິນຄ້າ</th>
                      <th class="la">ຈຳນວນ</th>
                      <th class="la">ລາຄາຊື້</th>
                      <th class="la">ລາຄາຂ່າຍ</th>
                      <th class="la">ວັນທີໝົດອາຍຸ</th>
                      <th class="la">ວັນທີສ້າງ</th>
                    </tr>
                  </thead>
                  <tbody>
            ';

            foreach ($items as $row) {
                $html .= '
                <tr>
                      <td>'.$row['product_no'].'</td>
                      <td>'.$row['category_id'].'</td>
                      <td>'.$row['supplier_id'].'</td>
                      <td>'.$row['name'].'</td>
                      <td>'.$row['qty'].'</td>
                      <td>'.$row['base_price'].'</td>
                      <td>'.$row['sale_price'].'</td>
                      <td>'.$row['date_expirt'].'</td>
                      <td>'.$row['created_at'].'</td>
                </tr>  
                ';
            }
            $html .= '
                  </tbody>
                </table>';

        $mpdf->WriteHTML($html);
        $mpdf->Output('example.pdf', 'D');
    }
    function billPdf(){
        $mpdf = new \Mpdf\Mpdf([ 
            'mode' => 'utf-8',
            'format' => 'A4',
            'use_unicode' => true,
            'default_font' => 'phetsarath OT']);

        $items = $this->memSvr->getSQL("SELECT COUNT(tblinvoice.meter_id) AS month_count,SUM(meter_volume) AS total_volume,SUM(base_price) AS total_price,tblinvoice.meter_id,tblinvoice.date,tblinvoice.meter_volume,tblinvoice.base_price,tblregistermember.full_name 
        FROM tblinvoice INNER JOIN tblregistermember
        ON tblinvoice.member_id = tblregistermember.id
        WHERE tblinvoice.payment_methode = ? GROUP BY tblinvoice.member_id",[3]);

        // $html = '
        // <!DOCTYPE html>
        // <html lang="en">
        // <head>
        //   <title>Bootstrap Example</title>
        //   <meta charset="utf-8">
        //   <meta name="viewport" content="width=device-width, initial-scale=1">
        //   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        //   <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
        //   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        //   <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        // </head>
        // <body>
        // <div class="container">
        //   <h2>Bordered Table</h2>
        //   <p>The .table-bordered class adds borders on all sides of the table and the cells:</p>            
        //   <table class="table table-bordered">
        //     <thead>
        //       <tr>
        //         <th>Firstname</th>
        //         <th>Lastname</th>
        //         <th>Email</th>
        //       </tr>
        //     </thead>
        //     <tbody>
        //       <tr>
        //         <td>John</td>
        //         <td>Doe</td>
        //         <td>john@example.com</td>
        //       </tr>
        //       <tr>
        //         <td>Mary</td>
        //         <td>Moe</td>
        //         <td>mary@example.com</td>
        //       </tr>
        //       <tr>
        //         <td>July</td>
        //         <td>Dooley</td>
        //         <td>july@example.com</td>
        //       </tr>
        //     </tbody>
        //   </table>
        // </div>
        // </body>
        // </html>
        // ';
        $html = '<div style="text-align:center;"><h2>ລາຍງານຂໍ້ມູນຜູ້ໃຊ້ນ້ຳ</h2></div>';    
        $html .= '<table border="1" style="font-family: "Times New Roman", Times, serif;">
                    <thead>
                    <tr>
                      <th>ລະຫັດກົງເຕີ</th>
                      <th>ຊື່ຜູ້ໃຊ້ນ້ຳ</th>
                      <th>ບໍລິມາດນ້ຳໃຊ້ m³</th>
                      <th>ລວມຄ່ານ້ຳທັງໝົດ</th>
                      <th>ຈຳນວນເດືອນທີຄ້າງຈ່າຍ</th>
                    </tr>
                  </thead>
                  <tbody>
            ';

            foreach ($items as $row) {
                $html .= '
                <tr>
                      <td>'.$row['meter_id'].'</td>
                      <td>'.$row['full_name'].'</td>
                      <td>'.$row['total_volume'].'</td>
                      <td>'.$row['total_price'].'</td>
                      <td>'.$row['month_count'].'</td>
                </tr>  
                ';
            }
            $html .= '
                  </tbody>
                </table>';

        $mpdf->WriteHTML($html);
        $mpdf->Output('example.pdf', 'D');
    }

    function memberCsv(){
        $items = $this->memSvr->getAll([],[]);

        $fp = fopen('php://output', 'w');
        $header = array("Meter ID","Full Name","Identification Card","House Number","Unit","Phone","What'app","Date Created");
        fputcsv($fp, $header);
        foreach ($items as $row) {
            $arr = array(
                $row['meter_id'],
                $row['full_name'],
                $row['Identification_card'],
                $row['house_number'],
                $row['unit'],
                $row['phone'],
                $row['whats_app'],
                date('j M Y h:i:s A', $row["created_at"])
            );
            fputcsv($fp, $arr);
        }
        $filename = "register-member-" . date("YmdHis") . ".csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        exit();
    }
}

