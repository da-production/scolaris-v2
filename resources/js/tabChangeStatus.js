
(function () {
    let timer = null;

    // Remplace cette fonction par ton propre appel API de déconnexion
    async function logout() {
        // Exemple : appel à une API pour déconnecter l'utilisateur
        console.log('Déconnexion de l’utilisateur...');
        const form = document.getElementById('logout-form');
        if(!!form){
            alert('Votre session a expiré, vous allez être déconnecté.');
            form.submit();
        }
        // await fetch('/api/logout', { method: 'POST' });
    }


    // Démarrer le timer d'inactivité
    function startTimer() {
        timer = setTimeout(async () => {
            try {
                await logout();
            } catch (err) {
                console.error('Erreur de déconnexion', err);
            }
        }, 15 * 60 * 1000); // 15 minutes
    }

    // Annuler le timer si l'utilisateur revient
    function clearTimer() {
        if (timer) {
            clearTimeout(timer);
            timer = null;
        }
    }

    // Gérer le changement de visibilité de l'onglet
    function handleVisibilityChange() {
        if (document.visibilityState === 'hidden') {
            startTimer();
            console.log('hidden timer:', timer);
        } else if (document.visibilityState === 'visible') {
            clearTimer();
            console.log('visible timer:', timer);
        }
    }

    // Ajouter l'écouteur lors du chargement de la page
    window.addEventListener('DOMContentLoaded', () => {
        document.addEventListener('visibilitychange', handleVisibilityChange);
    });

    // Supprimer l'écouteur avant que la page soit déchargée
    window.addEventListener('beforeunload', () => {
        document.removeEventListener('visibilitychange', handleVisibilityChange);
        clearTimer();
    });
})();
