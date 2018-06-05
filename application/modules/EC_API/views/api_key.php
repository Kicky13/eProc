<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>REST Server Tests</title>
    <link rel="stylesheet" href="<?php echo base_url() ?>static/css/bootstrap.css" />
    <style>

    ::selection { background-color: #E13300; color: white; }
    ::-moz-selection { background-color: #E13300; color: white; }

    body {
        background-color: #FFF;
        margin: 40px;
        font: 16px/20px normal Helvetica, Arial, sans-serif;
        color: #4F5155;
        word-wrap: break-word;
    }

    a {
        color: #039;
        background-color: transparent;
        font-weight: normal;
    }

    h1 {
        color: #444;
        background-color: transparent;
        border-bottom: 1px solid #D0D0D0;
        font-size: 24px;
        font-weight: normal;
        margin: 0 0 14px 0;
        padding: 14px 15px 10px 15px;
    }

    code {
        font-family: Consolas, Monaco, Courier New, Courier, monospace;
        font-size: 16px;
        background-color: #f9f9f9;
        border: 1px solid #D0D0D0;
        color: #002166;
        display: block;
        margin: 14px 0 14px 0;
        padding: 12px 10px 12px 10px;
    }

    #body {
        margin: 0 15px 0 15px;
    }

    p.footer {
        text-align: right;
        font-size: 16px;
        border-top: 1px solid #D0D0D0;
        line-height: 32px;
        padding: 0 10px 0 10px;
        margin: 20px 0 0 0;
    }

    #container {
        margin: 10px;
        border: 1px solid #D0D0D0;
        box-shadow: 0 0 8px #D0D0D0;
    }
    </style>
    <script type="text/javascript" src="<?php echo base_url() ?>static/js/jquery.js"></script>
</head>
<body>

<div id="container">
    <h1>
      List API Key
      <span class="btn btn-primary pull-right" data-url="<?php echo site_url('EC_API/Key/index')?>" onclick="App.addKey(this)" >Add Keys</span>
    </h1>

    <div id="body">
    <?php
      if(!empty($keys)){
    ?>
      <table class="table table-bordered">
        <thead>
          <tr>
          <?php
            $_header = $keys[0];
            foreach($_header as $_k => $_val){
              echo '<th>'.$_k.'</th>';
            }
          ?>
          <th>AKSI</th>
        </tr>
        </thead>
        <tbody>
          <?php
            foreach($keys as $key){
              echo '<tr>';
              foreach($key as $_k => $_val){
                echo '<td class="'.$_k.'">'.$_val.'</td>';
              }
              echo '<td><span class="btn btn-danger" data-url="'.site_url('EC_API/Key/index').'" onclick="App.removeKey(this)">Hapus</span></td>';
              echo '</tr>';
            }
          ?>
        </tbody>
      </table>
    <?php
    }else{
      echo 'API Key belum tersedia';
    }
    ?>
    </div>
</div>
</body>
<script type="text/javascript">
  var _username = 'admin';
  var _password = '1234';
  var App = {
    removeKey : function(elm){
      /* jika jumlah baris <= 1, gak boleh menghapus */
      var _trs = $('#body tbody>tr');
      var _jmlKey = _trs.length;
      var _confirm = confirm('Apakah anda yakin akan menghapus key ini ?');
      if(_confirm){
        if(_jmlKey > 1 ){
          var _tr = $(elm).closest('tr');
          var _key = _tr.find('td.KEY_API').text();
          $.ajax({
            url : $(elm).data('url'),
            data : {key : _key },
            type : 'DELETE',
            beforeSend: function (xhr) {
                xhr.setRequestHeader ("Authorization", "Basic " + btoa(_username + ":" + _password));
            },
            headers: {
              'X-API-KEY' : _key
            },

            success : function(){
              _tr.remove();
            },
            dataType : 'json'
          });

        }else{
          alert('Tidak boleh menghapus, key hanya 1');
        }  
      }

    },
    addKey : function(elm){
      var _key = $('#body tbody>tr:first>td.KEY_API').text();
      $.ajax({
        url : $(elm).data('url'),
        type : 'PUT',
        beforeSend: function (xhr) {
            xhr.setRequestHeader ("Authorization", "Basic " + btoa(_username + ":" + _password));
        },
        headers: {
          'X-API-KEY' : _key
        },

        success : function(data){
          if(data.status){
            alert(data.key + 'berhasil dibuat ');
            window.location.reload();
          }
        },
        dataType : 'json'
      });
    }
  };
</script>
</html>
