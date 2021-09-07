<!-- Page Heading -->
<header class="bg-white mb-4" id="title">
    <div class="mx-auto py-4">
        <h5 class="font-semibold text-gray-800 pl-5">
            <?= $title ?>
        </h5>
    </div>
</header>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <a href="<?= base_url('service_order') ?>"><i class="fas fa-arrow-left"></i> Back</a>

    <?php if ($this->session->flashdata('success')) : ?>
        <div class="alert alert-success" role="alert">
            <?= $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>
    <p></p>
    <div class="card my-2">
        <div class="card-body">
            <form action="<?= base_url('service_order/update'); ?>" method="post" id="form_service_order">
                <input type="hidden" name="saran_approve" id="saran_approve" value="<?= $service_order['saran_approve']; ?>">
                <div class="form-row">
                    <div class="form-group col-sm-3">
                        <label for="no_order">No. Order <font color="red">*</font></label>
                        <input class="form-control" type="text" name="no_order" id="no_order" placeholder="No. Order" value="<?= $service_order['no_order'] ?>" />
                        <span id="error_no_order" class="text-danger"></span>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="nama_pemilik">Nama Pemilik <font color="red">*</font></label>
                        <input class="form-control" type="text" name="nama_pemilik" id="nama_pemilik" placeholder="Nama Pemilik" value="<?= $service_order['nama_pemilik'] ?>" />
                        <span id="error_nama_pemilik" class="text-danger"></span>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="nomor_plat">Nomor Plat <font color="red">*</font></label>
                        <input class="form-control" type="text" name="nomor_plat" id="nomor_plat" placeholder="Nomor Plat" value="<?= $service_order['nomor_plat'] ?>" />
                        <span id="error_nomor_plat" class="text-danger"></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm-3">
                        <label for="nomor_rangka">Nomor Rangka</label>
                        <input class="form-control" type="text" name="nomor_rangka" id="nomor_rangka" placeholder="Nomor Rangka" value="<?= $service_order['nomor_rangka'] ?>" />
                        <span id="error_nomor_rangka" class="text-danger"></span>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="tipe_mobil">Tipe Mobil</label>
                        <input class="form-control" type="text" name="tipe_mobil" id="tipe_mobil" placeholder="Tipe Mobil" value="<?= $service_order['tipe_mobil'] ?>" />
                        <span id="error_tipe_mobil" class="text-danger"></span>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="jasa_service">Jasa Service <font color="red">*</font></label>
                        <select class="custom-select custom-select-sm" name="jasa_service" id="jasa_service">
                            <option value="" hidden>Pilih jasa service</option>
                            <?php foreach ($jasa_service as $row) : ?>
                                <?php if ($row->id_jasa_service == $service_order['id_jasa_service']) : ?>
                                    <option value="<?= $row->id_jasa_service; ?>" selected><?= $row->nama_service; ?></option>
                                <?php else : ?>
                                    <option value="<?= $row->id_jasa_service; ?>"><?= $row->nama_service; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <span id="error_jasa_service" class="text-danger"></span>
                    </div>
                </div>
                <div class="my-3">
                    <strong>Tambahan yang disarankan</strong>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm-3">
                        <label for="part">Part</label>
                        <select class="custom-select custom-select-sm" name="part" id="part">
                            <option value="" hidden>Pilih Part</option>
                            <?php foreach ($parts as $row) : ?>
                                <?php if ($row->id_part == $service_order['id_part']) : ?>
                                    <option value="<?= $row->id_part; ?>" selected><?= $row->nama_part; ?></option>
                                <?php else : ?>
                                    <option value="<?= $row->id_part; ?>"><?= $row->nama_part; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <span id="error_part" class="text-danger"></span>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="harga">Harga</label>
                        <input class="form-control" type="text" name="harga" id="harga" placeholder="Harga" value="<?= $service_order['harga'] ?>" />
                        <span id="error_harga" class="text-danger"></span>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="jumlah">Jumlah</label>
                        <input class="form-control" type="text" name="jumlah" id="jumlah" placeholder="Jumlah" value="<?= $service_order['jumlah'] ?>" />
                        <span id="error_jumlah" class="text-danger"></span>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="ketersediaan">Ketersediaan</label>
                        <input class="form-control" type="text" id="ketersediaan" disabled />
                    </div>
                </div>
                <?php foreach ($jasa_service as $row) : ?>
                    <?php if ($row->id_jasa_service == $service_order['id_jasa_service']) : ?>
                        <input class="form-control" type="hidden" id="harga_jasa_service" value="<?= $row->harga ?>" />
                    <?php endif; ?>
                <?php endforeach; ?>
                <input class="form-control" type="hidden" name="total" id="total" value="<?= $service_order['total'] ?>" />
                <button class="btn btn-primary" type="button" name="insert" id="insert">Save</button>
            </form>
        </div>

        <div class="card-footer small text-muted">
            <font color="red">*</font> wajib diisi
        </div>

    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<script>
    $(document).ready(function() {
        $('#jasa_service').change(function() {
            var id = $(this).val();
            $.ajax({
                url: "<?= base_url('service_order/get_harga_jasa_service') ?>",
                method: "POST",
                data: {
                    id: id
                },
                async: true,
                dataType: 'JSON',
                success: function(data) {
                    var harga = data;
                    $('#harga_jasa_service').val(harga);
                }
            });
            return false;
        });

        $('#part').change(function() {
            var id = $(this).val();
            $.ajax({
                url: "<?= base_url('service_order/get_data_part') ?>",
                method: "POST",
                data: {
                    id: id
                },
                async: true,
                dataType: 'JSON',
                success: function(data) {
                    var harga = data[0]['harga'];
                    var stok = data[0]['stok'];

                    var ketersediaan = (stok <= 0) ? "Pesan" : "Ready Stock";

                    $('#harga').val(harga);
                    $('#ketersediaan').val(ketersediaan);
                }
            });
            return false;
        });

        $('#insert').click(function() {
            var error_no_order = '';
            var error_nama_pemilik = '';
            var error_nomor_plat = '';
            var error_jasa_service = '';

            if ($.trim($('#no_order').val()).length == 0) {
                error_no_order = 'No. order wajib diisi';
                $('#error_no_order').text(error_no_order);
                $('#no_order').addClass('has-error');
            } else {
                error_no_order = '';
                $('#error_no_order').text(error_no_order);
                $('#no_order').removeClass('has-error');
            }

            if ($.trim($('#nama_pemilik').val()).length == 0) {
                error_nama_pemilik = 'Nama Pemilik wajib diisi';
                $('#error_nama_pemilik').text(error_nama_pemilik);
                $('#nama_pemilik').addClass('has-error');
            } else {
                error_nama_pemilik = '';
                $('#error_nama_pemilik').text(error_nama_pemilik);
                $('#nama_pemilik').removeClass('has-error');
            }

            if ($.trim($('#nomor_plat').val()).length == 0) {
                error_nomor_plat = 'Nomor Plat wajib diisi';
                $('#error_nomor_plat').text(error_nomor_plat);
                $('#nomor_plat').addClass('has-error');
            } else {
                error_nomor_plat = '';
                $('#error_nomor_plat').text(error_nomor_plat);
                $('#nomor_plat').removeClass('has-error');
            }

            if ($.trim($('#jasa_service').val()).length == 0) {
                error_jasa_service = 'Jasa Service wajib diisi';
                $('#error_jasa_service').text(error_jasa_service);
                $('#jasa_service').addClass('has-error');
            } else {
                error_jasa_service = '';
                $('#error_jasa_service').text(error_jasa_service);
                $('#jasa_service').removeClass('has-error');
            }

            if (error_nama_pemilik != '' || error_no_order != '' || error_nomor_plat != '' || error_jasa_service != '') {
                return false;
            } else {
                var saran_approve = $('#saran_approve').val();
                var harga = $('#harga').val();
                var jumlah = $('#jumlah').val();
                var harga_jasa_service = $('#harga_jasa_service').val();
                var total = 0;

                if (saran_approve == 1) {
                    total = parseInt(harga_jasa_service) + (parseInt(harga) * parseInt(jumlah));
                    $('#total').val(total);
                } else {
                    total = harga_jasa_service;
                    $('#total').val(total);
                }
                debugger;
                $('#form_service_order').submit();
            }
        });
    });
</script>