<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <!-- Bootstrap CSS from CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css" rel="stylesheet">
  
    <title>Homepage</title>
</head>
<body>

  <header class="d-flex align-items-center justify-content-between">
    <!-- Logo -->
    <a href="#" class="logo">
        <img src="logo.png" alt="logo">
    </a>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">
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

<!-- Bootstrap JavaScript (jQuery and Popper.js are required) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!--foto grande com exto em cima-->
    <section class="main-home">
        <div class="main-text">
            <h5>Departamento de Engenharia Civil</h5>
            <h1>Bem-vindo ao departamento de Engenharia Civil,<br>onde a excelência e a inovação são os  <br>pilares do nosso trabalho.</h1>
            <p> Universidade Estadual Paulista (UNESP)</p>
        </div>
    </section>

    <!--BOTÕES PARA PÁGINAS COMO O LATTES-->
    <div class="button-container">
        <a href="https://www.unesp.br/portaldocentes/docentes/73?lang=pt_BR" class="info-button">Portal Docentes</a>
        <a href="https://bv.fapesp.br/pt/pesquisador/6927/luttgardes-de-oliveira-neto/" class="info-button">FAPESP</a>
        <a href="https://br.linkedin.com/in/luttgardes-oliveira-neto-69910964" class="info-button">Linkedin</a>
        <a href=" http://lattes.cnpq.br/7534243554711263" class="info-button">Lattes</a>
    </div>

    <!--INFORMAÇÕES SOBRE O ORIENTADOR-->
    <div class="intro flex">
        <div class="circle">
            <img src="orientador.jpg" alt="Imagem" class="circle-img">
        </div>
        <div class="text">Dr. Luttgardes de Oliveira Neto
            é um destacado profissional em Engenharia Civil, 
            com graduação, mestrado e doutorado pela Universidade de São Paulo. Possui ampla experiência 
            e leciona na Universidade Estadual Paulista Júlio de Mesquita Filho desde 1991. Além disso, 
            realizou estágio pós-doutoral na Universidade de Newcastle, Austrália, e obteve o título de 
            "Livre-Docência em Estruturas Metálicas" em 2011. Sua expertise abrange Mecânica das Estruturas, 
            métodos como o dos elementos de contorno e métodos numéricos, bem como estruturas de concreto 
            armado, metálicas e de madeira. Seu comprometimento com pesquisa e ensino o torna uma referência 
            na Engenharia Civil, contribuindo significativamente para o avanço da disciplina. Este site 
            apresenta suas realizações e projetos, oferecendo insights valiosos sobre sua notável carreira.</div>
    </div>

    <div class="container mt-5">
  <h1>Projetos em Destaque</h1>

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

      // Definir a quantidade de projetos a serem exibidos
      $quantidade_exibicao = 6;

      // Exibir os primeiros projetos limitados
      for ($i = 0; $i < min($quantidade_exibicao, count($projetos)); $i++) {
          $projeto = $projetos[$i];
          echo '
          <div class="col-md-4 project-card">
              <div class="card">
                  <div class="card-body">
                      <h5 class="card-title">' . htmlspecialchars($projeto['nome']) . '</h5>
                      <a href="' . htmlspecialchars($projeto['link']) . '" class="btn btn-primary" target="_blank" rel="noopener noreferrer">Baixar</a>
                  </div>
              </div>
          </div>';
      }
      ?>
  </div>

  <div class="mt-4">
      <a href="projetos.php" class="info-button">Ver Todos os Projetos</a>
  </div>
</div>

   <!--video e textinho-->
   <div class="video" style="--aspect-ratio: 16/9;">
    <iframe width="560" height="315" src="https://www.youtube.com/embed/7KmQaVFexYc?si=S76FOyyemYtOa-iN" title="YouTube video player" frameborder="0" 
    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>     
</div>
<div class="infos flex">
    <p>A engenharia civil é essencial para o desenvolvimento das sociedades modernas, pois projeta, constrói e mantém infraestruturas vitais como edifícios, estradas e sistemas de água. Seu papel é fundamental na criação de ambientes seguros e funcionais, garantindo eficiência e sustentabilidade. Além disso, os engenheiros civis ajudam a enfrentar desafios relacionados às mudanças climáticas e desastres naturais, promovendo estruturas mais resilientes e protegendo tanto as comunidades quanto o meio ambiente.</p>
</div>
    

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
