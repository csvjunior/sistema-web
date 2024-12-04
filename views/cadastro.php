<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Web Simples</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
<div class="container">
    <h1>Cadastro de Usuários</h1>

    <!-- Formulário de Cadastro -->
    <form id="form-cadastro">
        <input type="text" id="nome" placeholder="Nome" required>
        <input type="email" id="email" placeholder="Email" required>
        <button type="submit">Cadastrar</button>
    </form>

    <div id="mensagem" style="color: green;"></div>

    <!-- Tabela de Usuários -->
    <div class="table-container">
        <table id="lista-usuarios">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <!-- As linhas dos usuários serão inseridas dinamicamente aqui -->
            </tbody>
        </table>
    </div>
</div>

<script src="../public/script.js"></script>
</body>
</html>

