# Lava-Car - Sistema de Agendamento

Sistema de agendamento online para serviços de lavagem e limpeza de veículos, desenvolvido em PHP puro com PDO e arquitetura MVC.

## Requisitos

- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Servidor web (Apache, Nginx, etc.)

## Instalação

### 1. Clonar ou extrair o projeto

```bash
unzip lavacar-project.zip
cd lavacar-project
```

### 2. Criar o banco de dados

Abra seu cliente MySQL e execute o arquivo `database/schema.sql`:

```bash
mysql -u root -p < database/schema.sql
```

Ou copie e cole o conteúdo do arquivo `database/schema.sql` no seu cliente MySQL.

### 3. Configurar a conexão com o banco de dados

Edite o arquivo `config/pdo.php` e ajuste as credenciais do banco de dados:

```php
$host = 'localhost';
$db = 'lavacar_db';
$user = 'root';
$password = '';
```

### 4. Iniciar o servidor

Se estiver usando PHP built-in:

```bash
cd public
php -S localhost:8000
```

Ou configure seu servidor web (Apache/Nginx) para apontar para a pasta `public/`.

## Acesso ao Sistema

### URL Base
```
http://localhost:8000
```

### Credenciais de Teste (Admin)
- **Email:** admin@lavacar.com
- **Senha:** admin123

## Estrutura do Projeto

```
lavacar-project/
├── public/
│   └── index.php              # Arquivo principal com roteador
├── src/
│   ├── Controllers/           # Controllers da aplicação
│   │   ├── AuthController.php
│   │   ├── SiteController.php
│   │   ├── AdminController.php
│   │   └── AgendamentoController.php
│   ├── Models/                # Modelos de dados
│   │   ├── Usuario.php
│   │   ├── Servico.php
│   │   └── Agendamento.php
│   └── Views/                 # Templates e views
│       ├── templates/
│       │   ├── header.php
│       │   └── footer.php
│       ├── home.php
│       ├── login.php
│       ├── cadastro.php
│       ├── servicos.php
│       ├── agendar.php
│       ├── meus-agendamentos.php
│       └── admin/
│           ├── dashboard.php
│           ├── servicos/
│           ├── agendamentos/
│           └── usuarios/
├── config/
│   └── pdo.php                # Configuração do banco de dados
├── database/
│   └── schema.sql             # Script de criação do banco
└── README.md                  # Este arquivo
```

## Funcionalidades

### Para Clientes
- Visualizar serviços disponíveis
- Cadastro e login
- Agendar serviços com data e hora
- Visualizar seus agendamentos
- Cancelar agendamentos (via admin)

### Para Admin
- Gerenciar serviços (criar, editar, deletar)
- Gerenciar agendamentos (visualizar, atualizar status, deletar)
- Gerenciar clientes (visualizar, deletar)
- Painel de controle centralizado

## Rotas Disponíveis

### Públicas
- `?route=home` - Página inicial
- `?route=servicos` - Lista de serviços
- `?route=login` - Login
- `?route=cadastro` - Cadastro de novo cliente

### Cliente (requer login)
- `?route=agendar` - Agendar serviço
- `?route=meus-agendamentos` - Ver agendamentos do cliente

### Admin (requer login como admin)
- `?route=admin` - Painel de administração
- `?route=admin-servicos` - Gerenciar serviços
- `?route=admin-servicos-criar` - Criar novo serviço
- `?route=admin-servicos-editar` - Editar serviço
- `?route=admin-servicos-deletar` - Deletar serviço
- `?route=admin-agendamentos` - Gerenciar agendamentos
- `?route=admin-agendamentos-atualizar` - Atualizar agendamento
- `?route=admin-agendamentos-deletar` - Deletar agendamento
- `?route=admin-usuarios` - Gerenciar clientes
- `?route=admin-usuarios-deletar` - Deletar cliente

### Geral
- `?route=logout` - Fazer logout

## Segurança

- Senhas são criptografadas com `password_hash()` usando algoritmo bcrypt
- Validação de entrada em todos os formulários
- Proteção contra SQL Injection com prepared statements (PDO)
- Controle de acesso por tipo de usuário (cliente/admin)
- Sessões PHP para gerenciar autenticação

## Notas Importantes

1. **Banco de Dados:** O arquivo `database/schema.sql` cria automaticamente o banco de dados, as tabelas e insere dados de exemplo.

2. **Senha do Admin:** A senha padrão do admin é "admin123". Recomenda-se alterá-la após a primeira instalação.

3. **Horários de Agendamento:** O sistema permite agendar apenas em datas futuras e valida a disponibilidade de horários.

4. **Exclusão de Clientes:** Ao deletar um cliente, todos os seus agendamentos também são deletados (cascata).

## Suporte

Para dúvidas ou problemas, verifique:
- Se o PHP está instalado corretamente
- Se o MySQL está rodando
- Se as credenciais do banco estão corretas em `config/pdo.php`
- Se a pasta `public/` está acessível pelo servidor web

---

**Desenvolvido para fins educacionais - Projeto de Faculdade**

