# Sistema de Lavagem de Veículos

Sistema completo de agendamento online para lavagem de veículos desenvolvido em PHP com MySQL.

## 🚀 Características Principais

### Funcionalidades do Site
- ✅ Catálogo de serviços com preços por tipo de veículo (Moto, Carro, Camioneta)
- ✅ Sistema de carrinho de compras
- ✅ Agendamento online com seleção de data e hora
- ✅ Cadastro e login de clientes
- ✅ Área do cliente para visualizar agendamentos
- ✅ Design responsivo e moderno

### Funcionalidades Administrativas
- ✅ Dashboard com indicadores (receita mensal/semanal, lavagens realizadas, etc.)
- ✅ Gerenciamento de Serviços (CRUD completo)
- ✅ Gerenciamento de Clientes (CRUD completo)
- ✅ Gerenciamento de Agendamentos (CRUD completo)
- ✅ Gerenciamento de Usuários (CRUD completo)
- ✅ Relatórios de serviços mais solicitados
- ✅ Controle de status de agendamentos

### Requisitos Técnicos Atendidos

#### Arquitetura e Padrões
- ✅ **MVC**: Estrutura completa com Models, Views e Controllers separados
- ✅ **Template**: Sistema de layouts reutilizáveis (header/footer)
- ✅ **Manutenibilidade**: Código organizado e comentado

#### Banco de Dados
- ✅ **4 CRUDs completos**: Clientes, Serviços, Agendamentos, Usuários
- ✅ **Triggers**: Sistema de auditoria automática para alterações de preços
- ✅ **Procedures**: Inserção massiva de dados em múltiplas tabelas
- ✅ **Functions**: Verificação de disponibilidade e cálculo automático de valores
- ✅ **Índices**: Otimização de consultas em tabelas com grande volume
- ✅ **Views**: Dashboard agregado para relatórios

#### Funcionalidades
- ✅ **Sistema de Acesso**: Login separado para clientes e administradores
- ✅ **Cadastro de Clientes**: Formulário completo com validações
- ✅ **Carrinho de Compras**: Adição/remoção de serviços antes do agendamento
- ✅ **Dashboard Completo**: Indicadores mensais, semanais e serviços mais solicitados

## 📋 Pré-requisitos

- XAMPP (Apache + MySQL + PHP 7.4+)
- Navegador web moderno

## 🔧 Instalação

### 1. Instalar XAMPP
Baixe e instale o XAMPP de: https://www.apachefriends.org/

### 2. Configurar o Projeto

1. Copie a pasta do projeto para: `C:\xampp\htdocs\Nova pasta\`

2. Abra o XAMPP Control Panel e inicie:
   - Apache
   - MySQL

### 3. Criar o Banco de Dados

1. Acesse: http://localhost/phpmyadmin
2. Clique em "Importar"
3. Selecione o arquivo: `database/schema.sql`
4. Clique em "Executar"

### 4. Acessar o Sistema

**Site Principal:**
```
http://localhost/Nova%20pasta/public/
```

**Painel Administrativo:**
```
http://localhost/Nova%20pasta/public/admin/
```

## 🔑 Credenciais Padrão

### Administrador
- **Email:** admin@lavagem.com
- **Senha:** admin123

### Cliente de Teste
- **Email:** joao@email.com
- **Senha:** 123456

## 📁 Estrutura do Projeto

```
Nova pasta/
├── app/
│   ├── controllers/     # Controllers (lógica de negócio)
│   ├── models/          # Models (acesso a dados)
│   │   ├── Cliente.php
│   │   ├── Servico.php
│   │   ├── Agendamento.php
│   │   └── Usuario.php
│   └── views/           # Views (apresentação)
│       ├── admin/       # Views administrativas
│       ├── cliente/     # Views do cliente
│       └── layouts/     # Layouts reutilizáveis
├── config/
│   ├── config.php       # Configurações gerais
│   └── database.php     # Configuração do banco
├── database/
│   └── schema.sql       # Script completo do banco
├── public/              # Pasta pública (raiz do site)
│   ├── css/
│   │   └── style.css    # Estilos CSS
│   ├── js/              # Scripts JavaScript
│   ├── images/          # Imagens do site
│   ├── admin/           # Painel administrativo
│   ├── index.php        # Página inicial
│   ├── login.php        # Login de cliente
│   ├── cadastro.php     # Cadastro de cliente
│   └── agendamento.php  # Página de agendamento
├── README.md            # Este arquivo
└── start.bat            # Script de inicialização
```

## 💾 Banco de Dados

### Tabelas Principais
- **usuarios**: Usuários administrativos
- **clientes**: Clientes do sistema
- **categorias_servicos**: Categorias de serviços
- **servicos**: Serviços oferecidos
- **agendamentos**: Agendamentos realizados
- **agendamento_itens**: Itens de cada agendamento
- **auditoria_precos**: Auditoria de alterações de preços

### Triggers
- **trg_auditoria_preco_moto**: Auditoria automática de preços para motos
- **trg_auditoria_preco_carro**: Auditoria automática de preços para carros
- **trg_auditoria_preco_camioneta**: Auditoria automática de preços para camionetas

### Procedures
- **sp_inserir_servicos_massivo**: Inserção em massa de serviços
- **sp_inserir_clientes_massivo**: Inserção em massa de clientes

### Functions
- **fn_verificar_disponibilidade**: Verifica disponibilidade de estoque
- **fn_calcular_valor_servico**: Calcula valor baseado no tipo de veículo

### Views
- **vw_dashboard_semanal**: Dashboard de desempenho semanal
- **vw_servicos_mais_solicitados**: Serviços mais vendidos

## 🎨 Funcionalidades Detalhadas

### Para Clientes

1. **Navegação de Serviços**
   - Visualização de todos os serviços disponíveis
   - Preços diferenciados por tipo de veículo
   - Sistema de carrinho para múltiplos serviços

2. **Agendamento**
   - Seleção de data e horário
   - Informações do veículo (tipo, placa, modelo)
   - Cálculo automático do valor total
   - Observações adicionais

3. **Área do Cliente**
   - Visualização de agendamentos realizados
   - Status de cada agendamento
   - Histórico completo

### Para Administradores

1. **Dashboard**
   - Indicadores de performance
   - Receita mensal e semanal
   - Quantidade de lavagens realizadas
   - Serviços mais solicitados
   - Agendamentos do período

2. **Gestão de Serviços**
   - Criar, editar e excluir serviços
   - Definir preços por tipo de veículo
   - Controlar estoque
   - Ativar/desativar serviços

3. **Gestão de Clientes**
   - Visualizar todos os clientes
   - Dados completos de contato
   - Histórico de agendamentos

4. **Gestão de Agendamentos**
   - Visualizar todos os agendamentos
   - Atualizar status (Pendente → Confirmado → Em Andamento → Concluído)
   - Cancelar agendamentos
   - Visualizar detalhes completos

5. **Gestão de Usuários**
   - Criar usuários administrativos
   - Definir permissões (Admin/Funcionário)
   - Ativar/desativar usuários

## 🔒 Segurança

- Senhas criptografadas com MD5
- Proteção contra SQL Injection (PDO com prepared statements)
- Validação de sessões
- Controle de acesso por tipo de usuário
- Sanitização de inputs

## 📊 Relatórios e Indicadores

### Dashboard Administrativo Inclui:
- Total de agendamentos do mês
- Total de lavagens concluídas (mês e semana)
- Receita mensal e semanal
- Total de clientes cadastrados
- Top 5 serviços mais solicitados
- Desempenho semanal detalhado
- Últimos agendamentos realizados

## 🛠 Tecnologias Utilizadas

- **Backend**: PHP 7.4+
- **Banco de Dados**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Arquitetura**: MVC (Model-View-Controller)
- **Web Server**: Apache (via XAMPP)

## 📝 Notas Importantes

1. O sistema usa `localStorage` para o carrinho de compras
2. Todas as datas seguem o formato brasileiro (dd/mm/yyyy)
3. Valores monetários em Real (R$)
4. Sistema de auditoria registra todas as alterações de preços
5. Funções e procedures facilitam operações em massa

## 🤝 Suporte

Para problemas ou dúvidas:
1. Verifique se Apache e MySQL estão rodando no XAMPP
2. Certifique-se de que o banco foi importado corretamente
3. Verifique as configurações em `config/database.php`

## 📄 Licença

Este projeto foi desenvolvido para fins educacionais.

---

**Desenvolvido com PHP + MySQL | Sistema MVC Completo**
