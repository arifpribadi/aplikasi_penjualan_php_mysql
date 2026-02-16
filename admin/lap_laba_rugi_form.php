<?php
include 'header.php';
?>

<div class="col-md-10">
    <h3><span class="glyphicon glyphicon-list-alt"></span>  Laporan Laba Rugi</h3>
    <a class="btn" href="barang_laku.php"><span class="glyphicon glyphicon-arrow-left"></span>  Kembali</a>
    <hr>
    <form action="lap_laba_rugi.php" method="get" target="_blank" class="form-horizontal" style="max-width:480px">
        <div class="form-group">
            <label for="dari">Dari</label>
            <input type="text" id="dari" name="dari" class="form-control" autocomplete="off" value="<?php echo date('Y/m/d', strtotime('-30 days')); ?>">
        </div>
        <div class="form-group">
            <label for="sampai">Sampai</label>
            <input type="text" id="sampai" name="sampai" class="form-control" autocomplete="off" value="<?php echo date('Y/m/d'); ?>">
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Cetak Laporan">
        </div>
    </form>

    <script type="text/javascript">
    $(document).ready(function(){
        $('#dari,#sampai').datepicker({dateFormat: 'yy/mm/dd'});
    });
    </script>
</div>

<?php
include 'footer.php';
?>
