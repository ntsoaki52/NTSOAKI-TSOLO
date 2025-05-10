<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Compliance Documents</title>
    <style>
        body {
            background-color: #121212;
            color: white;
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        a {
            color:rgb(251, 254, 63);
            text-decoration: none;
        }
        li {
            margin-bottom: 8px;
        }
        button {
            background-color:rgb(252, 255, 64);
            color: black;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h1>Compliance Documents</h1>
<p>Browse the latest compliance documents:</p>
<ul>
    <?php
    $dir = "compliance/";
    if (is_dir($dir)) {
        $files = scandir($dir);
        foreach ($files as $file) {
            if ($file !== "." && $file !== "..") {
                echo "<li><a href='$dir$file' target='_blank'>$file</a></li>";
            }
        }
    } else {
        echo "<p>No compliance directory found.</p>";
    }
    ?>
</ul>
<a href="shareholder-dashboard.php"><button>👈Back</button></a>
</body>
</html>
