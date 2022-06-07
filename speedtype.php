<div class="content">
    <?php // if (empty($_GET["mode"]) && !empty($_GET["test"])) : 
    ?>
    <?php if (empty($_GET["mode"])) : ?>
        <div class="select-card">
            <div class="card">
                <div class="card-header">
                    <img src="assets/images/unratedmode.svg" alt="teclado svg">
                </div>
                <div class="card-body">
                    <div class="card-content-text">
                        <h2>Teste sua Velocidade Comum</h2>
                        <p>Teste de digitação comum sem revelar pontuação ou classificação.</p>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="card-content-button">
                        <a href="?pg=speedtype&mode=normal" data-mode="normal">COMEÇAR</a>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <img src="assets/images/compmode.svg" alt="teclado svg">
                </div>
                <div class="card-body">
                    <div class="card-content-text">
                        <h2>Teste de Digitação por Classificação</h2>
                        <p>Descubra qual a sua classificação e a melhore.</p>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="card-content-button">
                        <a href="?pg=speedtype&mode=comp" data-mode="comp">COMEÇAR</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- <div class="box" style="max-width: 75%; display: none;">
        <div class="text-config">
            <div class="group-config">
                <span>Código:</span>
                <input type="text" id="codigo" maxlength="4" autocomplete="off" style="outline: none;">
            </div>
            <div class="group-config arrow">
                <span>Dificuldade:</span>
                <select id="difficult">
                    <option value="hard">Difícil</option>
                    <option value="medium">Médio</option>
                    <option value="easy" selected>Fácil</option>
                </select>
            </div>
            <div class="new-text-button">
                <button tabindex="0"> <i class="fa fa-redo"></i> <span>(TAB + ENTER)</span></button>
            </div>
        </div>
        <div class="message message-alert">
            <span>Digite seu código antes de começar</span>
        </div>
        <div class="text">
            <input type="text" name="text" id="user-type" autocomplete="off">
            <div class="circle-loader" style="width: 300px; display: flex; justify-content: center;">
                <div class="load"></div>
            </div>
            <div class="text-test">

            </div>
            <div class="text-status">
                <div class="status-wpm">
                    <h1 id="wpm">0</h1>
                    <span>PPM (PALAVRAS POR MINUTO)</span>
                </div>
                <div class="status-precision">
                    <h1 id="accuracy">100%</h1>
                    <span>Precisão</span>
                </div>
            </div>
        </div>
        <div class="text-footer" style="display: none;">
            <button class="text-restart">Começar Novamente</button>
        </div>
    </div> -->
    <?php //endif; 
    ?>


    <?php if (!empty($_GET["mode"]) && $_GET["mode"] == "normal") : ?>
        <?php require __DIR__ . "/view/typingtest.php" ?>
    <?php endif; ?>

    <?php if (!empty($_GET["mode"]) && $_GET["mode"] == "comp") : ?>
        <?php require __DIR__ . "/view/compmode.php" ?>
    <?php endif; ?>

</div>
<?php startHtml("js"); ?>
<script>
    $(function() {
        var $script = $("<script/>").attr("type", "text/javascript");

        $(".card * a[href]").click(function(e) {
            e.preventDefault();

            var url = $(this).attr("href");
            var mode = $(this).data("mode");

            window.history.pushState("/", document.title, url);

            if (mode == "normal") {
                $(".content").load("view/typingtest.php", function() {
                    $script.attr("src", "./assets/js/typingtest.js").appendTo("body");
                });
            }

            if (mode == "comp") {
                $(".content").load("view/compmode.php", function() {
                    $script.attr("src", "./assets/js/compmode.js?ts=<?= time() ?>").appendTo("body");
                });
            }
        });
    });
</script>
<!-- <script src="./assets/js/typingtest.js"></script> -->

<?php if (!empty($_GET["mode"]) && $_GET["mode"] == "normal") : ?>
    <script src="./assets/js/typingtest.js"></script>
<?php endif; ?>

<?php if (!empty($_GET["mode"]) && $_GET["mode"] == "comp") : ?>
    <script src="./assets/js/compmode.js?ts=<?= time() ?>"></script>
<?php endif; ?>

<?php endHtml(); ?>