<?php
/**
 * Configurações de Pagamento
 */

// Configurações PIX
define('PIX_CHAVE', '11987654321'); // Sua chave PIX (telefone, email, CPF, CNPJ ou aleatória)
define('PIX_NOME_BENEFICIARIO', 'Lavagem Auto Center'); // Nome que aparecerá no PIX
define('PIX_CIDADE', 'São Paulo'); // Cidade do beneficiário

// Configurações de QR Code
define('QRCODE_API_URL', 'https://api.qrserver.com/v1/create-qr-code/');
define('QRCODE_SIZE', '250x250');

// Configurações de Pagamento
define('PAGAMENTO_TIMEOUT_MINUTOS', 30); // Tempo em minutos para expirar o pagamento PIX
define('PAGAMENTO_VERIFICACAO_INTERVALO', 10); // Intervalo em segundos para verificar status

// Formas de pagamento disponíveis
define('FORMAS_PAGAMENTO', [
    'pix' => [
        'nome' => 'PIX',
        'icone' => '💳',
        'descricao' => 'Pagamento instantâneo',
        'disponivel' => true
    ],
    'dinheiro' => [
        'nome' => 'Dinheiro',
        'icone' => '💵',
        'descricao' => 'Pagar no local',
        'disponivel' => true
    ],
    'cartao' => [
        'nome' => 'Cartão',
        'icone' => '💳',
        'descricao' => 'Débito ou crédito no local',
        'disponivel' => true
    ]
]);

/**
 * Gerar QR Code PIX
 * 
 * @param string $chave_pix Chave PIX
 * @param float $valor Valor em reais
 * @param string $descricao Descrição do pagamento
 * @return string URL do QR Code
 */
function gerarQRCodePix($chave_pix, $valor, $descricao = '') {
    // Esta é uma implementação simplificada
    // Para produção, use a biblioteca PIX oficial ou API do seu banco
    
    $payload = gerarPayloadPix($chave_pix, $valor, $descricao);
    
    $qrcode_url = QRCODE_API_URL . '?size=' . QRCODE_SIZE . '&data=' . urlencode($payload);
    
    return $qrcode_url;
}

/**
 * Gerar Payload PIX (formato Copia e Cola)
 * 
 * @param string $chave_pix Chave PIX
 * @param float $valor Valor em reais
 * @param string $descricao Descrição do pagamento
 * @return string Payload PIX
 */
function gerarPayloadPix($chave_pix, $valor, $descricao = '') {
    // Esta é uma implementação SIMPLIFICADA para demonstração
    // Para produção, use uma biblioteca oficial como:
    // - https://github.com/renatomb/php_qrcode_pix
    // - https://github.com/tecnospeed/pix-qrcode
    
    // Aqui você implementaria a geração do payload EMV seguindo o padrão do Banco Central
    // Por enquanto, retorna apenas a chave PIX
    
    return $chave_pix;
}

/**
 * Verificar se forma de pagamento está disponível
 * 
 * @param string $forma Forma de pagamento (pix, dinheiro, cartao)
 * @return bool
 */
function formaPagamentoDisponivel($forma) {
    $formas = FORMAS_PAGAMENTO;
    return isset($formas[$forma]) && $formas[$forma]['disponivel'];
}

/**
 * Obter informações da forma de pagamento
 * 
 * @param string $forma Forma de pagamento
 * @return array|null
 */
function getFormaPagamentoInfo($forma) {
    $formas = FORMAS_PAGAMENTO;
    return isset($formas[$forma]) ? $formas[$forma] : null;
}
