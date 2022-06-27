
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <!-- <link rel="stylesheet" href="{{ public_path('dist/css/adminlte.min.css') }}"> -->
    <style>
      @page{
        margin: 0.5in 0.7in 0in 0.7in;
      }

      *{
        font-family: Arial, sans-serif;
      }

      .invoice-text{
        font-weight: 900;
        font-size: 25px;
        font-family: Arial, sans-serif;
      }
      .border-all{
        border:  4px solid black;
      }
      .border-top-4{
        border-top:  4px solid black;
      }
      .border-bottom-3{
        border-bottom:  3px solid black;
      }
      .border-bottom-4{
        border-bottom:  4px solid black;
      }
      .v-align-top{
        vertical-align: top;
      }
      .v-align-center{
        vertical-align: center;
      }
      .v-align-bottom{
        vertical-align: bottom;
      }
      .h-align-center{
        text-align: center;
      }
      .h-align-left{
        text-align: left;
      }
      .h-align-right{
        text-align: right;
      }
      .pl-10{
        padding-left: 10px;
      }
      th{
        font-weight: normal;
      }
      hr {
         width: 80%;
         height: 4px;
         border: 0 none;
         margin-right: 0;
         background-color:#000;
      }
      .ml-5{
        margin-left: 50px;
      }

      .fs-14{
        font-size: 14px;
      }
      *{
        font-size: 11px;
      }

      .font-weight-bold{
        font-weight: bold;
      }

body {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  /*background: #f0f0f0;*/
}
.box {
  position: relative;
  width: 100%;
  box-shadow: 0 0 15px rgba(0,0,0,.1);
}

/* common */
.ribbon {
  width: 150px;
  height: 150px;
  overflow: hidden;
  position: absolute;
}
.ribbon::before,
.ribbon::after {
  position: absolute;
  z-index: -1;
  content: '';
  display: block;
  border: 5px solid #2980b9;
}
.ribbon span {
  position: absolute;
  display: block;
  width: 225px;
  padding: 15px 0;
  background-color: #3498db;
  box-shadow: 0 5px 10px rgba(0,0,0,.1);
  color: #fff;
  font: 700 18px/1 'Lato', sans-serif;
  text-shadow: 0 1px 1px rgba(0,0,0,.2);
  text-transform: uppercase;
  text-align: center;
}
/* top right*/
.ribbon-top-right {
  top: -10px;
  right: -10px;
}
.ribbon-top-right::before,
.ribbon-top-right::after {
  border-top-color: transparent;
  border-right-color: transparent;
}
.ribbon-top-right::before {
  top: 0;
  left: 0;
}
.ribbon-top-right::after {
  bottom: 0;
  right: 0;
}
.ribbon-top-right span {
  left: -25px;
  top: 30px;
  transform: rotate(45deg);
}
.pr-10{
  padding-right: 100px;
}
.pt-4{
  padding-top: 40px;
}

.tanda-tangan
{
    display: inline-block;
    width: 200px;
    height: 100px;
    position: relative;
    background: url("{{ public_path('_images/tanda_tangan/' . $invoice->user->tanda_tangan) }}") no-repeat;
    background-size: 200px auto;

}
.tanda-tangan:after
{
    content: '';
    display: inline-block;
    position: absolute;
    width: 200px;
    height: 100px;
    background: url("{{ public_path('_images/cap.png') }}") no-repeat;
    background-size: 200px auto;
}


    </style>
  </head>
  <body>
   
    <div class="container">
      <div class="row justify-content-center">
        <table class="col-12" style="width: 100%;">
          <thead>
            <tr>
              <td colspan="3" style="padding-top: 25px"><span class="font-weight-bold">PT. Instanet Media Nusantara</span></td>
              <td colspan="2" rowspan="2" class="h-align-center v-align-center"><img class="mt-3 pt-4 pr-10" src="{{ public_path('_images/logo.png') }}" width="200"></td>
            </tr>
            <tr>
              <td colspan="3">
                <span>Villa Ilhami Asri Blok F-3</span><br>
                <span>Jalan Duyung No. 88 Pekanbaru</span><br>
                <span>Pekanbaru 28282, Indonesia</span><br>
                <span>Phone: (0761) 8657082</span><br>
                <a href="https://www.insta.net.id"><u>www.insta.net.id</u></a><br><br>
              </td>
            </tr>

            
          </thead>
          <tbody>
            <tr>
              <td colspan="3" class="border-bottom-3"><span class="invoice-text ml-2">INVOICE</span></td>
              <td colspan="2" class="border-bottom-3"><span class="font-weight-bold mr-5 pl-3">No. </span><span class="font-weight-bold ml-5" style="font-size: 14px;">{{ $reff }}</span></td>
            </tr>
            <tr>
              <td rowspan="3" class="v-align-top font-weight-bold border-bottom-3 pl-1">Kepada</td>
              <td colspan="2" rowspan="3" class="v-align-top font-weight-bold border-bottom-3 pl-3">{{ $invoice->transaction->client->sapaan }} {{ $invoice->transaction->client->nama }}</td>
              <td class="font-weight-bold pl-3" style="border-right-style: none;">Tanggal Invoice</td>
              <td>{{ idnDate(formatDate($invoice->invoice_date)) }}</td>
            </tr>
            <tr>
              <td class="font-weight-bold pl-3">Tanggal Jatuh Tempo</td>
              <td>{{ idnDate(formatDate($jatuhTempo)) }}</td>
            </tr>
            <tr>
              <td class="border-bottom-3 font-weight-bold pl-3">Periode Pemakaian</td>
              <td class="border-bottom-3">{{ idnDate(formatDate($invoice->start_date)) }} &mdash; {{ idnDate(formatDate($invoice->end_date)) }}</td>
            </tr>
            <tr>
              <td rowspan="3" class="v-align-top border-bottom-3 font-weight-bold pl-1">Alamat</td>
              <td colspan="2" rowspan="3" class="v-align-top border-bottom-3 pl-3">{{ $invoice->transaction->client->alamat }}</td>
              <td class="border-bottom-3 font-weight-bold pl-3">Perihal</td>
              <td class="border-bottom-3">Layanan {{ $invoice->transaction->service->nama }}</td>
            </tr>
            <tr>
              <td colspan="2" class="font-weight-bold pl-3">Pembayaran ditujukan kepada</td>
            </tr>
            <tr>
              <td class="font-weight-bold pl-3">Atas Nama</td>
              <td>Instanet Media Nusantara</td>
            </tr>
            <tr>
              <td class="font-weight-bold pl-1">Kontak</td>
              <td colspan="2" class="pl-3">{{ $invoice->transaction->client->telepon }}</td>
              <td class="font-weight-bold pl-3">Nama Bank</td>
              <td>Bank BCA Pekanbaru</td>
            </tr>
            <tr>
              <td class="border-bottom-3 font-weight-bold pl-1">Fax</td>
              <td colspan="2" class="border-bottom-3 pl-3">{{ $invoice->transaction->client->fax }}</td>
              <td class="border-bottom-3 font-weight-bold pl-3">No. Rekening</td>
              <td class="border-bottom-3">034-3249621</td>
            </tr>
            <tr>
              <td class="v-align-center h-align-center v-align-center border-bottom-4 py-2" width="8%">No</td>
              <td class="v-align-center border-bottom-4 h-align-center v-align-center" width="35%">Deskripsi</td>
              <td class="v-align-center border-bottom-4 h-align-center v-align-center" width="8%">Jumlah</td>
              <td class="v-align-center border-bottom-4 h-align-center v-align-center">Harga Satuan (Rp)</td>
              <td class="v-align-center border-bottom-4 h-align-center v-align-center">Jumlah Akhir (Rp)</td>
            </tr>
            <tr>
              <td class="v-align-center h-align-center pt-3 font-weight-bold">1</td>
              <td class="pt-3 font-weight-bold pl-3">{{ $invoice->transaction->service->service_category->nama}}</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td height="50px" class="v-align-top pl-3">{{ $invoice->transaction->service->nama }}</td>
              <td class="v-align-top h-align-center">1</td>
              <td class="v-align-top">
                <div class="d-flex flex-row justify-content-between">
                  <div class="ml-2">Rp {{ formatPrice($invoice->total_harga)}}</div>
                </div>
              </td>
              <td class="v-align-top">
                <div class="d-flex flex-row justify-content-between">
                  <div class="ml-2">Rp {{ formatPrice($invoice->total_harga)}}</div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2" rowspan="2" class="border-top-4 v-align-bottom h-align-left border-bottom-3 pl-1">Dalam Kata </td>
              <td class="border-top-4"></td>
              <td class="border-top-4 border-bottom-3 h-align-right"><span class="mr-4">Sub Total</span></td>
              <td class="border-top-4 border-bottom-3">
                <div class="d-flex flex-row justify-content-between">
                  <div class="ml-2">Rp {{ formatPrice($invoice->total_harga)}}</div>
                </div>
              </td>
            </tr>
            <tr>
              <td></td>
              <td class="border-bottom-3 h-align-right"><span class="mr-4">PPN 10%</span></td>
              <td class="border-bottom-3">
                <div class="d-flex flex-row justify-content-between">
                  <div class="ml-2">Rp {{ formatPrice(getPPN($invoice->total_harga))}}</div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2" rowspan="2" class="border-bottom-3 v-align-center" style="background-color: #dfdfdf;"><span class="font-weight-bold font-italic ml-3">{{ terbilang(getTotal($invoice->total_harga))}}</span></td>
              <td></td>
              <td class="border-bottom-3 h-align-right"><span class="mr-4 font-weight-bold">TOTAL TAGIHAN</span></td>
              <td class="border-bottom-3 font-weight-bold" style="background-color: #dfdfdf;">
                <div class="d-flex flex-row justify-content-between">
                  <div class="ml-2">Rp {{ formatPrice(getTotal($invoice->total_harga))}}</div>
                </div>
              </td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td colspan="2" class="v-align-bottom h-align-right" height="200px">
                <div class="tanda-tangan" style="padding-right: 30px;"></div>
                <hr>
              </td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td class="font-weight-bold fs-14 h-align-right">{{ $invoice->user->nama }}</td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td class="h-align-right">{{ $invoice->user->jabatan }}</td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td class="h-align-right">HP : {{ $invoice->user->telepon }}</td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td class="h-align-right">Email : <a href="mailto:{{ $invoice->user->email }}"><u>{{ $invoice->user->email}}</u></a></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->

  </body>
</html>
