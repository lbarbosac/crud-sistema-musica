</div>

<!-- MODAL CONFIG -->
<div id="modal-config" class="modal-config">
    <div class="modal-config-box">
        <h3>Configurações</h3>

        <div class="config-item">
            <span>Exibir confirmações de ações</span>

            <label class="switch">
                <input type="checkbox" id="toggleAvisos">
                <span class="slider"></span>
            </label>
        </div>
    </div>
</div>

<script>
// abrir config
function abrirConfig() {
    document.getElementById("modal-config").classList.add("show");
}

// fechar clicando fora
window.addEventListener("click", function(e){
    const modal = document.getElementById("modal-config");
    if(e.target === modal){
        modal.classList.remove("show");
    }
});

// salvar config
const toggle = document.getElementById("toggleAvisos");

// carregar estado
if(localStorage.getItem("avisos") === "off"){
    toggle.checked = false;
} else {
    toggle.checked = true;
}

// mudar estado
toggle.addEventListener("change", function(){
    localStorage.setItem("avisos", this.checked ? "on" : "off");
});
</script>

</body>
</html>