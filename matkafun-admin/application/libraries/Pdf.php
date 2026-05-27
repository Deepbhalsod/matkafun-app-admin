<?php
defined('BASEPATH') or exit('No direct script access allowed');
file_exists(APPPATH . 'third_party\tcpdf\tcpdf.php') and require_once APPPATH . 'third_party\tcpdf\tcpdf.php';
file_exists(APPPATH . 'third_party/tcpdf/tcpdf.php') and require_once APPPATH . 'third_party/tcpdf/tcpdf.php';

/** Genrating PDF using `TCPDF` */
class Pdf extends TCPDF
{
    public function __construct()
    {
        parent::__construct();
    }

    public function createPDF($orderNum)
    {

        // Define Sender Or Compony Details
        $logo_url = "https://trevon.com/fe/images/trevon-Logo.png";
        $componyName = ucwords("Team Trevon");

        $senderName = ucwords('Taruna Mathur');
        $senderMail = 'taruna.tws@gmail.com';
        $senderAddr = 'House no. 42, Kethunipole';
        $senderAddr2 = 'Kota, Rajasthan 324006';

        // Define User Details
        $userName = ucwords('Demo User');
        $userMail = 'Demo@user.com';
        $userAddr = 'FGDS sd dxFSD s df';
        $userAddr2 = 'Kota, Rajasthan 324006';

        $array = [
            [
                'name' => 'oppo',
                'qty' => 1,
                'price' => 1000
            ],
            [
                'name' => 'Samsung',
                'qty' => 2,
                'price' => 10000
            ],
            [
                'name' => 'Nokia',
                'qty' => 3,
                'price' => 1000
            ],
            [
                'name' => 'oppo',
                'qty' => 1,
                'price' => 1000
            ]
        ];

        $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);

        // set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetAuthor($componyName);
        $pdf->SetTitle('Invoice #' . $orderNum);
        $pdf->SetSubject('Order Received');
        $pdf->SetKeywords('TCPDF, PDF, INVOICE');
        // add a page
        $pdf->AddPage();
        $productRow = '';
        $price = '';
        foreach ($array as $key => $data) {
            $productRow .= "<tr><td>" . $data['name'] . "</td><td>" . $data['qty'] . "</td><td>" . $this->price_formate($data['price']) . "</td><td>" . $this->price_formate($data['qty'] * $data['price']) . "</td></tr>";
            $price += $data['qty'] * $data['price'];
        }
        $tbl = '<style>* {margin: 0;padding: 0;box-sizing: border-box;line-height: 1.6;font-family: sans-serif;color: #3a4161;}a,p,h4,span,td {font-size: 14px}.grid {display: grid;}.place-base {align-self: flex-end;}.col-2 {grid-template: "left right"1fr;}.w-75 {width: 75%;}.head>td {font-weight: bold;font-size: 22px;}.text-dark {font-weight: bolder;color: #3a416150;}.mt-3 {margin-top: 15%;}.mt-1 {margin-top: 5%;}.center {margin-left: auto;margin-right: auto;}.text-right {text-align: right;}img {width: 250px;}</style><table style="width: 100%; margin: 0 auto;" align="center"><tr><td><img style="align-self:center" src="' . $logo_url . '" alt="" /></td><td><div style="text-align: right"><span class="text-dark">FROM</span><h4>' . $senderName . '</h4> <span>' . $senderMail . '</span> <br /> <span>' . $senderAddr . ',<br /> ' . $senderAddr2 . '</span></div></td></tr><tr><td style="text-align: left"><h1 style="margin:0;padding:0">Invoice #' . $orderNum . '</h1><h3 style="margin:0;padding:0">Your Order is Recived Successfully</h3></td><td><div class="" style="text-align: right"> <span class="text-dark">BILL TO</span><h4>' . $userName . '</h4> <span>' . $userMail . '</span> <br /> <span>' . $userAddr . ',<br /> ' . $userAddr2 . '</span></div></td></tr></table><hr class="w-75 center"><p style="padding: 5%;text-align: justify;">Your Shipping ETA applies from the time you receive that email, Which should be about one working day from now.We\'ll follow up as quickly as possible!</p><div class="grid center" style="padding: 0 5%"><table border="1" align="center"><tr class="head" bgcolor="#efefef"><td>Product Name</td><td>QTY</td><td>Rate</td><td>Amount</td></tr>' . $productRow . '</table><table border="1" align="center"><tr bgcolor="#efefef"><td colspan="3"><h2>Payment Method</h2></td><td><h3>COD</h3></td></tr><tr bgcolor="#efefef"><td colspan="3"><h2>Total</h2></td><td><h2>' . $this->price_formate($price) . '</h2></td></tr></table><div style="margin-top:2px"><h2>Thanks,</h2><h3 style="margin-top:2px">' . $componyName . '</h3></div></div>';
        $pdf->writeHTML($tbl, true, false, false, false, '');

        file_exists(SITE_DIR . 'uploads/invoice/') or mkdir(SITE_DIR . 'uploads/invoice/', 0777, true);
        $pdf->Output(SITE_DIR . 'uploads/invoice/' . 'invoice-' . $orderNum . '.pdf', 'FI');
    }

    public function price_formate($price)
    {
        $price =  str_replace('.00', '', number_format($price, 2, '.', ','));
        $price = explode('.', $price);
        return $price[0];
    }
}

/* End of file Pdf.php */