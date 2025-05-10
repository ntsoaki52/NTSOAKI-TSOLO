<?php
$conn = new mysqli("localhost", "root", "", "iwb_re");
$result = $conn->query("SELECT * FROM queries WHERE responded = 0");
?>

<h2>Review Queries</h2>
<table border="1">
<tr><th>Email</th><th>Message</th></tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
<td><?= $row['user_email'] ?></td>
<td><?= $row['message'] ?></td>
</tr>
<?php endwhile; ?>
</table>
