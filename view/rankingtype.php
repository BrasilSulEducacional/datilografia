<div class="ranking-players" style="border: none;">
    <div class="ranking-header">
        <div class="ranking-options">
            <div class="ranking-config">
                <span style="font-weight: 900; font-size: 2em;">
                    <!-- <i class="fas fa-trophy"></i> -->
                    Ranking por digitação
                    <!-- <i class="fas fa-trophy"></i> -->
                </span>
                <div class="difficult-buttons">
                    <button id="diffEasy" class="active" data-diff="easy" style="display: none;">Fácil</button>
                    <!-- <button id="diffMedium" data-diff="medium">Médio</button>
                        <button id="diffHard" data-diff="hard">Difícil</button> -->
                    <div class="group-config">
                        <span>Mês:</span>
                        <select name="month" id="month">
                            <option <?= ("01" == date("m") ? "selected='selected'" : "") ?> value="01">Janeiro</option>
                            <option <?= ("02" == date("m") ? "selected='selected'" : "") ?> value="02">Fevereiro</option>
                            <option <?= ("03" == date("m") ? "selected='selected'" : "") ?> value="03">Março</option>
                            <option <?= ("04" == date("m") ? "selected='selected'" : "") ?> value="04">Abril</option>
                            <option <?= ("05" == date("m") ? "selected='selected'" : "") ?> value="05">Maio</option>
                            <option <?= ("06" == date("m") ? "selected='selected'" : "") ?> value="06">Junho</option>
                            <option <?= ("07" == date("m") ? "selected='selected'" : "") ?> value="07">Julho</option>
                            <option <?= ("08" == date("m") ? "selected='selected'" : "") ?> value="08">Agosto</option>
                            <option <?= ("09" == date("m") ? "selected='selected'" : "") ?> value="09">Setembro</option>
                            <option <?= ("10" == date("m") ? "selected='selected'" : "") ?> value="10">Outubro</option>
                            <option <?= ("11" == date("m") ? "selected='selected'" : "") ?> value="11">Novembro</option>
                            <option <?= ("12" == date("m") ? "selected='selected'" : "") ?> value="12">Dezembro</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ranking-content">
        <div class="main-players">
            <div class="ranking-first-place">
                <div class="placing">
                    <i class="fas fa-trophy"></i>
                    <span>1</span>
                </div>
                <div class="player-class" style="display: none;">
                    <img src="https://datilografia.brasilsuleducacional.com.br/assets/images/ranking" alt="ranking" class="ranking-image-sm">
                </div>
                <div class="player-name">
                    <h3></h3>
                </div>
                <div class="player-data"></div>
            </div>
            <div class="ranking-second-place">
                <div class="placing">
                    <i class="fas fa-trophy"></i>
                    <span>2</span>
                </div>
                <div class="player-class" style="display: none;">
                    <img src="https://datilografia.brasilsuleducacional.com.br/assets/images/ranking" alt="ranking" class="ranking-image-sm">
                </div>
                <div class="player-name">
                    <h3></h3>
                </div>
                <div class="player-data"></div>
            </div>
            <div class="ranking-third-place">
                <div class="placing">
                    <i class="fas fa-trophy"></i>
                    <span>3</span>
                </div>
                <div class="player-class" style="display: none;">
                    <img src="https://datilografia.brasilsuleducacional.com.br/assets/images/ranking" alt="ranking" class="ranking-image-sm">
                </div>
                <div class="player-name">
                    <h3></h3>
                </div>
                <div class="player-data"></div>
            </div>
        </div>
        <div class="other-players" data-repeat="10"></div>
    </div>
    <div class="ranking-footer"></div>
</div>