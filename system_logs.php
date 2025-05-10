<?php
$conn = new mysqli("localhost", "root", "", "iwb_re");
$result = $conn->query("SELECT * FROM system_logs ORDER BY timestamp DESC");
?>

<h2>System Logs</h2>
<table border="1">
<tr><th>ID</th><th>Action</th><th>User ID</th><th>Time</th></tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= $row['action'] ?></td>
<td><?= $row['user_id'] ?></td>
<td><?= $row['timestamp'] ?></td>
</tr>
<?php endwhile; ?>
</table>
