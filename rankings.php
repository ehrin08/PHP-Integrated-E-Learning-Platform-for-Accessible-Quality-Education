<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Rankings</title>
</head>
<body>
    <h1>Quiz Rankings</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Rank</th>
                <th>Username</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rankings as $entry): ?>
                <tr>
                    <td><?php echo $entry['rank']; ?></td>
                    <td><?php echo $entry['username']; ?></td>
                    <td><?php echo $entry['score']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>