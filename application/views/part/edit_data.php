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
    <a href="<?= base_url('part') ?>"><i class="fas fa-arrow-left"></i> Back</a>

    <?php if ($this->session->flashdata('success')) : ?>
        <div class="alert alert-success" role="alert">
            <?= $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>
    <div class="card my-2">
        <div class="card-body">
            <form action="<?= base_url('part/update'); ?>" method="post" id="form_part">
                <input type="hidden" name="id" value="<?= $part['id_part']; ?>">
                <div class="form-row">
                    <div class="form-group col-sm-4">
                        <label for="nama_part">Nama Part <font color="red">*</font></label>
                        <input class="form-control" type="text" name="nama_part" id="nama_part" placeholder="Nama Part" value="<?= $part['nama_part']; ?>" />
                        <span id="error_nama_part" class="text-danger"></span>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="kode_part">Kode Part <font color="red">*</font></label>
                        <input class="form-control" type="text" name="kode_part" id="kode_part" placeholder="Kode Part" value="<?= $part['kode_part']; ?>" />
                        <span id="error_kode_part" class="text-danger"></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm-4">
                        <label for="jenis_part">Jenis Part <font color="red">*</font></label>
                        <input class="form-control" type="text" name="jenis_part" id="jenis_part" placeholder="Jenis Part" value="<?= $part['jenis_part']; ?>" />
                        <span id="error_jenis_part" class="text-danger"></span>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="harga">Harga <font color="red">*</font></label>
                        <input class="form-control" type="text" name="harga" id="harga" placeholder="Harga" value="<?= $part['harga']; ?>" />
                        <span id="error_harga" class="text-danger"></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm-4">
                        <label for="stok">Stok <font color="red">*</font></label>
                        <input class="form-control" type="text" name="stok" id="stok" placeholder="Stok" value="<?= $part['stok']; ?>" />
                        <span id="error_stok" class="text-danger"></span>
                    </div>
                </div>
                <button class="btn btn-primary" type="button" name="update" id="update">Save</button>
            </form>

        </div>

        <div class="card-footer small text-muted">
            <font color="red">*</font> wajib diisi
        </div>

    </div>
</div>
</div>
<!-- /.container-fluid -->

<script>
    $(document).ready(function() {
        $('#update').click(function() {
            var error_nama_part = '';
            var error_kode_part = '';
            var error_jenis_part = '';
            var error_harga = '';
            var error_stok = '';

            if ($.trim($('#nama_part').val()).length == 0) {
                error_nama_part = 'Nama part wajib diisi';
                $('#error_nama_part').text(error_nama_part);
                $('#nama_part').addClass('has-error');
            } else {
                error_nama_part = '';
                $('#error_nama_part').text(error_nama_part);
                $('#nama_part').removeClass('has-error');
            }

            if ($.trim($('#kode_part').val()).length == 0) {
                error_kode_part = 'Kode part wajib diisi';
                $('#error_kode_part').text(error_kode_part);
                $('#kode_part').addClass('has-error');
            } else {
                error_kode_part = '';
                $('#error_kode_part').text(error_kode_part);
                $('#kode_part').removeClass('has-error');
            }

            if ($.trim($('#jenis_part').val()).length == 0) {
                error_jenis_part = 'Jenis part wajib diisi';
                $('#error_jenis_part').text(error_jenis_part);
                $('#jenis_part').addClass('has-error');
            } else {
                error_jenis_part = '';
                $('#error_jenis_part').text(error_jenis_part);
                $('#jenis_part').removeClass('has-error');
            }

            if ($.trim($('#harga').val()).length == 0) {
                error_harga = 'Harga wajib diisi';
                $('#error_harga').text(error_harga);
                $('#harga').addClass('has-error');
            } else {
                error_harga = '';
                $('#error_harga').text(error_harga);
                $('#harga').removeClass('has-error');
            }

            if ($.trim($('#stok').val()).length == 0) {
                error_stok = 'Stok wajib diisi';
                $('#error_stok').text(error_stok);
                $('#stok').addClass('has-error');
            } else {
                error_stok = '';
                $('#error_stok').text(error_stok);
                $('#stok').removeClass('has-error');
            }

            if (error_nama_part != '' || error_kode_part != '' || error_stok != '' || error_jenis_part != '' || error_harga != '') {
                return false;
            } else {
                $('#form_part').submit();
            }
        });
    });
</script>