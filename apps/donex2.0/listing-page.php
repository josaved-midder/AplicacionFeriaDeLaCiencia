
<?php
// Incluir el archivo de conexión a la base de datos
require_once __DIR__ . "/php/database.php";

$db = new Database();
$conn = $db->connect();

// Consultar todos los artículos de la tabla
$sql = "SELECT * FROM articulos";
#$sql = "SELECT * FROM articulos ORDER BY id DESC LIMIT 2";
$stmt = $conn->prepare($sql);
$stmt->execute();
$articulos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Donex</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400&family=Sono:wght@200;300;400;500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-icons.css">
        <link rel="stylesheet" href="css/owl.carousel.min.css">
        <link rel="stylesheet" href="css/owl.theme.default.min.css">
        <link href="css/templatemo-pod-talk.css" rel="stylesheet">
    </head>
    
    <body>
        <main>
            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <a class="navbar-brand me-lg-5 me-0" href="index.php">
                        <img src="images/logo.png" class="logo-image img-fluid" alt="templatemo pod talk">
                    </a>

                    <form action="#" method="get" class="custom-form search-form flex-fill me-3" role="search">
                        <div class="input-group input-group-lg">    
                            <input name="search" type="search" class="form-control" id="search" placeholder="Buscar producto" aria-label="Search">
                            <button type="submit" class="form-control" id="submit">
                                <i class="bi-search"></i>
                            </button>
                        </div>
                    </form>
    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
    
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-lg-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="registrar.html">Regístrate</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="about.html">Acerca de</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Página</a>
                                <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                                    <li><a class="dropdown-item active" href="listing-page.html">Listado</a></li>
                                    <li><a class="dropdown-item" href="publicararticulo-page.html">Publicar</a></li> 
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="contact.html">Contáctanos</a>
                            </li>
                        </ul>
                        <div class="ms-4">
                            <a href="#section_2" class="btn custom-btn custom-border-btn smoothscroll">Empezar</a>
                        </div>
                    </div>
                </div>
            </nav>
            
            <header class="site-header d-flex flex-column justify-content-center align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-12 text-center">
                            <h2 class="mb-0">Listado</h2>
                        </div>
                    </div>
                </div>
            </header>

            <section class="latest-podcast-section section-padding" id="section_2">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-12 col-12">
                            <div class="section-title-wrap mb-5">
                                <h4 class="section-title">Artículos</h4>
                            </div>
                        </div>

                        <?php
                        // Iniciar un bucle para mostrar cada artículo
                        foreach ($articulos as $articulo) {
                            ?>
                            <div class="col-lg-6 col-12 mb-4 mb-lg-0">
                                <div class="custom-block d-flex">
                                    <div class="">
                                        <div class="custom-block-icon-wrap">
                                            <div class="section-overlay"></div>
                                            <a href="detail-page.html?id=<?php echo $articulo['id']; ?>" class="custom-block-image-wrap">
                                                <img src="<?php echo $articulo['rutaFoto']; ?>" class="custom-block-image img-fluid" alt="">
                                            </a>
                                        </div>
                                        <div class="mt-2">
                                            <a href="#" class="btn custom-btn">Adquirir</a>
                                        </div>
                                    </div>
                                    <div class="custom-block-info">
                                        <h5 class="mb-2">
                                            <a href="detail-page.html?id=<?php echo $articulo['id']; ?>">
                                                <?php echo htmlspecialchars($articulo['nombreArticulo']); ?>
                                            </a>
                                        </h5>
                                        <div class="profile-block d-flex">
                                            <p><strong>Donador</strong></p>
                                        </div>
                                        <p class="mb-0">
                                            <?php echo htmlspecialchars($articulo['descripcion']); ?>
                                        </p>
                                    </div>
                                    <div class="d-flex flex-column ms-auto">
                                        <a href="#" class="badge ms-auto"><i class="bi-heart"></i></a>
                                        <a href="#" class="badge ms-auto"><i class="bi-bookmark"></i></a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        } // Fin del bucle foreach
                        ?>
                    </div>
                </div>
            </section>

            </main>

        <footer class="site-footer">
            <div class="container">
                </div>
            <div class="container pt-5">
                </div>
        </footer>

        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/owl.carousel.min.js"></script>
        <script src="js/custom.js"></script>

    </body>
</html>