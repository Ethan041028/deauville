<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Météo Marine - Deauville</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        header {
            background-color: #0077b6;
            color: white;
            padding: 20px;
            text-align: center;
        }
        main {
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #0077b6;
            color: white;
        }
        footer {
            text-align: center;
            padding: 10px;
            background-color: #0077b6;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Météo Marine - Deauville</h1>
        <p>Consultez et gérez les alertes marines pour la ville de Deauville</p>
    </header>
    <main>
        <h2>Prochaines Alertes</h2>
        <table id="alertsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Type d'Alerte</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Les alertes seront insérées ici -->
            </tbody>
        </table>
        <h3>Ajouter une nouvelle alerte</h3>
        <form id="addAlertForm">
            <input type="text" id="alertDate" placeholder="Date (YYYY-MM-DD)" required>
            <input type="text" id="alertType" placeholder="Type d'Alerte" required>
            <input type="text" id="alertDescription" placeholder="Description" required>
            <button type="submit">Ajouter</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2023 Météo Marine Deauville. Tous droits réservés.</p>
    </footer>

    <script>
        const apiUrl = 'https://deauville.onrender.com';

        // Charger les alertes
        function loadAlerts() {
            fetch(apiUrl)
                .then(response => response.json())
                .then(alerts => {
                    const tableBody = document.querySelector('#alertsTable tbody');
                    tableBody.innerHTML = '';
                    alerts.forEach((alert, index) => {
                        const row = `
                            <tr>
                                <td>${index}</td>
                                <td>${alert.date || 'N/A'}</td>
                                <td>${alert.type || 'N/A'}</td>
                                <td>${alert.description || 'N/A'}</td>
                                <td>
                                    <button onclick="deleteAlert(${index})">Supprimer</button>
                                </td>
                            </tr>
                        `;
                        tableBody.innerHTML += row;
                    });
                })
                .catch(error => console.error('Erreur lors du chargement des alertes :', error));
        }

        // Ajouter une alerte
        document.getElementById('addAlertForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const newAlert = {
                date: document.getElementById('alertDate').value,
                type: document.getElementById('alertType').value,
                description: document.getElementById('alertDescription').value
            };
            fetch(apiUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(newAlert)
            })
            .then(() => {
                loadAlerts();
                this.reset();
            })
            .catch(error => console.error('Erreur lors de l\'ajout de l\'alerte :', error));
        });

        // Supprimer une alerte
        function deleteAlert(id) {
            fetch(`${apiUrl}?id=${id}`, { method: 'DELETE' })
                .then(() => loadAlerts())
                .catch(error => console.error('Erreur lors de la suppression de l\'alerte :', error));
        }

        // Charger les alertes au démarrage
        loadAlerts();
    </script>
</body>
</html>