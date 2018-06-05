    <style>
        button.accordion {
            background-color: #eee;
            color: #444;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
            transition: 0.4s;
        }

        button.accordion.active, button.accordion:hover {
            background-color: #ccc; 
        }

        div.panel {
            padding: 0 18px;
            display: none;
            background-color: white;
        }
    </style>
    <section class="content_section">
        <div class="content_spacer">
            <div class="content">
                <div class="main_title centered upper">
                    <h2><span class="line"><i class="ico-users"></i></span><?php echo $title ?></h2>
                </div>
                <input type="hidden" name="loaddt" id="loaddt" value="mainapproval">
                <table id="tbl_group_akses" class="table table-striped" width="100%">
                    <thead>
                        <tr>
                            <th class="col-md-2">No. TOR</th>
                            <th class="col-md-2">Nama TOR</th>
                            <th class="col-md-2">NO PR</th>
                            <th class="col-md-2">Dibuat</th>
                            <th class="text-center">Action</th>
                        </tr>
                        <tr>
                          <th><input type="text" class="col-xs-12"></th>
                          <th><input type="text" class="col-xs-12"></th>
                          <th><input type="text" class="col-xs-12"></th>
                          <th><input type="text" class="col-xs-12"></th>
                          <th></th>
                      </tr>
                  </thead>
                  <tbody>
                  </tbody>
              </table>

          </div>
      </div>
  </section>

  <br>
  <br>
  <br>
  <br>
  <br>
  <br>