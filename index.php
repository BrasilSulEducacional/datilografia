<?php
require __DIR__ . "/source/functions.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<!-- ?ts=<?= time() ?> -->

<head>
    <link rel="stylesheet" href="assets/css/exercicios.css">
    <link rel="stylesheet" href="assets/css/textos.css">
    <link rel="stylesheet" href="assets/css/ranking.css?ts=<?= time() ?>">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/cadastro.css">
    <link rel="stylesheet" href="assets/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta property="og:site_name" content="Brasil Sul educacional - Datilografia">
    <meta property="og:title" content="Brasil Sul educacional - Datilografia" />
    <meta property="og:description" content="Realize exercícios de datilografia para aprimorar a posição e velocidade na hora da digitação" />
    <meta property="og:image" itemprop="image" content="./assets/images/type.svg">
    <meta property="og:type" content="website" />

    <title>Datilografia</title>

    <style>
        #tooltip {
            background: #333;
            color: white;
            font-weight: bold;
            padding: 4px 8px;
            font-size: 13px;
            border-radius: 4px;
            position: relative;
        }

        #arrow,
        #arrow::before {
            position: absolute;
            width: 8px;
            height: 8px;
            background: inherit;
        }

        #arrow {
            visibility: hidden;
        }

        #arrow::before {
            visibility: visible;
            content: '';
            transform: rotate(45deg);
        }

        #tooltip[data-popper-placement^='top']>#arrow {
            bottom: -4px;
        }

        #tooltip[data-popper-placement^='bottom']>#arrow {
            top: -4px;
        }

        #tooltip[data-popper-placement^='left']>#arrow {
            right: -4px;
        }

        #tooltip[data-popper-placement^='right']>#arrow {
            left: -4px;
        }
    </style>
</head>

<body>
    <script src="assets/js/log.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="https://releases.jquery.com/git/ui/jquery-ui-git.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script type="application/javascript" src="https://polyfill.io/v3/polyfill.min.js?features=ResizeObserver"></script>
    <script src="assets/js/popper.min.js"></script>

    <header>
        <nav class="navbar">
            <ul class="navbar-menu">
                <li><a class="<?= (isset($_GET["pg"]) && $_GET["pg"] == "home" ? "active" : "") ?>" data-url="home.php" href="?pg=home"> <b>Datilografia </b> </a></li>
                <li><a class="<?= (isset($_GET["pg"]) && $_GET["pg"] == "speedtype" ? "active" : "") ?>" data-url="speedtype.php" href="?pg=speedtype">Teste de digitação</a></li>
                <li><a class="<?= (isset($_GET["pg"]) && $_GET["pg"] == "ranking" ? "active" : "") ?>" data-url="ranking.php" href="?pg=ranking">Ranking <i class="fas fa-trophy"></i></a></li>
                <li><a class="<?= (isset($_GET["pg"]) && $_GET["pg"] == "exercicios" ? "active" : "") ?>" data-url="exercicios.php" href="?pg=exercicios">Exercícios <i class="fas fa-keyboard"></i></a></li>
                <li><a class="<?= (isset($_GET["pg"]) && $_GET["pg"] == "textos" ? "active" : "") ?>" data-url="textos.php" href="?pg=textos">Textos <i class="fas fa-text-height"></i> </a></li>
                <!-- <li><a class="<?= (isset($_GET["pg"]) && $_GET["pg"] == "cadastro" ? "active" : "") ?>" href="?pg=cadastro">Faça seu cadastro <i class="fas fa-user-plus"></i> </a></li> -->

                <li>
                    <a href="#" id="changeTheme" aria-describedby="tooltip"> <i class="fas fa-moon"></i> </a>
                </li>

            </ul>
            <ul class="navbar-menu menu-right">
                <li><a href="adm/index.php">Adm <i class="fas fa-user-lock"></i></a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="container">
            <?php
            if (!empty($_GET["pg"])) {
                require __DIR__ . "/{$_GET["pg"]}.php";
            } else {
                require __DIR__ . "/home.php";
            }
            ?>

        </div>
    </main>
    <footer>
    </footer>
    <script>
        $(function() {
            const $buttonTheme = document.querySelector("#changeTheme");
            const $tooltip = document.querySelector("#tooltip");


            // const popperThemeTooltip = Popper.createPopper($buttonTheme, $tooltip, {
            //     placement: 'bottom',
            //     modifiers: [{
            //         name: 'offset',
            //         options: {
            //             offset: [0, 8],
            //         },
            //     }, ],
            // });

            const theme = localStorage.getItem("theme");

            if (theme) {
                document.documentElement.classList.add(theme);
                $($tooltip).hide();

            }

            function toggleTheme() {
                document.documentElement.classList.toggle("dark");

                var className = document.documentElement.className;

                localStorage.setItem("theme", className);
            }

            $("a#changeTheme").click(function(e) {
                e.preventDefault();
                $($tooltip).hide();

                toggleTheme();
            });

            // $("a").click(function(e) {
            //     e.preventDefault();

            //     var $a = $(this);
            //     var url = $a.data("url");

            //     console.log($a.data("url"))

            //     $.ajax({
            //         type: "GET",
            //         url: url,
            //         data: {
            //             codigo: 6900
            //         },
            //         success: function(html) {
            //             console.log($(html))
            //             $(".container").html(html)
            //         }
            //     });
            // });
        });
    </script>
    <?= insert("js") ?>
</body>

</html>