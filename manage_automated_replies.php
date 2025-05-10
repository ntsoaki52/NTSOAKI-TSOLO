<?php
$conn = new mysqli("localhost", "root", "", "iwb_re");
$result = $conn->query("SELECT * FROM automated_replies");
?>

<h2>Automated Replies</h2>
<table border="1">
<tr><th>Keyword</th><th>Response</th></tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
<td><?= $row['keyword'] ?></td>
<td><?= $row['response'] ?></td>
</tr>
<?php endwhile; ?>
</table>
