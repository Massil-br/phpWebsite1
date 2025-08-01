

<?php if(isset($_SESSION['message'])): ?>
    <div id="sessionMessage" class="alert alert-danger"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <script defer>
        alert = document.getElementById("sessionMessage");
        if(alert){
            if (!alert.classList.contains('d-none')){
                setTimeout(function(){
                    alert.classList.add('d-none');
                },5000)
            }
        }
    </script>
<?php endif; ?>