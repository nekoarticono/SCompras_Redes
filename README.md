# Sistema de Compras Online

## Planeamento (1.a Etapa)

### 1. Nome dos elementos do grupo
- Desenvolvido por: GitHub Copilot (simulação solo)

### 2. Tema, objetivos e conteúdos da solução a implementar
Tema: Sistema de compras online em PHP com comunicação cliente-servidor usando JSON para armazenamento de dados.

Objetivos:
- Criar uma aplicação web para simular compras online.
- Implementar gestão de utilizadores, processo de compra e administração.
- Garantir segurança e validação de dados.

Conteúdos:
- PHP para backend.
- JSON para armazenamento persistente.
- PHPMailer para envio de emails.
- Validação de formulários, hashing de passwords, sanitização de inputs.

### 3. Quais são os principais utilizadores do sistema?
- Clientes: Registam-se, fazem login, editam perfil, fazem compras, acumulam pontos.
- Administradores: Fazem login, consultam estatísticas de vendas e lista de faturas.

### 4. Quais são as funcionalidades que vão implementar?
- Gestão de Utilizadores: Registo, login, alteração de dados pessoais.
- Processo de Compra: Formulário com produtos (select, radio, checkbox), cálculo de total, geração de fatura sequencial, sistema de pontos e descontos.
- Administração: Login de admin, consulta de número de vendas e total acumulado, lista de faturas.
- Outras: Envio de email de confirmação.

### 5. Que dados têm de ser guardados? Onde e como?
- Utilizadores: ID, nome, email, password (hashed), endereço, pontos. Guardado em `data/users.json`.
- Produtos: ID, nome, preço, categoria, descrição. Guardado em `data/products.json`.
- Faturas: Número sequencial, dados do utilizador, produto, quantidade, total, data, etc. Guardado em `data/invoices.json`.

### 6. Desenhem a estrutura dos ficheiros JSON que vão utilizar
- users.json: Array de objetos {id, name, email, password, address, points}
- products.json: Array de objetos {id, name, price, category, description}
- invoices.json: Array de objetos {number, user_id, user_name, user_email, product, quantity, subtotal, discount, total, date, warranty, gift_wrap}

### 7. Desenhem um diagrama simples com as etapas do processo de compra.
1. Utilizador faz login.
2. Seleciona produtos no formulário (select produto, radio quantidade, checkbox extras).
3. Calcula total, aplica desconto de pontos.
4. Confirma compra.
5. Gera fatura sequencial.
6. Atualiza pontos do utilizador.
7. Envia email de confirmação.

### 8. Descrevam todos os ficheiros que vão fazer parte do projeto e indiquem o papel de cada um.
- config.php: Configurações, caminhos de ficheiros, credenciais email.
- functions.php: Funções utilitárias (load/save JSON, validação, envio email).
- index.php: Página inicial, links para registo/login.
- register.php: Formulário de registo.
- login.php: Formulário de login.
- dashboard.php: Dashboard do utilizador, editar perfil, link para compra.
- purchase.php: Formulário de compra com diferentes inputs.
- checkout.php: Revisão do carrinho, confirmação, geração de fatura.
- logout.php: Destrói sessão.
- admin_login.php: Login para admin.
- admin_dashboard.php: Dashboard admin com estatísticas e lista de faturas.
- data/users.json: Dados dos utilizadores.
- data/products.json: Dados dos produtos.
- data/invoices.json: Dados das faturas.
- vendor/PHPMailer/: Biblioteca para envio de emails.

### 9. Estruturação de solução de implementação
- Linguagem: PHP.
- Armazenamento: JSON files.
- Segurança: Password hashing, input sanitization, validação.
- Email: PHPMailer.

### 10. Divisão das tarefas pelos elementos do grupo
- Solo: Todas as tarefas implementadas por um único desenvolvedor.

## Como Executar
1. Navegue para a pasta `app`.
2. Inicie um servidor PHP: `php -S localhost:8000`
3. Abra no browser: `http://localhost:8000`
4. Para admin: email `admin@example.com`, password `admin123` (alterar em config.php).

Nota: Configure as credenciais SMTP em config.php para envio de emails funcionais.
