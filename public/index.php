<?php
/**
 * Página Principal do Site
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/models/Servico.php';

// Buscar todos os serviços ativos
$database = new Database();
$db = $database->getConnection();
$servico = new Servico($db);
$stmt = $servico->readAll();
$servicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Agrupar serviços por categoria
$servicos_por_categoria = [];
foreach ($servicos as $s) {
    $categoria = $s['categoria_nome'] ?? 'Outros';
    if (!isset($servicos_por_categoria[$categoria])) {
        $servicos_por_categoria[$categoria] = [];
    }
    $servicos_por_categoria[$categoria][] = $s;
}

$page_title = "Lavagem de Veículos - Serviços de Qualidade";
include __DIR__ . '/../app/views/layouts/header.php';
?>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h1>Lavagem de Veículos Profissional</h1>
        <p>Serviços de qualidade com os melhores preços da região</p>
        <a href="#servicos" class="btn btn-primary">Ver Serviços</a>
    </div>
</section>

<!-- Serviços Section -->
<section id="servicos" class="servicos-section">
    <div class="container">
        <h2>Nossos Serviços</h2>
        <p class="subtitle">Escolha os serviços e agende sua lavagem online</p>
        
        <div id="carrinho-resumo" class="carrinho-resumo" style="display:none;">
            <h3>Carrinho de Serviços</h3>
            <div id="carrinho-itens"></div>
            <div class="carrinho-total">
                <strong>Total:</strong> 
                <span id="carrinho-total">R$ 0,00</span>
            </div>
            <div class="carrinho-actions">
                <button onclick="limparCarrinho()" class="btn btn-secondary">Limpar</button>
                <a href="agendamento.php" class="btn btn-primary">Agendar Agora</a>
            </div>
        </div>

        <?php foreach ($servicos_por_categoria as $categoria => $servicos_cat): ?>
        <div class="categoria-section">
            <h3 class="categoria-titulo"><?php echo htmlspecialchars($categoria); ?></h3>
            
            <div class="servicos-grid">
                <?php foreach ($servicos_cat as $servico): ?>
                <div class="servico-card" data-servico-id="<?php echo $servico['id']; ?>">
                    <div class="servico-header">
                        <h4><?php echo htmlspecialchars($servico['nome']); ?></h4>
                        <span class="servico-duracao"><?php echo $servico['duracao_minutos']; ?> min</span>
                    </div>
                    
                    <p class="servico-descricao"><?php echo htmlspecialchars($servico['descricao']); ?></p>
                    
                    <div class="servico-precos">
                        <div class="preco-item">
                            <span class="veiculo-tipo">Moto:</span>
                            <span class="preco" data-tipo="moto" data-valor="<?php echo $servico['preco_moto']; ?>">
                                <?php echo formatarMoeda($servico['preco_moto']); ?>
                            </span>
                        </div>
                        <div class="preco-item">
                            <span class="veiculo-tipo">Carro:</span>
                            <span class="preco" data-tipo="carro" data-valor="<?php echo $servico['preco_carro']; ?>">
                                <?php echo formatarMoeda($servico['preco_carro']); ?>
                            </span>
                        </div>
                        <div class="preco-item">
                            <span class="veiculo-tipo">Camioneta:</span>
                            <span class="preco" data-tipo="camioneta" data-valor="<?php echo $servico['preco_camioneta']; ?>">
                                <?php echo formatarMoeda($servico['preco_camioneta']); ?>
                            </span>
                        </div>
                    </div>
                    
                    <button onclick="adicionarAoCarrinho(<?php echo $servico['id']; ?>, '<?php echo htmlspecialchars($servico['nome']); ?>')" 
                            class="btn btn-primary btn-adicionar">
                        Adicionar ao Carrinho
                    </button>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Sobre Section -->
<section class="sobre-section">
    <div class="container">
        <h2>Por que nos escolher?</h2>
        <div class="vantagens-grid">
            <div class="vantagem-item">
                <div class="vantagem-icon">✓</div>
                <h4>Profissionais Qualificados</h4>
                <p>Equipe treinada e experiente</p>
            </div>
            <div class="vantagem-item">
                <div class="vantagem-icon">✓</div>
                <h4>Produtos de Qualidade</h4>
                <p>Utilizamos os melhores produtos</p>
            </div>
            <div class="vantagem-item">
                <div class="vantagem-icon">✓</div>
                <h4>Agendamento Online</h4>
                <p>Agende pelo site de forma rápida</p>
            </div>
            <div class="vantagem-item">
                <div class="vantagem-icon">✓</div>
                <h4>Preços Justos</h4>
                <p>Melhor custo-benefício</p>
            </div>
        </div>
    </div>
</section>

<script>
// Sistema de Carrinho
let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
let tipoVeiculoSelecionado = localStorage.getItem('tipo_veiculo') || 'carro';

// Atualizar carrinho ao carregar a página
document.addEventListener('DOMContentLoaded', function() {
    atualizarCarrinho();
});

function adicionarAoCarrinho(servicoId, servicoNome) {
    // Verificar se já existe no carrinho
    const existe = carrinho.find(item => item.id === servicoId);
    
    if (existe) {
        alert('Este serviço já está no carrinho!');
        return;
    }
    
    // Buscar preço baseado no tipo de veículo
    const servicoCard = document.querySelector(`[data-servico-id="${servicoId}"]`);
    const precoElement = servicoCard.querySelector(`.preco[data-tipo="${tipoVeiculoSelecionado}"]`);
    const preco = parseFloat(precoElement.dataset.valor);
    
    // Adicionar ao carrinho
    carrinho.push({
        id: servicoId,
        nome: servicoNome,
        tipo_veiculo: tipoVeiculoSelecionado,
        preco: preco
    });
    
    // Salvar no localStorage
    localStorage.setItem('carrinho', JSON.stringify(carrinho));
    
    // Atualizar interface
    atualizarCarrinho();
    
    // Feedback visual
    alert('Serviço adicionado ao carrinho!');
}

function removerDoCarrinho(servicoId) {
    carrinho = carrinho.filter(item => item.id !== servicoId);
    localStorage.setItem('carrinho', JSON.stringify(carrinho));
    atualizarCarrinho();
}

function limparCarrinho() {
    if (confirm('Deseja limpar todos os serviços do carrinho?')) {
        carrinho = [];
        localStorage.setItem('carrinho', JSON.stringify(carrinho));
        atualizarCarrinho();
    }
}

function atualizarCarrinho() {
    const carrinhoResumo = document.getElementById('carrinho-resumo');
    const carrinhoItens = document.getElementById('carrinho-itens');
    const carrinhoTotal = document.getElementById('carrinho-total');
    
    if (carrinho.length === 0) {
        carrinhoResumo.style.display = 'none';
        return;
    }
    
    carrinhoResumo.style.display = 'block';
    
    // Montar lista de itens
    let html = '<ul class="carrinho-lista">';
    let total = 0;
    
    carrinho.forEach(item => {
        total += item.preco;
        html += `
            <li class="carrinho-item">
                <span class="item-nome">${item.nome}</span>
                <span class="item-preco">R$ ${item.preco.toFixed(2).replace('.', ',')}</span>
                <button onclick="removerDoCarrinho(${item.id})" class="btn-remover">×</button>
            </li>
        `;
    });
    
    html += '</ul>';
    
    carrinhoItens.innerHTML = html;
    carrinhoTotal.textContent = 'R$ ' + total.toFixed(2).replace('.', ',');
}
</script>

<?php include __DIR__ . '/../app/views/layouts/footer.php'; ?>
