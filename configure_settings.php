<?php
$conn = new mysqli("localhost", "root", "", "iwb_admin");
$result = $conn->query("SELECT * FROM settings");
?>

<h2>System Settings</h2>
<table border="1">
<tr><th>Key</th><th>Value</th></tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
<td><?= $row['setting_key'] ?></td>
<td><?= $row['setting_value'] ?></td>
</tr>
<?php endwhile; ?>
</table>
