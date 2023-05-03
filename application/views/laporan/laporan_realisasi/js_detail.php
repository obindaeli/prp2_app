<script>
    $(document).ready(function() {
        load_apbd();
    });

    function load_apbd() {
        $('#display-content').css('display', 'none');
        $('.preload').show();
        table = $('#load-content').DataTable({
            destroy: true,
            ordering: false,
            bAutoWidth: false,
            initComplete: function() {
                $('#display-content').css('display', 'block');
                $('.preload').hide();
            },
            ajax: {
                url: "<?= site_url('laporan/laporan_realisasi/load_apbd'); ?>",
                type: 'POST',
                data: {
                    id: "<?= $skpd['id_skpd']; ?>"
                }
            },
            columnDefs: [{
                className: 'text-right',
                targets: [3, 4, 5]
            }, {
                className: 'text-center',
                targets: [0, 1, 2]
            }],
            columns: [{
                data: 'no'
            }, {
                data: 'bulan'
            }, {
                data: 'pendapatan'
            }, {
                data: 'belanja'
            }, {
                data: 'tanggal_input'
            }, {
                data: 'user_input'
            }]
        });
    }
    

    function reload_ajax() {
        table.ajax.reload(null, false);
    }

</script>