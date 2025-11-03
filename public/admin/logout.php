<<<<<<< HEAD
<?php
/**
 * Logout Admin
 */

require_once __DIR__ . '/../../config/config.php';

// Remover variáveis de sessão do admin
unset($_SESSION['admin_id']);
unset($_SESSION['admin_nome']);
unset($_SESSION['admin_email']);
unset($_SESSION['admin_tipo']);

// Redirecionar para login admin
redirect('admin/');
?>
=======
<?php
/**
 * Logout Admin
 */

require_once __DIR__ . '/../../config/config.php';

// Remover variáveis de sessão do admin
unset($_SESSION['admin_id']);
unset($_SESSION['admin_nome']);
unset($_SESSION['admin_email']);
unset($_SESSION['admin_tipo']);

// Redirecionar para login admin
redirect('admin/');
?>
>>>>>>> 6d2211e1183146ab30b22ae970e8c3384e7feec3
