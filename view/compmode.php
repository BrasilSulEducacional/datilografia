<div class="box" style="width: 75%">
    <div class="text-config">
        <div class="group-config">
            <span>Código:</span>
            <input type="text" id="codigo" maxlength="4" autocomplete="off" style="outline: none;">
        </div>
        <div class="group-config" style="border: none;">
            <a href="#modal"><i class="fas fa-question-circle"></i></a>
        </div>
        <div class="group-config" style="border: none;">
            <div class="new-text-button">
                <button tabindex="-1"> <i class="fa fa-redo"></i> <span>(TAB + ENTER)</span></button>
            </div>
        </div>
    </div>
    <div class="message message-alert">
        <span>Digite seu código para começar. Ao começar a digitar não poderá solicitar um novo texto, deve ser digitado até o fim.</span>
    </div>
    <div class="test-area">
        <input type="text" name="text" id="user-type" autocomplete="off">
        <div class="circle-loader" style="width: 100%; display: flex; justify-content: center;">
            <div class="load"></div>
        </div>
        <button class="start-button" style="display: none;">Começar Novamente</button>

        <div class="text-test">

        </div>

        <div class="text-status" style="display: flex; justify-content: space-around;">
            <div class="status-wpm" style="text-align: center; display: none;">
                <h1 id="wpm" style="text-align: center; font-size: 4em;">0</h1>
                <span>PPM</span>
            </div>
            <div class="status-precision" style="text-align: center; display: none;">
                <h1 id="accuracy" style="text-align: center; font-size: 4em;">100%</h1>
                <span>Precisão</span>
            </div>
        </div>
    </div>
    <div class="text-footer" style="flex-direction: column; display: none;">
        <div class="ranking-status">
            <div class="current-ranking">
                <img class="ranking-image-lg">
            </div>
            <div class="progressbar">
                <div style="width: 1%"></div>
            </div>
            <div class="next-ranking">
                <img class="ranking-image-lg">
            </div>
        </div>
        <div class="ranking-text">
            <span>
                <span class="current-pts">0</span>
                /
                <span class="badge-pts">100</span>
            </span>
        </div>
    </div>
</div>
<div id="modal" class="modal modal-informacoes">
    <div class="modal-content">
        <div class="modal-header">
            <a href="#fechar" class="fechar">X</a>
            <h2>Informações sobre Testes de digitação por classificação</h2>
        </div>
        <div class="modal-body">
            <p>Partidas por classifcação tem o objetivo de serem competitivas e fazer melhorar as palavras por minuto.</p>
            <p>Todas as partidas que você iniciar terá a chance de ganhar pontos (pts) ou perder, conforme seu desenvolvimento.</p>
            <p>Na primeira vez realizando esse tipo de digitação você vai precisar realizar 5 vezes para resultar em uma classificação.</p>
            <p>São 6 tipos de classificação, que são resultados das 5 partidas que você realizar. Porém como cada partida você tem chance de ganhar pts poderá subir a classificação.</p>
            <div class="modal-informacoes-ranking">
                <div>
                    <img src="../assets/images/ranking/bronze_1.png">
                    <span>Bronze 1</span>
                </div>

                <div>
                    <img src="../assets/images/ranking/bronze_2.png">
                    <span>Bronze 2</span>
                </div>

                <div>
                    <img src="../assets/images/ranking/bronze_3.png">
                    <span>Bronze 3</span>
                </div>
            </div>
            <div class="modal-informacoes-ranking">
                <div>
                    <img src="../assets/images/ranking/prata_1.png">
                    <span>Prata 1</span>
                </div>

                <div>
                    <img src="../assets/images/ranking/prata_2.png">
                    <span>Prata 2</span>
                </div>

                <div>
                    <img src="../assets/images/ranking/prata_3.png">
                    <span>Prata 3</span>
                </div>
            </div>
            <div class="modal-informacoes-ranking">
                <div>
                    <img src="../assets/images/ranking/ouro_1.png">
                    <span>Ouro 1</span>
                </div>

                <div>
                    <img src="../assets/images/ranking/ouro_2.png">
                    <span>Ouro 2</span>
                </div>

                <div>
                    <img src="../assets/images/ranking/ouro_3.png">
                    <span>Ouro 3</span>
                </div>
            </div>
            <div class="modal-informacoes-ranking">
                <div>
                    <img src="../assets/images/ranking/platina_1.png">
                    <span>Platina 1</span>
                </div>

                <div>
                    <img src="../assets/images/ranking/platina_2.png">
                    <span>Platina 2</span>
                </div>

                <div>
                    <img src="../assets/images/ranking/platina_3.png">
                    <span>Platina 3</span>
                </div>

                <div>
                    <img src="../assets/images/ranking/platina_4.png">
                    <span>Platina 4</span>
                </div>
            </div>
            <div class="modal-informacoes-ranking">
                <div>
                    <img src="../assets/images/ranking/diamante_1.png">
                    <span>Diamante 1</span>
                </div>

                <div>
                    <img src="../assets/images/ranking/diamante_2.png">
                    <span>Diamante 2</span>
                </div>

                <div>
                    <img src="../assets/images/ranking/diamante_3.png">
                    <span>Diamante 3</span>
                </div>
            </div>
            <div class="modal-informacoes-ranking">
                <div>
                    <img src="../assets/images/ranking/mestre.png" style="width: 70px;">
                    <span>Mestre</span>
                </div>

                <div>
                    <img src="../assets/images/ranking/grao_mestre.png" style="width: 70px;">
                    <span>Grão-Mestre</span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <!-- <p>Enviamos uma cópia do seu código por e-mail, confira!</p> -->
        </div>
    </div>
</div>

<div id="modalRanking" class="modal modal-ranking">
    <div class="modal-content">
        <div class="modal-header">
            <a href="#fechar" class="fechar">X</a>
            <h2>Novo ranking desbloqueado!</h2>
        </div>
        <div class="modal-body" style="text-align: center;">
            <img src="#" alt="Ranking" style="width:50%;">

            <p style="font-size: 1.6em; font-weight: 900; text-align: center; color: var(--text-color); line-height: 3em;">
                Parabéns você conseguiu <span class="ranking-name" style="font-size: 2em;"></span>
            </p>
        </div>
        <div class="modal-footer">

        </div>
    </div>
</div>