<?php
// Turn off error reporting
error_reporting(0);
ini_set('display_errors', 0);

function getUserFiles($username, $csvFile) {
    if (!file_exists($csvFile)) {
        return [];
    }

    $csvData = file_get_contents($csvFile);
    $lines = explode(PHP_EOL, $csvData);
    $userFiles = [];

    foreach ($lines as $line) {
        $data = explode(',', $line);
        if (isset($data[1]) && trim($data[1]) === $username) {
            $userFiles[] = [
                'filename' => $data[0],
            ];
        }
    }

    return $userFiles;
}

// Get filename from POST request
$filename = isset($_POST['filename']) ? $_POST['filename'] : null;

// Path to the CSV file containing user data
$userCsvFile = '../Uploaded_Files/files.csv';

$userFiles = [];
$username = '';

if ($filename) {
    // Retrieve the username for the given filename
    $csvData = file_get_contents($userCsvFile);
    $lines = explode(PHP_EOL, $csvData);
    foreach ($lines as $line) {
        $data = explode(',', $line);
        if (isset($data[0]) && trim($data[0]) === $filename) {
            $username = trim($data[1]);
            break;
        }
    }

    // Get all files for the user
    if ($username) {
        $userFiles = getUserFiles($username, $userCsvFile);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Benutzerdaten</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
    <main>
        <div class="awasr">
            <div><h2>Benutzerdaten für Benutzer: <?php echo htmlspecialchars($username); ?></h2><br></div>
            <div class="maske"><img src="../bilder/vendetta-g41f352c32_1280-modified.png" alt="Guy Fawkes Mask" class="pictureguy"/></div>
            <h1>Benutzerdaten</h1>

            <?php if (!empty($userFiles)): ?>
                <table>
                    <tr>
                        <th>Dateiname</th>
                        <th>Aktionen</th>
                    </tr>
                    <?php foreach ($userFiles as $file): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($file['filename']); ?></td>
                            <td>
                                <button class="green" onclick="manageFile('<?php echo htmlspecialchars($file['filename']); ?>')">Manage File</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <button class="red" onclick="deleteUser('<?php echo htmlspecialchars($username); ?>')">Delete User and Files</button>
            <?php else: ?>
                <p>Keine Dateien für diesen Benutzer gefunden.</p>
            <?php endif; ?>

            <p><a class="buttona" href="adminpanel3.php">Zurück</a>
            <a class="buttona" href="../index.php">HOME</a></p>
            <a class="buttona" href="auswertung.php">Auswertung</a>
        </div>
    </main>

    <script>
        function manageFile(filename) {
            var form = document.createElement("form");
            form.method = "POST";
            form.action = "admindeletedesision.php";

            var input = document.createElement("input");
            input.type = "hidden";
            input.name = "filename";
            input.value = filename;

            form.appendChild(input);
            document.body.appendChild(form);

            form.submit();
        }

        function deleteUser(username) {
            if (confirm("Sind Sie sicher, dass Sie diesen Benutzer und alle seine Dateien löschen möchten?")) {
                var form = document.createElement("form");
                form.method = "POST";
                form.action = "delete_user.php";

                var input = document.createElement("input");
                input.type = "hidden";
                input.name = "username";
                input.value = username;

                form.appendChild(input);
                document.body.appendChild(form);

                form.submit();
            }
        }
    </script>

</body>
</html>
