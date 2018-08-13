
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
        <meta charset="utf-8">
        <title>Kusioner Survey Kepuasan Supplier <?=date("Y")?></title>
        <meta name="generator" content="Bootply" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description" content="Bootstrap  example." />
        <!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet"> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style type="text/css">
            .body-top {
                padding-top: 15px;
            }

            .body-bottom{
                padding-bottom: 100px;
            }  

            .tebal {
                font-weight: bold;
            }  
                
            .navbar-inverse {
            background-color: #f2545c;
            border-color: #f50000;
            }

            .navbar-inverse .navbar-nav>.active>a, .navbar-inverse .navbar-nav>.active>a:focus, .navbar-inverse .navbar-nav>.active>a:hover {
            color: #f2545c;
            background-color: #ffffff;
            }
            
            .navbar-inverse .navbar-nav>li>a {
            color: #ffffff;
            }
        </style>
            
        </style>
    </head>
    
    <!-- HTML code from Bootply.com editor -->
    
    <body >
    <div class="body-top"></div>
        <div class="container">
        <ul class="nav nav-tabs" style="display: none;">
            <li class="active"><a href="#tab1" data-toggle="tab">Shipping</a></li>
            <li><a href="#tab2" data-toggle="tab">Quantities</a></li>
            <li><a href="#tab3" data-toggle="tab">Summary</a></li>
            <li><a href="#tab4" data-toggle="tab">okla</a></li>
        </ul>
        <form id="data_kusioner" method="post" align="left">
        <div class="tab-content" id="content_change">
            <div class="tab-pane active" id="tab1">
             <fieldset style=" border: 2px groove #eaebed;padding:0 10px;border-radius:5px 5px 5px 5px;">
                <h4><b>I. Identitas Responden</b></h4>
                <p>Mohon isi identitas responden ini dengan kondisi responden yang sebenarnya.</p>
                        <div class="row">
                        <?php foreach($responden as $data_res){?>
                            <div class="col-sm-12">
                                    <div class="row">
                                            <div class="col-sm-6 form-group">
                                                 <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-building"></i></span>
                                                    <input type="text" readonly="" value="<?=$this->session->userdata['FULLNAME']?>" class="form-control" name="nm_perusahaan" placeholder="Nama Perusahaan">                                        
                                                 </div>
                                            </div>
                                            <div class="col-sm-6 form-group">
                                                 <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                    <input type="text" required class="form-control" name="nm" value="<?=$data_res['CONTACT_NAME']?>" placeholder="Nama">
                                                 </div>
                                            </div>
                                    </div>    
                            </div>
                            <div class="col-sm-12">
                                    <div class="row">
                                            <div class="col-sm-6 form-group">
                                                 <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-user-o"></i></span>
                                                    <input type="text" required class="form-control" name="umur" placeholder="Umur">                                        
                                                 </div>
                                            </div>
                                            <div class="col-sm-6 form-group">
                                                 <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-venus-mars"></i></span>
                                                    <select required class="form-control" name="jns_kel" id="jns_kel">
                                                        <option value="">-- Jenis Kelamin --</option>
                                                        <option value="Laki-Laki">Laki-Laki</option>
                                                        <option value="Perempuan">Perempuan</option>
                                                    </select>                                        
                                                 </div>
                                            </div>
                                    </div>    
                            </div>
                            <div class="col-sm-12">
                                    <div class="row">
                                            <div class="col-sm-6 form-group">
                                                 <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                                    <input type="text" required class="form-control" name="alamat" value="<?=$data_res['ADDRESS_STREET']?>" placeholder="Alamat">                                        
                                                 </div>
                                            </div>
                                            <div class="col-sm-6 form-group">
                                                 <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-diamond"></i></span>
                                                    <input type="text" required class="form-control" name="jabatan" value="<?=$data_res['CONTACT_POS']?>" placeholder="Jabatan">                                      
                                                 </div>
                                            </div>
                                    </div>    
                            </div>
                        </div> 
                        <?php } ?>
             </fieldset>
                <br>
                <a class="btn btn-success btnNext" ><i class="fa fa-check-circle" aria-hidden="true"></i> Mulai Kusioner</a>
            </div>
            <div class="tab-pane body-bottom" id="tab2">
            <fieldset style=" border: 2px groove #eaebed;padding:0 10px;border-radius:5px 5px 5px 5px;">
                <h4><b>II. Kusioner Tingkat Kepuasan</b></h4>
                <p><b>a. Pertanyaan menyangkut Kebijakan Sistem Proses Pengadaan.</b></p>
                    <div class="col-sm-12">
                            <div class="row ask2a">
                                    <div class="col-sm-1 form-group" align="right">1.</div>
                                    <div class="col-sm-7 form-group">
                                         <div class="input-group">
                                            <p>Apakah menurut Bpk/Ibu sistem proses pengadaan di PT.Semen Tonasa sudah sesuai dengan yang diharapkan ?</p>                                        
                                         </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                         <div class="input-group">
                                             <label class="tebal"><input type="radio" name="a1" value="P"> Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="a1" value="CP"> Cukup Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="a1" value="KP"> Kurang Puas</label>
                                         </div>
                                    </div>
                            </div>    
                    </div>
                    <div class="col-sm-12">
                    <div class="row ask2a">
                                    <div class="col-sm-1 form-group" align="right">2.</div>
                                    <div class="col-sm-7 form-group">
                                         <div class="input-group">
                                            <p>Bagaimanakah transparansi PT. Semen Tonasa dalam melakukan proses tender ke Supplier ?</p>                                        
                                         </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                         <div class="input-group">
                                             <label class="tebal"><input type="radio" name="a2" value="P"> Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="a2" value="CP"> Cukup Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="a2" value="KP"> Kurang Puas</label>
                                         </div>
                                    </div>
                            </div>    
                    </div>
                    <div class="col-sm-12">
                            <div class="row ask2a">
                                    <div class="col-sm-1 form-group" align="right">3.</div>
                                    <div class="col-sm-7 form-group">
                                         <div class="input-group">
                                            <p>Bagaimanakah fairness rate (tingkat keadilan) dalam proses pengadaan terhadap Supplier PT. Semen Tonasa ?</p>                                        
                                         </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                         <div class="input-group">
                                             <label class="tebal"><input type="radio" name="a3" value="P"> Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="a3" value="CP"> Cukup Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="a3" value="KP"> Kurang Puas</label>
                                         </div>
                                    </div>
                            </div>    
                    </div>
                    <div class="col-sm-12">
                            <div class="row ask2a">
                                    <div class="col-sm-1 form-group" align="right">4.</div>
                                    <div class="col-sm-7 form-group">
                                         <div class="input-group">
                                            <p>Apakah menurut Bpk/Ibu PT. Semen Tonasa sudah tepat mengundang  Supplier dalam hal kemampuan supply material ?</p>                                        
                                         </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                         <div class="input-group">
                                             <label class="tebal"><input type="radio" name="a4" value="P"> Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="a4" value="CP"> Cukup Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="a4" value="KP"> Kurang Puas</label>
                                         </div>
                                    </div>
                            </div>    
                    </div>
                    <div class="col-sm-12">
                            <div class="row ask2a">
                                    <div class="col-sm-1 form-group" align="right">5.</div>
                                    <div class="col-sm-7 form-group">
                                         <div class="input-group">
                                            <p>Apakah menurut Bpk/Ibu PT. Semen Tonasa sudah menjalankan kewajibannya dengan baik sebagai mitra kerja Supplier ?</p>                                        
                                         </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                         <div class="input-group">
                                             <label class="tebal"><input type="radio" name="a5" value="P"> Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="a5" value="CP"> Cukup Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="a5" value="KP"> Kurang Puas</label>
                                         </div>
                                    </div>
                            </div>    
                    </div>
                    <div class="col-sm-12">
                            <div class="row ask2a">
                                    <div class="col-sm-1 form-group" align="right">6.</div>
                                    <div class="col-sm-7 form-group">
                                         <div class="input-group">
                                            <p>Apakah Bpk/Ibu puas dalam melakukan handling kebijakan dalam proses sistem pengadaan ?</p>                                        
                                         </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                         <div class="input-group">
                                             <label class="tebal"><input type="radio" name="a6" value="P"> Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="a6" value="CP"> Cukup Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="a6" value="KP"> Kurang Puas</label>
                                         </div>
                                    </div>
                            </div>    
                    </div>
                    <div class="col-sm-12">
                            <div class="row ask2a">
                                    <div class="col-sm-1 form-group" align="right">7.</div>
                                    <div class="col-sm-7 form-group">
                                         <div class="input-group">
                                            <p>Puaskah Bpk/Ibu terhadap keputusan/kebijakan PT. Semen Tonasa dalam mengatur/menentukan waktu setiap sesi dalam proses sistem pengadaan ?</p>                                        
                                         </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                         <div class="input-group">
                                             <label class="tebal"><input type="radio" name="a7" value="P"> Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="a7" value="CP"> Cukup Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="a7" value="KP"> Kurang Puas</label>
                                         </div>
                                    </div>
                            </div>    
                    </div>
                    <div class="col-sm-12">
                            <div class="row ask2a">
                                    <div class="col-sm-1 form-group" align="right">8.</div>
                                    <div class="col-sm-7 form-group">
                                         <div class="input-group">
                                            <p>Puaskah Bpk/Ibu terhadap keotentikan data kelola PT. Semen Tonasa dalam proses sistem pengadaan ?</p>                                        
                                         </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                         <div class="input-group">
                                             <label class="tebal"><input type="radio" name="a8" value="P"> Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="a8" value="CP"> Cukup Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="a8" value="KP"> Kurang Puas</label>
                                         </div>
                                    </div>
                            </div>    
                    </div>
                    <div class="col-sm-12">
                            <div class="row ask2a">
                                    <div class="col-sm-1 form-group" align="right">9.</div>
                                    <div class="col-sm-7 form-group">
                                         <div class="input-group">
                                            <p>Apakah Bpk/Ibu puas dengan waktu dari awal hingga proses akhir dalam penyelesaian tender (terbit PO) dalam proses sistem pengadaan ?</p>                                        
                                         </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                         <div class="input-group">
                                             <label class="tebal"><input type="radio" name="a9" value="P"> Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="a9" value="CP"> Cukup Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="a9" value="KP"> Kurang Puas</label>
                                         </div>
                                    </div>
                            </div>    
                    </div>
                    <div class="col-sm-12">
                            <div class="row ask2a">
                                    <div class="col-sm-1 form-group" align="right">10.</div>
                                    <div class="col-sm-7 form-group">
                                         <div class="input-group">
                                            <p>Puaskah Bpk/Ibu terhadap kebijakan PT. Semen Tonasa dalam ketepatan prosedur standar dalam proses sistem pengadaan ?</p>                                        
                                         </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                         <div class="input-group">
                                             <label class="tebal"><input type="radio" name="a10" value="P"> Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="a10" value="CP"> Cukup Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="a10" value="KP"> Kurang Puas</label>
                                         </div>
                                    </div>
                            </div>    
                    </div>            
            </fieldset>
            <br>
                <a class="btn btn-primary btnPrevious" ><i class="fa fa-backward" aria-hidden="true"></i> Previous</a>
                <a class="btn btn-primary btnNext2" check><i class="fa fa-forward" aria-hidden="true"></i> Next</a>
            <br><br>
            </div>
            <div class="tab-pane body-bottom" id="tab3">
            <fieldset style=" border: 2px groove #eaebed;padding:0 10px;border-radius:5px 5px 5px 5px;">
                <p><b>b. Sistem Informasi Teknologi (IT).</b></p>
                <div class="col-sm-12">
                        <div class="row ask2b">
                                        <div class="col-sm-1 form-group" align="right">1.</div>
                                        <div class="col-sm-7 form-group">
                                             <div class="input-group">
                                                <p>Puaskah Bapak/Ibu terhadap informasi mengenai proses sistem pengadaan yang diberikan oleh  PT. Semen Tonasa terhadap Supplier ?</p>                                        
                                             </div>
                                        </div>
                                        <div class="col-sm-4 form-group">
                                             <div class="input-group">
                                                 <label class="tebal"><input type="radio" name="b1" value="P"> Puas</label>&nbsp;&nbsp;
                                                 <label class="tebal"><input type="radio" name="b1" value="CP"> Cukup Puas</label>&nbsp;&nbsp;
                                                 <label class="tebal"><input type="radio" name="b1" value="KP"> Kurang Puas</label>
                                             </div>
                                        </div>
                                </div>    
                        </div>
                        <div class="col-sm-12">
                                <div class="row ask2b">
                                        <div class="col-sm-1 form-group" align="right">2.</div>
                                        <div class="col-sm-7 form-group">
                                             <div class="input-group">
                                                <p>Puaskah Bapak/Ibu terhadap metode sistem informasi yang dijalankan dalam proses sistem pengadaan oleh PT. Semen Tonasa ?</p>                                        
                                             </div>
                                        </div>
                                        <div class="col-sm-4 form-group">
                                             <div class="input-group">
                                                 <label class="tebal"><input type="radio" name="b2" value="P"> Puas</label>&nbsp;&nbsp;
                                                 <label class="tebal"><input type="radio" name="b2" value="CP"> Cukup Puas</label>&nbsp;&nbsp;
                                                 <label class="tebal"><input type="radio" name="b2" value="KP"> Kurang Puas</label>
                                             </div>
                                        </div>
                                </div>    
                        </div>
                        <div class="col-sm-12">
                                <div class="row ask2b">
                                        <div class="col-sm-1 form-group" align="right">3.</div>
                                        <div class="col-sm-7 form-group">
                                             <div class="input-group">
                                                <p>Apakah menurut Bapak/Ibu sistem Informasi Teknologi yang diterapkan dalam proses sistem pengadaan sangat membantu Supplier dalam memcahkan masalah ?</p>                                        
                                             </div>
                                        </div>
                                        <div class="col-sm-4 form-group">
                                             <div class="input-group">
                                                 <label class="tebal"><input type="radio" name="b3" value="P"> Puas</label>&nbsp;&nbsp;
                                                 <label class="tebal"><input type="radio" name="b3" value="CP"> Cukup Puas</label>&nbsp;&nbsp;
                                                 <label class="tebal"><input type="radio" name="b3" value="KP"> Kurang Puas</label>
                                             </div>
                                        </div>
                                </div>    
                        </div>
                        <div class="col-sm-12">
                                <div class="row ask2b">
                                        <div class="col-sm-1 form-group" align="right">4.</div>
                                        <div class="col-sm-7 form-group">
                                             <div class="input-group">
                                                <p>Bagaimanakah tingkat kepuasan Bpk./Ibu terhadap kehandalan sistem proses pengadaan di PT. Semen Tonasa ?</p>                                        
                                             </div>
                                        </div>
                                        <div class="col-sm-4 form-group">
                                             <div class="input-group">
                                                 <label class="tebal"><input type="radio" name="b4" value="P"> Puas</label>&nbsp;&nbsp;
                                                 <label class="tebal"><input type="radio" name="b4" value="CP"> Cukup Puas</label>&nbsp;&nbsp;
                                                 <label class="tebal"><input type="radio" name="b4" value="KP"> Kurang Puas</label>
                                             </div>
                                        </div>
                    </div>    
            </div>
            <div class="col-sm-12">
                    <div class="row ask2b">
                            <div class="col-sm-1 form-group" align="right">5.</div>
                            <div class="col-sm-7 form-group">
                                 <div class="input-group">
                                    <p>Puaskah Bapak/Ibu terhadap sarana prasarana yang telah ada dalam proses sistem pengadaan di PT. Semen Tonasa ?</p>                                        
                                 </div>
                            </div>
                            <div class="col-sm-4 form-group">
                                 <div class="input-group">
                                     <label class="tebal"><input type="radio" name="b5" value="P"> Puas</label>&nbsp;&nbsp;
                                     <label class="tebal"><input type="radio" name="b5" value="CP"> Cukup Puas</label>&nbsp;&nbsp;
                                     <label class="tebal"><input type="radio" name="b5" value="KP"> Kurang Puas</label>
                                 </div>
                            </div>
                    </div>    
            </div>
            </fieldset>
                <br>
                <a class="btn btn-primary btnPrevious" ><i class="fa fa-backward" aria-hidden="true"></i> Previous</a>
                <a class="btn btn-primary btnNext3" ><i class="fa fa-forward" aria-hidden="true"></i> Next</a>
                <br><br>
            </div>
            <div class="tab-pane body-bottom" id="tab4">
                <fieldset style=" border: 2px groove #eaebed;padding:0 10px;border-radius:5px 5px 5px 5px;">
                    <p><b>c. Pelayanan & Komunikasi dengan Supplier.</b></p>
                        <div class="col-sm-12">
                            <div class="row ask2c">
                                    <div class="col-sm-1 form-group" align="right">1.</div>
                                    <div class="col-sm-7 form-group">
                                         <div class="input-group">
                                            <p>Sejauh manakah kepuasan Bapak/Ibu terhadap pelayanan/service yang dilakukan PT. Semen Tonasa terhadap Supplier ?</p>                                        
                                         </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                         <div class="input-group">
                                             <label class="tebal"><input type="radio" name="c1" value="P"> Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="c1" value="CP"> Cukup Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="c1" value="KP"> Kurang Puas</label>
                                         </div>
                                    </div>
                            </div>    
                    </div>
                    <div class="col-sm-12">
                            <div class="row ask2c">
                                    <div class="col-sm-1 form-group" align="right">2.</div>
                                    <div class="col-sm-7 form-group">
                                         <div class="input-group">
                                            <p>Puaskah Bapak/Ibu terhadap penanganan masalah Supplier yang dilakukan oleh pihak Dept. Pengadaan & Pengelolaan Persediaan ?</p>                                        
                                         </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                         <div class="input-group">
                                             <label class="tebal"><input type="radio" name="c2" value="P"> Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="c2" value="CP"> Cukup Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="c2" value="KP"> Kurang Puas</label>
                                         </div>
                                    </div>
                            </div>    
                    </div>
                    <div class="col-sm-12">
                            <div class="row ask2c">
                                    <div class="col-sm-1 form-group" align="right">3.</div>
                                    <div class="col-sm-7 form-group">
                                         <div class="input-group">
                                            <p>Apakah pelayanan SDM sangat membantu Vendor/Supplier dalam memecahkan masalah ?</p>                                        
                                         </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                         <div class="input-group">
                                             <label class="tebal"><input type="radio" name="c3" value="P"> Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="c3" value="CP"> Cukup Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="c3" value="KP"> Kurang Puas</label>
                                         </div>
                                    </div>
                            </div>    
                    </div>
                    <div class="col-sm-12">
                            <div class="row ask2c">
                                    <div class="col-sm-1 form-group" align="right">4.</div>
                                    <div class="col-sm-7 form-group">
                                         <div class="input-group">
                                            <p>Puaskah Bapak/Ibu terkait efisiensi waktu dalam proses sistem pengadaan di PT. Semen Tonasa ?</p>                                        
                                         </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                         <div class="input-group">
                                             <label class="tebal"><input type="radio" name="c4" value="P"> Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="c4" value="CP"> Cukup Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="c4" value="KP"> Kurang Puas</label>
                                         </div>
                                    </div>
                            </div>    
                    </div>
                    <div class="col-sm-12">
                            <div class="row ask2c">
                                    <div class="col-sm-1 form-group" align="right">5.</div>
                                    <div class="col-sm-7 form-group">
                                         <div class="input-group">
                                            <p>Puaskah Bapak/Ibu terhadap komunikasi yang telah diterapkan dalam proses sistem pengadaan di PT. Semen Tonasa ?</p>                                        
                                         </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                         <div class="input-group">
                                             <label class="tebal"><input type="radio" name="c5" value="P"> Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="c5" value="CP"> Cukup Puas</label>&nbsp;&nbsp;
                                             <label class="tebal"><input type="radio" name="c5" value="KP"> Kurang Puas</label>
                                         </div>
                                    </div>
                            </div>    
                    </div>
                </fieldset>
                <br>
                <a class="btn btn-primary btnPrevious" ><i class="fa fa-backward" aria-hidden="true"></i> Previous</a>
                <a class="btn btn-success btnSave" ><i class="fa fa-check-square-o" aria-hidden="true"></i> Finish</a>
                <br><br>
            </div>
        </div>
        </form>
        </div>
        
        <!-- <script type='text/javascript' src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <script type='text/javascript' src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script> -->
        <script type='text/javascript'>
        $(document).ready(function() {
            $('.btnNext').click(function(){
                var result = $("#tab1 input[required]").filter(function () {
                                    return $.trim($(this).val()).length == 0
                                  }).length == 0;

                                  console.log(result);
                $('input[required]').each(function() {
                    if ($.trim($(this).val()) == '') {
                        result = false;
                        $(this).css({
                            "border": "1px solid red",
                            "background": "#FFCECE"
                        });
                    }
                    else {
                        $(this).css({
                            "border": "",
                            "background": ""
                        });
                    }
                });

                  if (result==true) {
                        if($('#jns_kel').val()==''){
                            alert("jenis kelamin belum dipilih");
                            $('#jns_kel').css({
                                                "border": "1px solid red",
                                                "background": "#FFCECE"
                                            });
                        }else{
                            $('#jns_kel').css({
                                                "border": "",
                                                "background": ""
                                            });
                            $('.nav-tabs > .active').next('li').find('a').trigger('click');
                        }
                  }
             });

            $('.btnNext2').click(function(){
                var $questions = $(".ask2a");
                    if($questions.find("input:radio:checked").length === $questions.length) {
                        $('.nav-tabs > .active').next('li').find('a').trigger('click');
                    }
                    else {
                        alert($questions.length - $questions.find("input:radio:checked").length+" Pertanyaan belum terisi");
                    }
            });

            $('.btnNext3').click(function(){
                var $questions = $(".ask2b");
                    if($questions.find("input:radio:checked").length === $questions.length) {
                        $('.nav-tabs > .active').next('li').find('a').trigger('click');
                    }
                    else {
                        alert($questions.length - $questions.find("input:radio:checked").length+" Pertanyaan belum terisi");
                    }
            });

            $('.btnPrevious').click(function(){
                  $('.nav-tabs > .active').prev('li').find('a').trigger('click');
                });
        
            });

            $('.btnSave').click(function(){
                var $questions = $(".ask2c");
                    if($questions.find("input:radio:checked").length === $questions.length) {
                    
                    $('.btnSave').text('Saving...').attr('disabled','disabled'); //change button text
                    var dataString = new FormData( $("#data_kusioner")[0] );
                    var html1 = '<span><img width="100" height="auto" src="<?php echo base_url();?>static/images/loading.gif"></span> <h1>Please Wait...</h1>';

                    $.ajax({type: "POST",
                           url: "<?=  base_url();?>index.php/Kusioner/save_form",
                           data: dataString,
                           dataType: "JSON",
                           async : false,
                            cache : false,
                            contentType : false,
                            processData : false,
                           success: function(data){
                                    if(data.status) //if success close modal and reload ajax table
                                 {
                                     $("#content_change").html(html1).load("<?=  base_url();?>index.php/Kusioner/success");
                                 }
                                 else
                                 {
                                     alert('Terjadi Kesalahan !');
                                     $('.btnSave').html('<i class="fa fa-check-square-o" aria-hidden="true"></i> Finish').removeAttr('disabled'); //change button text
                                 }
                           }
                 
                         });
                         return false;  //stop the actual form post !important!
                  } else {
                        alert($questions.length - $questions.find("input:radio:checked").length+" Pertanyaan belum terisi");
                    }
                });
        </script>        
    </body>
</html> 