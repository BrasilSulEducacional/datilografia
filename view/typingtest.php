<div class="box" style="max-width: 75%;">
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
</div>