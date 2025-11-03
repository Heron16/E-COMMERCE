<?php
echo "<h1>INICIANDO DEBUG FINAL...</h1>";

// --- 1. INCLUIR ARQUIVOS ---
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/logs/logs_alteracao.php';

// --- 2. INICIAR SESSÃO E CONEXÃO ---
session_start();
$database = new Database();
$db = $database->getConnection();

echo "<hr><h2>PASSO 3: SESSÃO</h2>";
if (!isset($_SESSION['usuario_id'])) {
    die("ACESSO NEGADO. (Sessão 'usuario_id' não encontrada)");
}
$admin_logado_id = $_SESSION['usuario_id'];
echo "<strong>Admin Logado (usuario_id):</strong> " . htmlspecialchars($admin_logado_id);

echo "<hr><h2>PASSO 4: \$_POST</h2>";
if (!isset($_POST['agendamento_id']) || !isset($_POST['status'])) {
    die("ERRO DE DADOS: 'agendamento_id' ou 'status' não foram enviados.");
}
$agendamento_id = $_POST['agendamento_id'];
$novo_status    = $_POST['status'];
echo "<strong>Agendamento ID:</strong> " . htmlspecialchars($agendamento_id) . "<br>";
echo "<strong>Novo Status:</strong> " . htmlspecialchars($novo_status) . "<br>";

// --- 5. BUSCAR DADOS ANTIGOS ---
$stmt_antigo = $db->prepare("SELECT status FROM agendamentos WHERE id = :id");
$stmt_antigo->execute(['id' => $agendamento_id]);
$dados_antigos = $stmt_antigo->fetch(PDO::FETCH_ASSOC);
echo "<hr><h2>PASSO 5: DADOS ANTIGOS</h2>";
echo "<pre>"; print_r($dados_antigos); echo "</pre>";

// --- 6. ATUALIZAR O BANCO DE DADOS ---
echo "<hr><h2>PASSO 6: UPDATE</h2>";
try {
    $sql_update = "UPDATE agendamentos SET status = :status WHERE id = :id";
    $stmt_update = $db->prepare($sql_update);
    $sucesso = $stmt_update->execute([
        'status' => $novo_status,
        'id'     => $agendamento_id
    ]);
    
    // Verificando o número de linhas afetadas
    $linhas_afetadas = $stmt_update->rowCount();
    
    echo "Comando UPDATE executado.<br>";
    echo "<strong>\$sucesso (resultado do execute()):</strong> "; var_dump($sucesso); echo "<br>";
    echo "<strong>Linhas Afetadas (rowCount()):</strong> $linhas_afetadas<br>";

} catch (PDOException $e) {
    die("ERRO FATAL NO UPDATE (PASSO 6): " . $e->getMessage());
}

// --- 7. CHAMAR A FUNÇÃO DE LOG ---
echo "<hr><h2>PASSO 7: LOG</h2>";
if ($sucesso) {
    echo "<strong style='color:green;'>'if (\$sucesso)' foi VERDADEIRO.</strong><br>";
    echo "Chamando a função registrarLog()...<br>";

    $acao = 'STATUS_ATUALIZADO';
    if ($novo_status == 'confirmado') $acao = 'RESERVA_CONFIRMADA';
    if ($novo_status == 'concluido') $acao = 'SERVICO_CONCLUIDO';
    if ($novo_status == 'cancelado') $acao = 'RESERVA_CANCELADA';

    $dados_novos = ['status' => $novo_status];

    // Chamando a função (que tem o 'die()' se falhar)
    registrarLog(
        $db, $admin_logado_id, $acao, 'agendamentos',
        $agendamento_id, $dados_antigos, $dados_novos
    );
    
    echo "<strong style='color:green;'>FUNÇÃO registrarLog() FOI CHAMADA E NÃO DEU ERRO.</strong><br>";
    echo "Isso significa que o log DEVE estar no banco.<br>";
    echo "Verifique o phpMyAdmin (e dê F5) AGORA.<br>";

} else {
    echo "<strong style='color:red;'>'if (\$sucesso)' foi FALSO.</strong><br>";
    echo "O log NÃO foi chamado.<br>";
    echo "<strong>Info do Erro (se houver):</strong><br><pre>";
    print_r($stmt_update->errorInfo());
    echo "</pre>";
}

// --- 8. PARAR O SCRIPT ---
echo "<hr><h2>PASSO 8: FIM</h2>";
die("<strong>DEBUG FINALIZADO.</strong> O redirecionamento foi impedido.");
?><?php
/**
 * public/admin/mudar_status_agendamento.php
 *
 * Endpoint da API para alterar o status de um agendamento.
 * Este script:
 * 1. Inicia a sessão.
 * 2. Conecta ao banco (usando a sua classe Database).
 * 3. Inclui a função de log.
 * 4. Valida a entrada.
 * 5. Faz a lógica de alteração e chama o log.
 * 6. Retorna uma resposta JSON.
 */

// Informa ao cliente que a resposta será em formato JSON
header('Content-Type: application/json');

// 1. Iniciar Sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Incluir arquivos necessários e Conectar ao Banco
// Usamos __DIR__ para caminhos absolutos.
// Assumindo que 'database.php' está em 'app/config/database.php'
try {
    // 2a. Inclui a sua classe de banco de dados
    require_once __DIR__ . '/../../app/config/database.php'; 
    
    // 2b. Inclui a função de log
    require_once __DIR__ . '/../../app/logs/logs_alteracao.php';

    // 2c. Instancia o banco e obtém a conexão PDO
    $database = new Database();
    $pdo = $database->getConnection(); // $pdo é criado AQUI

    // Valida se a conexão foi estabelecida
    if (!$pdo) {
         // A sua classe já deve ter dado 'echo' no erro,
         // mas paramos a execução aqui.
        throw new Exception("Falha ao obter conexão PDO da classe Database.");
    }

} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro interno. Falha ao carregar dependências: ' . $e->getMessage()]);
    exit;
}
// A partir daqui, $pdo e registrarLog() existem e estão prontos.


// 3. Autenticação (Exemplo simples)
// Em um sistema real, você teria uma verificação de permissão de admin
if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(['sucesso' => false, 'mensagem' => 'Acesso negado. Faça login.']);
    exit;
}

// 4. Validar Entradas (POST)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['sucesso' => false, 'mensagem' => 'Método não permitido. Use POST.']);
    exit;
}

$agendamento_id = $_POST['agendamento_id'] ?? null;
$novo_status = $_POST['novo_status'] ?? null;

if (empty($agendamento_id) || !is_numeric($agendamento_id)) {
    http_response_code(400); // Bad Request
    echo json_encode(['sucesso' => false, 'mensagem' => 'ID do agendamento inválido.']);
    exit;
}

if (empty($novo_status)) {
    http_response_code(400); // Bad Request
    echo json_encode(['sucesso' => false, 'mensagem' => 'O novo status é obrigatório.']);
    exit;
}

// --- Início da Lógica de Negócio ---

$dados_antigos = null;
$dados_novos = null;

try {
    // 5. Inicia uma transação
    $pdo->beginTransaction();

    // 6. Buscar dados antigos (para o log)
    // Usamos 'FOR UPDATE' para travar o registro
    $stmt_select = $pdo->prepare("SELECT * FROM agendamentos WHERE id = :id FOR UPDATE");
    $stmt_select->execute([':id' => $agendamento_id]);
    $dados_antigos = $stmt_select->fetch(PDO::FETCH_ASSOC);

    if (!$dados_antigos) {
        $pdo->rollBack();
        http_response_code(404); // Not Found
        echo json_encode(['sucesso' => false, 'mensagem' => 'Agendamento não encontrado.']);
        exit;
    }
    
    // Se o status já for o mesmo, não faz nada
    if ($dados_antigos['status'] === $novo_status) {
        $pdo->rollBack(); 
        http_response_code(200); // OK
        echo json_encode(['sucesso' => true, 'mensagem' => 'O agendamento já estava com este status.']);
        exit;
    }

    // 7. Realizar o Update
    $stmt_update = $pdo->prepare("UPDATE agendamentos SET status = :novo_status WHERE id = :id");
    $sucesso_update = $stmt_update->execute([
        ':novo_status' => $novo_status,
        ':id' => $agendamento_id
    ]);

    if (!$sucesso_update) {
        throw new Exception("A atualização no banco de dados falhou.");
    }
    
    // 8. Preparar dados novos (para o log)
    $dados_novos = $dados_antigos; // Copia os dados antigos
    $dados_novos['status'] = $novo_status; // Altera apenas o campo que mudou

    // 9. Commit da transação principal
    $pdo->commit();

} catch (Exception $e) {
    // 10. Rollback em caso de falha
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500); // Internal Server Error
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao atualizar agendamento: ' . $e->getMessage()]);
    exit;
}

// 11. Registrar o Log (Fora da transação principal)
// A ação principal (mudar status) já foi concluída e comitada.
if ($dados_antigos) {
    registrarLog(
        $pdo,                           // A conexão (da sua classe Database)
        'UPDATE_STATUS_AGENDAMENTO',    // Ação (seja específico!)
        'agendamentos',                 // Tabela afetada
        (int)$agendamento_id,           // ID do registro
        $dados_antigos,                 // Dados completos antes da mudança
        $dados_novos                    // Dados completos após a mudança
    );
}

// 12. Responder com sucesso
http_response_code(200);
echo json_encode([
    'sucesso' => true, 
    'mensagem' => "Status do agendamento #{$agendamento_id} atualizado para '{$novo_status}'.",
    'dados_novos' => $dados_novos // Retorna os dados atualizados para o front-end
]);

?>

