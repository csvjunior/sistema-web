document.getElementById("form-cadastro").addEventListener("submit", async (e) => {
    e.preventDefault(); // Evita o envio padrão do formulário

    const nome = document.getElementById("nome").value;
    const email = document.getElementById("email").value;

    try {
        const response = await fetch("../app/Controller/UsuarioController.php?action=create", { // Envia "action" na query string
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ nome, email }),
        });

        if (!response.ok) {
            throw new Error("Erro na comunicação com o servidor.");
        }

        const data = await response.json();
        document.getElementById("mensagem").innerText = data.mensagem || "Erro desconhecido!";
        carregarUsuarios(); // Atualiza a lista
    } catch (error) {
        console.error("Erro:", error);
        document.getElementById("mensagem").innerText = "Erro ao cadastrar!";
    }
});


async function carregarUsuarios() {
    const lista = document.getElementById("lista-usuarios");
    lista.innerHTML = ""; // Limpa a tabela antes de preenchê-la

    try {
        const response = await fetch("../app/Controller/UsuarioController.php?action=list");
        const textResponse = await response.text(); // Pega a resposta como texto
        console.log("Resposta do servidor:", textResponse); // Verificação

        // Verifica se a resposta é JSON
        try {
            const usuarios = JSON.parse(textResponse);
            console.log("Dados recebidos:", usuarios); // Verificação

            if (usuarios.length === 0) {
                lista.innerHTML = "<tr><td colspan='4'>Nenhum usuário cadastrado.</td></tr>";
                return;
            }

            usuarios.forEach((usuario) => {
                const row = document.createElement("tr");

                row.innerHTML = `
                    <td>${usuario.id}</td>
                    <td>${usuario.nome}</td>
                    <td>${usuario.email}</td>
                    <td>
                        <button class="editar" onclick="editarUsuario(${usuario.id}, '${usuario.nome}', '${usuario.email}')">Editar</button>
                        <button class="excluir" onclick="excluirUsuario(${usuario.id})">Excluir</button>
                    </td>
                `;
                lista.appendChild(row);
            });
        } catch (error) {
            console.error("Erro ao converter resposta em JSON:", error);
            lista.innerHTML = "<tr><td colspan='4'>Erro ao carregar usuários (não foi possível converter em JSON).</td></tr>";
        }
    } catch (error) {
        console.error("Erro ao carregar usuários:", error);
        lista.innerHTML = "<tr><td colspan='4'>Erro ao carregar usuários.</td></tr>";
    }
}

// Função para excluir usuário
async function excluirUsuario(id) {
    if (confirm("Tem certeza de que deseja excluir este usuário?")) {
        try {
            const response = await fetch("../app/Controller/UsuarioController.php?action=delete", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ id }),
            });

            const result = await response.json();

            if (result.sucesso) {
                alert("Usuário excluído com sucesso!");
                carregarUsuarios(); // Recarrega a lista de usuários
            } else {
                alert("Erro ao excluir usuário: " + result.mensagem);
            }
        } catch (error) {
            console.error("Erro ao excluir usuário:", error);
        }
    }
}

// Função para editar usuário
async function editarUsuario(id, nome, email) {
    const novoNome = prompt("Digite o novo nome:", nome);
    const novoEmail = prompt("Digite o novo email:", email);

    if (novoNome && novoEmail) {
        try {
            const response = await fetch("../app/Controller/UsuarioController.php?action=edit", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ id, nome: novoNome, email: novoEmail }),
            });

            const result = await response.json();

            if (result.sucesso) {
                alert("Usuário atualizado com sucesso!");
                carregarUsuarios(); // Recarrega a lista de usuários
            } else {
                alert("Erro ao atualizar usuário: " + result.mensagem);
            }
        } catch (error) {
            console.error("Erro ao atualizar usuário:", error);
        }
    } else {
        alert("Os campos não podem ficar vazios!");
    }
}

// Certifica de que o evento onload da página ou outro evento carregue a função corretamente
window.onload = () => {
    carregarUsuarios();
};

/* Chama a função para carregar os usuários ao iniciar a página
carregarUsuarios(); */



/*
responsividade com javascript
function ajustarResponsividade() {
    const largura = window.innerWidth;

    if (largura < 768) {
        document.body.style.fontSize = "14px";
    } else if (largura < 1024) {
        document.body.style.fontSize = "16px";
    } else {
        document.body.style.fontSize = "18px";
    }
}

// Chama a função quando a página carrega
ajustarResponsividade();

// Adapta-se ao redimensionamento da janela
window.addEventListener("resize", ajustarResponsividade);
*/