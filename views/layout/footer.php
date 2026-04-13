</div>

<div id="modal-delete" class="modal">
    <div class="modal-content">
        <p>Tem certeza que deseja excluir?</p>

        <div class="modal-buttons">
            <button id="confirm-delete" class="btn btn-delete">Excluir</button>
            <button id="cancel-delete" class="btn btn-secondary">Cancelar</button>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById("modal-delete");

    function confirmarExclusao(url) {
        modal.classList.add("show");

        document.getElementById("confirm-delete").onclick = function() {
            window.location.href = url;
        };

        document.getElementById("cancel-delete").onclick = function() {
            modal.classList.remove("show");
        };
    }

    window.onclick = function(e) {
        if (e.target === modal) {
            modal.classList.remove("show");
        }
    };

    function formatarDuracao(input) {
        let v = input.value.replace(/\D/g, '').slice(0,6);

        if (v.length >= 5)
            input.value = v.replace(/(\d{2})(\d{2})(\d{1,2})/, "$1:$2:$3");
        else if (v.length >= 3)
            input.value = v.replace(/(\d{2})(\d{1,2})/, "$1:$2");
        else
            input.value = v;
    }
</script>

</body>
</html>