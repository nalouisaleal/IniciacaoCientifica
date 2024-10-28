<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artigos e Publicações</title>
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
                    <a class="nav-link" href="projetos.php">
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
        <div class="row" id="artigos-publicacoes">
        <?php
        // Defina o número de resultados por página
        $results_per_page = 10;

        // Captura o termo de busca (se fornecido)
        $search_query = isset($_GET['query']) ? urlencode($_GET['query']) : '';

        // Captura o número da página (se fornecido)
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $results_per_page;

        // URL da API do CrossRef com o termo de busca e paginação
        $url = "https://api.crossref.org/works?query=" . $search_query . "&rows=" . $results_per_page . "&offset=" . $offset;

        // Inicializando cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'MyCrossRefApp/1.0 (mailto:email@example.com)'); // Defina um User-Agent com seu e-mail

        // Executando a requisição
        $response = curl_exec($ch);

        // Verificando se há erros no cURL
        if ($response === FALSE) {
            echo 'Erro cURL: ' . curl_error($ch);
        } else {
            // Decodifica a resposta JSON
            $data = json_decode($response, true);

            // Verifica se a resposta contém resultados
            if (isset($data['message']['items'])) {
                echo '<div class="container mt-5">';
                echo '<br> ';
                echo '<h1>Artigos Científicos e Publicações</h1>';

                // Formulário de busca
                echo '
                <form method="GET" action="">
                    <div class="form-group">
                        <input type="text" name="query" class="form-control" placeholder="Buscar artigos e publicações" value="' . htmlspecialchars(urldecode($search_query)) . '">
                    </div>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
                <br>';
                
                echo '<div class="row">';

                // Exibe os resultados em formato de card
                foreach ($data['message']['items'] as $article) {
                    // Verificar se o título está disponível
                    $title = isset($article['title'][0]) ? $article['title'][0] : 'Sem título disponível';
                    
                    // Verificar se há uma descrição (não fornecida diretamente pelo CrossRef, então usaremos o DOI como alternativa)
                    $description = isset($article['abstract']) ? $article['abstract'] : 'Não há descrição disponível. Acesse o DOI para mais informações.';
                    
                    // Link para o DOI
                    $doiLink = 'https://doi.org/' . $article['DOI'];

                    echo '
                    <div class="col-md-4 mb-3 content-card" data-category="artigos">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">' . $title . '</h5>
                                <p class="card-text">' . substr($description, 0, 150) . '...</p>
                                <p class="card-text">Publicado em: ' . $article['created']['date-time'] . '</p>
                                <a href="' . $doiLink . '" class="btn btn-primary" target="_blank">Ver mais</a>
                            </div>
                        </div>
                    </div>';
                }

                echo '</div>'; // Fim da row

                // Paginação
                echo '<nav>';
                echo '<ul class="pagination">';

                // Botão de página anterior
                if ($page > 1) {
                    echo '<li class="page-item"><a class="page-link" href="?query=' . urldecode($search_query) . '&page=' . ($page - 1) . '">Anterior</a></li>';
                }

                // Botão de próxima página
                if (count($data['message']['items']) == $results_per_page) {
                    echo '<li class="page-item"><a class="page-link" href="?query=' . urldecode($search_query) . '&page=' . ($page + 1) . '">Próxima</a></li>';
                }

                echo '</ul>';
                echo '</nav>';
                echo '</div>'; // Fim do container

            } else {
                echo 'Nenhum artigo encontrado.';
            }
        }

        // Fechando cURL
        curl_close($ch);
    ?>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
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
</body>
</html>
