document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.querySelector('.sidebar');
    const menuState = localStorage.getItem('menuState');

    // Désactiver temporairement les transitions
    sidebar.classList.add('no-transition');

    // Appliquer l'état sauvegardé du menu
    if (menuState === 'retracted') {
        sidebar.classList.add('active'); // Menu rétracté
    } else {
        sidebar.classList.remove('active'); // Menu déployé
    }

    // Forcer le rafraîchissement du style sans transition, puis la réactiver
    setTimeout(() => {
        sidebar.classList.remove('no-transition');
    }, 50); // Petit délai pour éviter toute animation visible
});

document.getElementById('burger').addEventListener('click', function () {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('active');
    
    // Sauvegarder l'état du menu dans localStorage
    if (sidebar.classList.contains('active')) {
        localStorage.setItem('menuState', 'retracted'); // Menu rétracté
    } else {
        localStorage.setItem('menuState', 'expanded'); // Menu déployé
    }
});


// filtre de recherche

document.addEventListener('DOMContentLoaded', function() {
    // Vérifiez la présence de chaque élément et appelez filterTable uniquement s'ils existent
    const searchUsersInput = document.getElementById('searchUsers');
    if (searchUsersInput) {
        filterTable('searchUsers', '.table-wrapper:nth-child(1) .user-table');
    }

    const searchBannedInput = document.getElementById('searchBanned');
    if (searchBannedInput) {
        filterTable('searchBanned', '.table-wrapper:nth-child(2) .user-table');
    }

    const searchCategoryInput = document.getElementById('searchCategory');
    if (searchCategoryInput) {
        filterTable('searchCategory', '.user-table');
    }
    const searchEditeurInput = document.getElementById('searchEditeurs');
    if (searchEditeurInput) {
        filterTable('searchEditeurs', '.editeur-table');
    }
});

function filterTable(inputId, tableSelector) {
    const input = document.getElementById(inputId);
    const table = document.querySelector(tableSelector);

    // Arrêtez la fonction si input ou table n'existe pas
    if (!input || !table) return;

    const rows = table.querySelectorAll('tbody tr');

    input.addEventListener('input', function() {
        const filter = this.value.toLowerCase();
        rows.forEach(row => {
            const cellText = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            if (cellText.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
}
