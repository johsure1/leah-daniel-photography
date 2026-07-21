<?php  

require_once 'config.php';
require_once 'backend.php';

$messages = selectContact($pdo);

?>

        <h3 style="margin-bottom:14px;">Recent Messages</h3>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>From</th><th>Email</th><th>message</th><th>Date</th></tr>
                </thead>
                <tbody>


                <?php foreach($messages as $m): ?>

                    <tr>
                        <td><?php echo htmlspecialchars($m['name'] ?? '') ?></td>
                        <td><?php echo htmlspecialchars($m['email'] ?? '') ?></td>
                        <td><?php echo htmlspecialchars($m['message'] ?? '') ?></td>
                        <td><?php echo htmlspecialchars($m['created_at'] ?? '') ?></td>
                    </tr>

                <?php endforeach; ?>
                </tbody>
            </table>
        </div>