<?php
$inPages = strpos($_SERVER['PHP_SELF'], '/pages/') !== false;
$base = $inPages ? '../' : '';
?>
<footer class="footer">
  <p>
    <i class="fas fa-copyright"></i>
    <?= date('Y') ?> PT Cika Mulia Multimedia — Sistem Pendukung Keputusan TOPSIS
  </p>
</footer>
<script src="<?= $base ?>assets/js/script.js"></script>
<script>
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('<?= $base ?>assets/sw.js').catch(()=>{});
}
</script>
</body>
</html>