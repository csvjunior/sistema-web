Descrição dos Arquivos

Raiz do Projeto

index.php: Arquivo de entrada principal que pode redirecionar para o controlador adequado.
config/

conexao.php: Centraliza a conexão com o banco de dados.
app/Controller/

UsuarioController.php: Controlador responsável por gerenciar as ações do usuário, como cadastro e listagem.
app/Model/

Usuario.php: Modelo que contém a lógica para interagir com o banco de dados.
public/

script.js e style.css: Arquivos de script e estilo acessíveis diretamente pelo navegador.
database/

criar_tabela.php: Script usado para criar a tabela no banco de dados (em desenvolvimento ou testes).
views/

cadastro.php: Formulário de entrada de dados do usuário.

mensagem.php: Página para exibir mensagens como sucesso ou erros.

Exemplo de Navegação e Fluxo
O usuário acessa index.php, que redireciona para views/cadastro.php.
O formulário em views/cadastro.php envia os dados para o controlador (via UsuarioController.php).
O controlador utiliza o modelo (Usuario.php) para interagir com o banco de dados.
O controlador redireciona para uma view (mensagem.php) para mostrar o resultado (sucesso ou erro).