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
    <a href="<?= base_url('jasa_service') ?>"><i class="fas fa-arrow-left"></i> Back</a>

    <?php if ($this->session->flashdata('success')) : ?>
        <div class="alert alert-success" role="alert">
            <?= $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>
    <p></p>
    <div class="card my-2">
        <div class="card-body">
            <form action="<?= base_url('jasa_service/insert') ?>" method="post" id="form_jasa_service">
                <div class="form-row">
                    <div class="form-group col-sm-4">
                        <label for="nama_service">Nama Service <font color="red">*</font></label>
                        <input class="form-control" type="text" name="nama_service" id="nama_service" placeholder="Nama Service" />
                        <span id="error_nama_service" class="text-danger"></span>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="jenis_service">Jenis Service <font color="red">*</font></label>
                        <input class="form-control" type="text" name="jenis_service" id="jenis_service" placeholder="Jenis Service" />
                        <span id="error_jenis_service" class="text-danger"></span>
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="harga">Harga <font color="red">*</font></label>
                        <input class="form-control" type="text" name="harga" id="harga" placeholder="Harga" />
                        <span id="error_harga" class="text-danger"></span>
                    </div>
                </div>
                <button class="btn btn-primary" type=" button" name="insert" id="insert">Save</button>
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
        $('#insert').click(function() {
            var error_nama_service = '';
            var error_jenis_service = '';
            var error_harga = '';

            if ($.trim($('#nama_service').val()).length == 0) {
                error_nama_service = 'Nama service wajib diisi';
                $('#error_nama_service').text(error_nama_service);
                $('#nama_service').addClass('has-error');
            } else {
                error_nama_service = '';
                $('#error_nama_service').text(error_nama_service);
                $('#nama_service').removeClass('has-error');
            }

            if ($.trim($('#jenis_service').val()).length == 0) {
                error_jenis_service = 'Jenis service wajib diisi';
                $('#error_jenis_service').text(error_jenis_service);
                $('#jenis_service').addClass('has-error');
            } else {
                error_jenis_service = '';
                $('#error_jenis_service').text(error_jenis_service);
                $('#jenis_service').removeClass('has-error');
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

            if (error_nama_service != '' || error_jenis_service != '' || error_harga != '') {
                return false;
            } else {
                $('#form_jasa_service').submit();
            }
        });
    });
</script>