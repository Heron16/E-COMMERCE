<?php
require_once __DIR__ . '/../../config/config.php';
if (!isAdminLoggedIn()) {
    redirect('admin/');
}

$page_title = 'Metabase - Admin';
include __DIR__ . '/../../app/views/admin/header_admin.php';

$embedUrl = defined('METABASE_EMBED_URL') ? METABASE_EMBED_URL : '';
$override = isset($_GET['url']) ? trim($_GET['url']) : '';
if ($override !== '') {
    $embedUrl = $override;
}
$isValidUrl = $embedUrl !== '' && filter_var($embedUrl, FILTER_VALIDATE_URL);
?>
<div class="admin-content">
    <h2>Dashboard Metabase</h2>
    <?php if ($isValidUrl): ?>
        <iframe src="<?php echo htmlspecialchars($embedUrl); ?>" style="width:100%; height:800px; border:0;" allowtransparency="true"></iframe>
    <?php else: ?>
        <div class="alert alert-warning">
            <p>Defina a URL do dashboard do Metabase em <code>METABASE_EMBED_URL</code> para visualizar aqui.</p>
        </div>
    <?php endif; ?>
</div>
<?php include __DIR__ . '/../../app/views/admin/footer_admin.php'; ?>