
# 💊 Integra Farma

Sistema web de gerenciamento farmacêutico com controle de estoque, fornecedores, usuários e módulo de PDV (Ponto de Venda).

## 📌 Sobre o Projeto

O **Integra Farma** foi desenvolvido para auxiliar farmácias no gerenciamento operacional diário, oferecendo funcionalidades para:

- Controle de estoque de medicamentos
- Cadastro e gerenciamento de fornecedores
- Gerenciamento de usuários
- Registro de histórico/logs
- Sistema de vendas (PDV)
- Relatórios e histórico de vendas

O projeto utiliza **PHP**, **MySQL**, **HTML**, **CSS** e sessões PHP para autenticação e controle de acesso.

---

# 🧱 Estrutura do Projeto

```bash
integrafarma/
│
├── backend/                  # Regras de negócio e operações CRUD
├── conexao/                  # Conexão com banco de dados
├── css/                      # Arquivos de estilização
├── database/                 # Script SQL do banco de dados
├── frontend/                 # Interfaces do sistema
├── img/                      # Imagens e assets
│
├── pdv_integrafarma/
│   ├── backend_pdv/          # Backend do PDV
│   ├── css_pdv/              # Estilos do PDV
│   └── frontend_pdv/         # Interface do PDV
│
└── README.md
```

---

# ⚙️ Tecnologias Utilizadas

- PHP 8+
- MySQL / MariaDB
- HTML5
- CSS3
- JavaScript (pontual)
- XAMPP/Laragon para ambiente local

---

# 🗄️ Banco de Dados

O banco de dados está disponível em:

```bash
/database/integra_farma.sql
```

## Principais tabelas

- `usuarios`
- `medicamentos`
- `fornecedores`
- `logs_historico`
- `vendas`
- `itens_venda`

---

# 🚀 Como Executar o Projeto

## 1. Clone o repositório

```bash
git clone <url-do-repositorio>
```

## 2. Mova o projeto para o servidor local

Exemplo utilizando XAMPP:

```bash
htdocs/integrafarma
```

## 3. Crie o banco de dados

- Abra o phpMyAdmin
- Importe o arquivo:

```bash
database/integra_farma.sql
```

## 4. Configure a conexão

Arquivo:

```bash
conexao/conexao.php
```

Configuração padrão:

```php
$host = "localhost";
$user = "root";
$pass = "";
$db = "integra_farma";
```

## 5. Execute o sistema

Acesse:

```bash
http://localhost/integrafarma/frontend/tela_login.php
```

---

# 🔐 Funcionalidades

## 👤 Usuários

- Cadastro de usuários
- Edição de usuários
- Exclusão de usuários
- Controle de sessão/login

## 💊 Estoque

- Cadastro de medicamentos
- Edição de estoque
- Exclusão de produtos
- Consulta de medicamentos

## 🏢 Fornecedores

- Cadastro de fornecedores
- Atualização de dados
- Exclusão de fornecedores

## 🛒 PDV

- Busca de medicamentos
- Finalização de vendas
- Histórico de vendas
- Relatórios

## 📜 Logs

O sistema possui função de registro de ações através da função:

```php
registrarLog($conn, $id_usuario, $acao)
```

---

# 🔒 Segurança

O projeto utiliza:

- Sessões PHP
- Prepared Statements (`prepare/bind_param`)
- Sanitização básica com `htmlspecialchars`

---

# 📷 Interface

O sistema possui:

- Painel administrativo
- Tela de usuário
- Interface de PDV
- Histórico de movimentações

---

# 📌 Melhorias Futuras

- Dashboard com gráficos
- Controle de validade de medicamentos
- Níveis de permissão
- Emissão de nota fiscal
- API REST
- Responsividade mobile aprimorada

---

# 👨‍💻 Desenvolvido por

Projeto acadêmico/sistema de gerenciamento farmacêutico desenvolvido para fins educacionais e administrativos.