<?php
require_once '../auth/config.php';

$stmt = $pdo->prepare("
    SELECT 
        s.id AS sacco_id,
        s.name AS sacco_name,
        COALESCE(AVG(r.rating), 0) AS avg_rating,
        COALESCE(COUNT(i.id), 0) AS incident_count,
        ((COALESCE(AVG(r.rating), 0) * 20) - (COALESCE(COUNT(i.id), 0) * 5)) AS score
    FROM 
        sacco_cooperatives s
    LEFT JOIN 
        matatus m ON s.id = m.sacco_id
    LEFT JOIN 
        ratings r ON m.id = r.matatu_id
    LEFT JOIN 
        incidents i ON m.id = i.matatu_id
    GROUP BY 
        s.id, s.name
    ORDER BY 
        score DESC, avg_rating DESC
    LIMIT 4
");

$stmt->execute();
$saccos = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($saccos as $index => $sacco) { 
    $saccos[$index]['rank'] = $index + 1;

    $performance_score = ($sacco['avg_rating'] * 20) - ($sacco['incident_count'] * 5);

    if ($performance_score >= 90) {
        $saccos[$index]['performance'] = ['class' => 'badge-success', 'text' => 'Excellent'];
    } elseif ($performance_score >= 70) {
        $saccos[$index]['performance'] = ['class' => 'badge-soft badge-primary', 'text' => 'Very Good'];
    } elseif ($performance_score >= 50) {
        $saccos[$index]['performance'] = ['class' => 'badge-soft badge-info', 'text' => 'Good'];
    } else {
        $saccos[$index]['performance'] = ['class' => 'badge-warning', 'text' => 'Needs Improvement'];
    }
}

?>
<div class="backdrop-blur-md backdrop-brightness-150 w-4/5 max-w-2xl md:w-1/2 overflow-x-auto mx-auto mt-10 my-4 rounded-box p-4 border border-info/20">
    <h2 class="text-2xl font-semibold mb-4">SACCOs Leaderboard</h2>
    <table class="table-striped table">
        <thead>
            <tr>
                <th>Rank</th>
                <th>SACCO Name</th>
                <th>Rating</th>
                <th>Incidents</th>
                <th>Performance</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($saccos as $sacco): ?>
            <tr>
                <td class="text-nowrap font-bold"><?= $sacco['rank'] ?></td>
                <td><?= htmlspecialchars($sacco['sacco_name']) ?></td>
                <td><?= number_format($sacco['avg_rating'], 1) ?></td>
                <td><?= $sacco['incident_count'] ?></td>
                <td>
                    <span class="badge <?= $sacco['performance']['class'] ?> text-xs">
                        <?= htmlspecialchars($sacco['performance']['text']) ?>
                    </span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

