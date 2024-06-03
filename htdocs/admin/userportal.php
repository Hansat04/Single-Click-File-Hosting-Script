<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex">
      <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Admin-Seite</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #222;
            color: #fff;
        }

        h1 {
            text-align: center;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        .button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
        }

        .button.primary {
            background-color: #4CAF50;
            color: white;
        }

        .button.primary:hover {
            background-color: #45a049;
        }

        .status {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }

        .active {
            color: green;
        }

        .inactive {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin-Seite</h1>
        <p>Hier kannst du das Benutzerportal ein- oder ausschalten:</p>
        <button id="toggleButton" class="button primary">Benutzerportal ein/ausschalten</button>
        <div id="statusMessage" class="status"></div>
    </div>

    <script>
        // Führe diese Funktion aus, wenn das Dokument vollständig geladen ist
        document.addEventListener("DOMContentLoaded", function() {
            // Derzeitiger Status des Benutzerportals (0 = deaktiviert, 1 = aktiviert)
            var status = 0; // Annahme: Portal ist standardmäßig deaktiviert

            // Button-Element auswählen
            var toggleButton = document.getElementById("toggleButton");
            // Status-Meldungs-Element auswählen
            var statusMessage = document.getElementById("statusMessage");

            // Funktion zum Aktualisieren der Statusmeldung
            function updateStatusMessage() {
                statusMessage.innerHTML = (status === 1) ? "<span class='active'>Aktiviert</span>" : "<span class='inactive'>Inaktiv</span>";
            }

            // Funktion zum Laden des Status aus der CSV-Datei
            function loadStatusFromCSV() {
                // Hier kannst du den Pfad zur CSV-Datei angeben
                var csvFile = '../Speicher/userportal.csv';

                // Lese den Inhalt der CSV-Datei mittels XMLHttpRequest
                var request = new XMLHttpRequest();
                request.open('GET', csvFile, true);
                request.onreadystatechange = function() {
                    if (request.readyState === XMLHttpRequest.DONE && request.status === 200) {
                        var csvData = request.responseText;

                        // Überprüfe, ob "1" in der CSV-Datei vorhanden ist
                        status = (csvData.includes('1')) ? 1 : 0;

                        // Aktualisiere die Statusmeldung
                        updateStatusMessage();
                    }
                };
                request.send();
            }

            // Lade den Status aus der CSV-Datei beim Laden der Seite
            loadStatusFromCSV();

            // Eventlistener hinzufügen, um den Status zu ändern, wenn der Knopf gedrückt wird
            toggleButton.addEventListener("click", function() {
                // Status umschalten
                status = 1 - status;

                // Nachricht zusammenstellen basierend auf dem neuen Status
                var message = (status === 1) ? "Benutzerportal wurde aktiviert!" : "Benutzerportal wurde deaktiviert!";

                // Meldung anzeigen
                alert(message);

                // Aktualisiere die Statusmeldung
                updateStatusMessage();

                // Hier kannst du den Status an den Server senden, um ihn zu speichern und zu verarbeiten
                // In diesem Beispiel wird der Status nur lokal geändert und angezeigt
            });
        });
    </script>
    <footer class="footera">
    <div>
        <h1 class="right"><a class="bauttona" href="adminpanel5.php">Statistiken</a></h1>
    </div>
    <div>
        <h1 class="right"><a class="bauttona" href="adminpanel4.php">Datei-Typen</a></h1>
    </div>
    <div>
        <h1 class="right"><a class="bauttona" href="adminpanel3.php">Benutzer-Verwaltung</a></h1>
    </div>
    <div>
        <h1 class="right"><a class="bauttona" href="adminpanel2.php">Upload-Grenze</a></h1>
    </div>
    <div>
        <h1><a class="bauttona" href="admindelete.php">Löschen</a></h1>
    </div>
</footer>
</body>
</html>
