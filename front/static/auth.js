
let originalBtnText = '';
let registerForm = document.getElementById('registerForm');
let loginForm = document.getElementById('loginForm');
if(registerForm){
    registerForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        loading(true);

        const form = e.target;
        const formData = new FormData(form);

        const data = Object.fromEntries(formData.entries());


        if (data.email !== data.emailConfirm) {
            showMessage("Les emails ne correspondent pas.", true);
            loading(false);
            return;
        }
        if (data.password !== data.passwordConfirm) {
            showMessage("Les mots de passe ne correspondent pas.", true);
            loading(false);
            return;
        }

        try {
        

            const res = await myFetch('../back/register.php', 'POST', data);
            const result = await res.json();
            const stringResult = JSON.stringify(result);
            if (res.ok) {
                showMessage(stringResult || 'Inscription réussie 🎉', false);
                loading(false);
                form.reset(); 
            } else {
                showMessage(result.error || 'Erreur inconnue', true);
                loading(false);
            }
        } catch (err) {
            showMessage('Erreur lors de la requête : ' + err.message, true);
            loading(false);
        }
    });
}else if (loginForm){
    
    loginForm.addEventListener('submit', async function (e){
        e.preventDefault();
        loading(true);

        const form = e.target;
        const formData = new FormData(form);

        const data = Object.fromEntries(formData.entries());

        try {
            const res = await myFetch('../back/login.php', 'POST', data);
            // Vérifier si la réponse est bien du JSON
            const contentType = res.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                throw new Error('La réponse du serveur n\'est pas du JSON valide');
            }
            const result = await res.json();
            if (res.ok) {
                showMessage(result.message || 'Inscription réussie 🎉', false);
                loading(false);
                form.reset();
                setTimeout(function(){
                    window.location.href = './index.php';
                },2000)
                
            } else {
                showMessage(result.error || 'Erreur inconnue', true);
                loading(false);
            }
        } catch (err) {
            showMessage('Erreur lors de la requête : ' + err.message, true);
            loading(false);
        }
    });
}



async function myFetch(url, method, data){
    const res = await fetch(url,{
        method: method,
        headers:{
            'Content-Type':'application/json'
        },
        body: JSON.stringify(data)
    });
    return res;
}

function showMessage(msg, isError = false) {
    const div = document.getElementById('registerMsg');
    div.innerHTML = msg.replace(/,/g, '<br>');
    div.style.color = isError ? 'red' : 'green';
}



function loading(isLoading) {
    const element = document.getElementById('submit-button');
    if (isLoading) {
        originalBtnText = element.textContent;
        element.textContent = "Chargement...";
        element.disabled = true;
    } else {
        element.textContent = originalBtnText;
        element.disabled = false;
    }
}



