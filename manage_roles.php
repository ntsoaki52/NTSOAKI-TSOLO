<?php
$conn = new mysqli("localhost", "root", "", "iwb_re");
$result = $conn->query("SELECT * FROM roles");
?>

<h2>Manage Roles</h2>
<table border="1">
<tr><th>ID</th><th>Role Name</th></tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= $row['role_name'] ?></td>
</tr>
<?php endwhile; ?>
</table>
