<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projetos</title>
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css" rel="stylesheet">
    
</head>
<body>
<header class="d-flex align-items-center justify-content-between">
    
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light ">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                   <!-- Logo -->
                    <a href="#" class="logo">
                        <img src="logo.png" alt="logo">
                    </a> 
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        <i class="bi bi-house-door"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="projetos.php">
                        <i class="bi bi-folder"></i> Projetos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="publicacoes.php">
                        <i class="bi bi-journal-text"></i> Publicações
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="projetos.php">
                        <i class="bi bi-lightbulb"></i> Iniciação Científica
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="sobre.html">
                        <i class="bi bi-code-slash"></i> Sobre
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>

    <div class="container mt-5">
       
        <br>
        <!-- Barra de Pesquisa -->
        <div class="search-bar">
            <h1>Projetos</h1>
            <input type="text" id="searchInput" class="form-control" placeholder="Pesquisar projetos...">
            <div id="suggestions" class="suggestions"></div>
        </div>

        <div id="projetos" class="row">
            <?php
            // URL do diretório base onde os projetos estão armazenados
            $url_base = "https://wwwp.feb.unesp.br/lutt/";

            // Array para armazenar os projetos
            $projetos = [];

            // Função para listar todos os arquivos a partir do diretório base
            function listarTodosArquivos($url_base, &$projetos) {
                $html = file_get_contents($url_base);
                $dom = new DOMDocument;
                @$dom->loadHTML($html);
                $xpath = new DOMXPath($dom);
                $links = $xpath->query("//a");

                foreach ($links as $link) {
                    $href = $link->getAttribute('href');
                    // Ignora referências de pasta anteriores e links relativos
                    if ($href !== "../" && $href !== "/") {
                        $projetos[] = [
                            'nome' => basename($href),
                            'link' => $url_base . $href
                        ];
                    }
                }
            }

            // Chamar a função para listar os arquivos e popular o array de projetos
            listarTodosArquivos($url_base, $projetos);

            // Exibir os projetos
            foreach ($projetos as $projeto) {
                echo '
                <div class="col-md-4 mb-3 projeto">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">' . $projeto['nome'] . '</h5>
                            <a href="' . $projeto['link'] . '" class="btn btn-primary mr-2" target="_blank" rel="noopener noreferrer">Baixar</a>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal' . md5($projeto['link']) . '">Visualizar</button>
                        </div>
                    </div>
                </div>
                <!-- Modal para exibir o documento -->
                <div class="modal fade" id="modal' . md5($projeto['link']) . '" tabindex="-1" role="dialog" aria-labelledby="modal' . md5($projeto['link']) . 'Label" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal' . md5($projeto['link']) . 'Label">' . $projeto['nome'] . '</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <embed src="' . $projeto['link'] . '" type="application/pdf" width="100%" height="600px">
                            </div>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>

    <!-- JavaScript para manipular a pesquisa -->
    <script>
        // Array de projetos em JavaScript
        const projetos = <?php echo json_encode($projetos); ?>;

        // Referências aos elementos do DOM
        const searchInput = document.getElementById('searchInput');
        const suggestions = document.getElementById('suggestions');
        const projetosContainer = document.getElementById('projetos');

        // Função para filtrar e sugerir resultados
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            suggestions.innerHTML = '';
            suggestions.style.display = 'none';

            if (query.length > 0) {
                const filteredProjects = projetos.filter(projeto => projeto.nome.toLowerCase().includes(query));
                
                filteredProjects.forEach(projeto => {
                    const suggestion = document.createElement('div');
                    suggestion.textContent = projeto.nome;
                    suggestion.addEventListener('click', function() {
                        searchInput.value = projeto.nome;
                        suggestions.style.display = 'none';
                        showFilteredProjects(projeto.nome);
                    });
                    suggestions.appendChild(suggestion);
                });

                if (filteredProjects.length > 0) {
                    suggestions.style.display = 'block';
                }
            }
        });

        // Função para mostrar projetos filtrados
        function showFilteredProjects(filter) {
            projetosContainer.innerHTML = '';
            const filteredProjects = projetos.filter(projeto => projeto.nome.toLowerCase().includes(filter.toLowerCase()));

            filteredProjects.forEach(projeto => {
                const projetoElement = `
                <div class="col-md-4 mb-3 projeto">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">${projeto.nome}</h5>
                            <a href="${projeto.link}" class="btn btn-primary mr-2" target="_blank" rel="noopener noreferrer">Baixar</a>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal${md5(projeto.link)}">Visualizar</button>
                        </div>
                    </div>
                </div>
                <!-- Modal para exibir o documento -->
                <div class="modal fade" id="modal${md5(projeto.link)}" tabindex="-1" role="dialog" aria-labelledby="modal${md5(projeto.link)}Label" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal${md5(projeto.link)}Label">${projeto.nome}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <embed src="${projeto.link}" type="application/pdf" width="100%" height="600px">
                            </div>
                        </div>
                    </div>
                </div>`;
                projetosContainer.insertAdjacentHTML('beforeend', projetoElement);
            });
        }

        // Função para gerar um hash MD5 (para o modal)
        function md5(string) {
            return crypto.subtle.digest("MD5", new TextEncoder().encode(string)).then(buf => {
                return Array.prototype.map.call(new Uint8Array(buf), x => ('00' + x.toString(16)).slice(-2)).join('');
            });
        }
    </script>

    <!-- Bootstrap JavaScript (jQuery and Popper.js are required) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  

    
<!--rodape-->
<section class="contact">
    <div class="contact-info">
        <div class="first-info">
            <img src="logo.png" alt="logo instituição">
            <p><a href="https://cti.feb.unesp.br/">Departamento de Engenharia Civil e Ambiental</a></p>
            <p><a href="https://www.google.com/maps/dir//Av.+Eng.+Lu%C3%ADs+Edmundo+Carrijo+Coube,+14-01+-+Vargem+Limpa,+Bauru+-+SP,+17033-360/@-22.350127,-49.116016,12z/data=!4m8!4m7!1m0!1m5!1m1!1s0x94bf5dfbade14bef:0xf2336695454258b!2m2!1d-49.0336339!2d-22.3501383?entry=ttu">Faculdade de Engenharia  Câmpus de Bauru <br> Av. Eng. Luiz Edmundo C. Coube 14-01 - Vargem Limpa <br> Bauru - SP/SP - CEP 17033-360</a></p>
            <p>Telefone: (14) 3103-6000</p>

            <div class="social-icon">
                <a href="https://www.instagram.com/unespfeb/"><i class='bx bxl-instagram'></i></a>
                <a href="https://www.feb.unesp.br/"><i class='bx bxl-google'></i></a>
            </div>
        </div>

        <div class="second-info">
            <h4>Informações</h4>
            <p><a href="mailto: luttgardes.oliveira-neto@unesp.br?subject=Solicitação de contato">Contate o docente</a></p>
            <p><a href="desenvolvedores.html">Sobre o site</a></p>
        </div>

        <div class="third-info">
            <h4>Projetos</h4>
            <p><a href="projetos.php">Artigos</a></p>
        </div>

        <div class="fourth-info">
            <h4>Publicações</h4>
            <p><a href="publicacoes.php">Arquivos</a></p>
        </div>
        <div class = "subir">
            <h4>Voltar</h4>
            <p><a href="#"><i class='bx bxs-to-top'></i></a></p>
        </div>
    </div>
</section>

<div class="end-text">
    <p>Copyright © @2024. All Rights Reserved. Design By Ana Leal.</p>
</div>
<script src="java.js"></script>
</body>
</html>
