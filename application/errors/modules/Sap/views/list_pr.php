<section class="content_section">
    <div class="content_spacer">
        <div class="content">
            <div class="main_title centered upper">
                <h2><span class="line"><i class="ico-users"></i></span>Daftar Purchase Requisition</h2>
            </div>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <table id="pr-list-table" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor PR</th>
                                <th>Tipe</th>
                                <th>Plant</th>
                                <th class="col-md-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modal-detail">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Detail</h4>
            </div>
            <div class="modal-body">
                <div class="panel panel-default">
                    <div class="panel-heading">Purchase Requisition</div>
                    <table class="table table-hover">
                        <tr>
                            <td class="col-md-3">Nomor PR</td>
                            <td id="prno"></td>
                        </tr>
                        <tr>
                            <td>Tipe Dokumen</td>
                            <td id="doctype"></td>
                        </tr>
                        <tr>
                            <td>Plant</td>
                            <td id="plant"></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td id="realdate"></td>
                        </tr>
                    </table>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Material</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <th nowrap>No</th>
                                    <th nowrap>PR Item</th>
                                    <th nowrap>Kode Material</th>
                                    <th nowrap>Nama Material</th>
                                    <th nowrap>PO qty</th>
                                    <th nowrap>PR qty</th>
                                    <th nowrap>Gudang qty</th>
                                    <th nowrap>Ratagi</th>
                                    <th nowrap>Maxgi</th>
                                    <th nowrap>Lastgi</th>
                                </thead>
                                <tbody id="items_table">
                                    <tr>
                                        <td>1</td>
                                        <td>10</td>
                                        <td>Kodekodean</td>
                                        <td>Dummy</td>
                                        <td>10</td>
                                        <td>12</td>
                                        <td>13</td>
                                        <td>2.7</td>
                                        <td>3.1</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>