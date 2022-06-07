<div class="content">
    <?php if (empty($_GET["by"])) : ?>
        <div class="leaderboard">
            <div class="leaderboard-header">
                <span>Selecione a tabela:</span>
                <select name="byRanking" id="byRanking">
                    <option value="class">Por classificação</option>
                    <option value="type">Por digitação</option>
                </select>
            </div>
            <div class="leaderboard-main"></div>
            <div class="leaderboard-footer"></div>
        </div>
    <?php endif; ?>

    <?php if (!empty($_GET["by"]) && $_GET["by"] == "type") : ?>
        <?php require __DIR__ . "/view/rankingtype.php" ?>
    <?php endif; ?>

    <?php if (!empty($_GET["by"]) && $_GET["by"] == "class") : ?>
        <?php require __DIR__ . "/view/rankingclass.php" ?>
    <?php endif; ?>
</div>

<?php startHtml("js"); ?>
<script>
    $(function() {
        var $script = $("<script/>").attr("type", "text/javascript");
        $script.attr("id", "usingScript");

        $("select#byRanking").change(function(e) {
            // e.preventDefault();

            var value = $(this).val();

            // window.history.pushState("/", document.title, url);

            if (value == "class") {
                $(".leaderboard-main").load("view/rankingclass.php", function() {
                    $("#usingScript").remove();
                    $script.attr("src", "./assets/js/rankingclass.js?ts=<?= time() ?>").appendTo("body");
                });
            }

            if (value == "type") {
                $(".leaderboard-main").load("view/rankingtype.php", function() {
                    $("#usingScript").remove();
                    $script.attr("src", "./assets/js/rankingtype.js?ts=<?= time() ?>").appendTo("body");
                });
            }
        });
    });
</script>

<?php if (!empty($_GET["by"]) && $_GET["by"] == "type") : ?>
    <script src="./assets/js/rankingtype.js?ts=<?= time() ?>"></script>
<?php endif; ?>

<?php if (!empty($_GET["by"]) && $_GET["by"] == "class") : ?>
    <script src="./assets/js/rankingclass.js?ts=<?= time() ?>"></script>
<?php endif; ?>

<?php endHtml(); ?>