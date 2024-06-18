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
        $help   = new HelpFunctions();
        $cateArr=[];
        $suppArr=[];

        $category = $help->getSQL("SELECT * FROM tblcategory",[]);
        foreach ($category as $value) {
            $cateArr[$value['id']] = $value['name'];
        }
        $supplier = $help->getSQL("SELECT * FROM tblsupplyer",[]);
        foreach ($supplier as $value) {
            $suppArr[$value['id']] = $value['name'];
        }

        $mpdf = new \Mpdf\Mpdf([ 
            'mode' => 'utf-8',
            'format' => 'A4',
            'use_unicode' => true,
            'default_font' => 'Noto'
        ]);

        $items = $help->getSQL('SELECT tblproduct.*,tblcategory.name as category FROM tblproduct INNER JOIN tblcategory ON(tblproduct.category_id=tblcategory.id)',[]);
        $html = '<div style="text-align:center;"><h2 style="font-family:Phetsarath OT">ລາຍງານຂໍ້ມູນສິນຄ້າ</h2></div>';    
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
                      <td>'.$cateArr[$row['category_id']].'</td>
                      <td>'.$suppArr[$row['supplier_id']].'</td>
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
    function expirtPDF(){
        $help   = new HelpFunctions();
        $cateArr = [];

        $category = $help->getSQL("SELECT * FROM tblcategory",[]);
        foreach ($category as $value) {
            $cateArr[$value['id']] = $value['name'];
        }

        $mpdf = new \Mpdf\Mpdf([ 
            'mode' => 'utf-8',
            'format' => 'A4',
            'use_unicode' => true,
            'default_font' => 'phetsarath OT']);

       $items = $help->getSQL('SELECT tblproduct.*,tblcategory.name as category FROM tblproduct INNER JOIN tblcategory ON(tblproduct.category_id=tblcategory.id) WHERE date_expirt <= ?',[date('Y-m-d')]);

        $html = '<div style="text-align:center;"><h2>ລາຍງານຂໍ້ມູນສິນຄ້າໝົດອາຍຸ</h2></div>';    
        $html .= '<table border="1" style="font-family: "Times New Roman", Times, serif;">
                    <thead>
                    <tr>
                      <th class="la">ລະຫັດສິນຄ້າ</th>
                      <th class="la">ປະເພດສິນຄ້າ</th>
                      <th class="la">ຊື່ສິນຄ້າ</th>
                      <th class="la">ຈຳນວນ</th>
                      <th class="la">ລາຄາຊື້</th>
                      <th class="la">ລາຄາຂ່າຍ</th>
                      <th class="la">ວັນທີໝົດອາຍຸ</th>
                    </tr>
                  </thead>
                  <tbody>
            ';

            foreach ($items as $row) {
                $html .= '
                <tr>
                    <td>'.$row['product_no'].'</td>
                      <td>'.$cateArr[$row['category_id']].'</td>
                      <td>'.$row['name'].'</td>
                      <td>'.$row['qty'].'</td>
                      <td>'.$row['base_price'].'</td>
                      <td>'.$row['sale_price'].'</td>
                      <td>'.date('d/m/Y',strtotime($row['date_expirt'])).'</td>
                </tr>  
                ';
            }
            $html .= '
                  </tbody>
                </table>';

        $mpdf->WriteHTML($html);
        $mpdf->Output('example.pdf', 'D');
    }
    function orderPDF(){
        $help   = new HelpFunctions();
        $cateArr=[];

        $category = $help->getSQL("SELECT * FROM tblcategory",[]);
        foreach ($category as $value) {
            $cateArr[$value['id']] = $value['name'];
        }

        $mpdf = new \Mpdf\Mpdf([ 
            'mode' => 'utf-8',
            'format' => 'A4',
            'use_unicode' => true,
            'default_font' => 'phetsarath OT']);

       $items = $help->getSQL("SELECT tblproduct.*,tblorder.*,tblcategory.id as category_name FROM tblproduct INNER JOIN tblorder ON(tblproduct.product_no=tblorder.product_no) INNER JOIN tblcategory ON (tblproduct.category_id=tblcategory.id)",[]);

        $html = '<div style="text-align:center;"><h2>ລາຍງານຂໍ້ມູນສັ່ງຊື້ສິນຄ້າ</h2></div>';    
        $html .= '<table border="1" style="font-family: "Times New Roman", Times, serif;">
                    <thead>
                    <tr>
                      <th class="la" style="font-family: Noto Sans Lao;">ເລກທີບິນສັ່ງຊຶ້</th>
                      <th class="la" style="font-family: Noto Sans Lao;">ລະຫັດສິນຄ້າ</th>
                      <th class="la" style="font-family: Noto Sans Lao;">ປະເພດສິນຄ້າ</th>
                      <th class="la" style="font-family: Noto Sans Lao;">ຊື່ສິນຄ້າ</th>
                      <th class="la" style="font-family: Noto Sans Lao;">ຈຳນວນ</th>
                      <th class="la" style="font-family: Noto Sans Lao;">ລາຄາຊື້</th>
                      <th class="la" style="font-family: Noto Sans Lao;">ລາຄາຂ່າຍ</th>
                      <th class="la" style="font-family: Noto Sans Lao;">ວັນທີສັ່ງຊື້</th>
                    </tr>
                  </thead>
                  <tbody>
            ';

            foreach ($items as $row) {
                $html .= '
                <tr>
                    <td>'.$row['order_no'].'</td>
                    <td>'.$row['product_no'].'</td>
                    <td>'.$cateArr[$row['category_id']].'</td>
                    <td>'.$row['name'].'</td>
                    <td>'.$row['total_qty'].'</td>
                    <td>'.$row['base_price'].'</td>
                    <td>'.$row['sale_price'].'</td>
                    <td>'.date('d/m/Y',strtotime($row['date'])).'</td>
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

