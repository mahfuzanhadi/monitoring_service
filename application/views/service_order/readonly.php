<script type="text/javascript">
    function approve_saran(id) {
        bootbox.confirm("Anda yakin ingin approve saran ini?", function(result) {
            if (result)
                $.ajax({
                    url: "<?= base_url('service_order/approve_saran/'); ?>" + id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        bootbox.alert("Saran berhasil di-approve!", function() {
                            location.reload();
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        bootbox.alert('Gagal approve saran!');
                    }
                });
        });
    }
</script>

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

    <?php if ($this->session->flashdata('flash')) : ?>
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Service order <strong>berhasil</strong> <?= $this->session->flashdata('flash'); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- DataTables -->
    <div class="card mb-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="dataTable" width="100%">
                    <thead>
                        <tr>
                            <th>No. Order</th>
                            <th>Nama Pemilik</th>
                            <th>Nomor Plat</th>
                            <th>Nomor Rangka</th>
                            <th>Tipe Mobil</th>
                            <th>Jasa Service</th>
                            <th>Saran</th>
                            <th>Approve Saran</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        var dataTable = $('#dataTable').DataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "dom": 'Bfrtip',
            "buttons": [{
                extend: 'print',
                title: 'Service Order',
                customize: function(doc) {
                    $(doc.document.body).find('h1').css('font-size', '36pt');
                    $(doc.document.body).find('h1').css('text-align', 'center');
                },
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 8]
                }
            }],
            "scrollX": true,
            "scrollCollapse": true,
            "order": [],
            "lengthMenu": [10, 20, 50],
            "ajax": {
                url: "<?= base_url('service_order/fetch_data'); ?>",
                type: "POST"
            },
            "columnDefs": [{
                    "targets": [5, 9],
                    "orderable": false
                },
                {
                    "targets": 9,
                    "visible": false
                },
                {
                    "width": "100px",
                    "targets": 0
                },
                {
                    "width": "150px",
                    "targets": 1
                },
                {
                    "width": "92px",
                    "targets": 2
                },
                {
                    "width": "120px",
                    "targets": 3
                },
                {
                    "width": "100px",
                    "targets": 4
                },
                {
                    "width": "120px",
                    "targets": 5
                },
                {
                    "width": "150px",
                    "targets": 6
                },
                {
                    "targets": 8,
                    "render": $.fn.dataTable.render.number('.')
                },
                {
                    "width": "60px",
                    "targets": 9
                },
            ]
        });
    });
</script>