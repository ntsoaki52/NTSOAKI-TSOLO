<?php
$conn = new mysqli("localhost", "root", "", "iwb_re");
$result = $conn->query("SELECT users.*, roles.role_name FROM users LEFT JOIN roles ON users.role_id = roles.id");
?>

<h2>Manage Users</h2>
<table border="1">
<tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th></tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= $row['username'] ?></td>
<td><?= $row['email'] ?></td>
<td><?= $row['role_name'] ?></td>
</tr>
<?php endwhile; ?>
</table>
