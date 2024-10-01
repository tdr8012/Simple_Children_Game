<?php
require_once '../../db/Database.php';
 
$database = new Database();
$db = $database->getConnection();
 
$db_selected = mysqli_select_db($db, 'kidsGames');
if (!$db_selected) {
    die ('Can\'t use the DB : ' . mysqli_error($db));
}
 
$query = 'SELECT scoreTime, id, fName, lName, result, livesUsed FROM history';
$result = mysqli_query($db, $query);
 
if (!$result) {
    die('Invalid query: ' . mysqli_error($db));
}
 
while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td>'.htmlspecialchars($row['scoreTime']).'</td>';
    echo '<td>'.htmlspecialchars($row['id']).'</td>';
    echo '<td>'.htmlspecialchars($row['fName']).'</td>';
    echo '<td>'.htmlspecialchars($row['lName']).'</td>';
    echo '<td>'.htmlspecialchars($row['result']).'</td>';
    echo '<td>'.htmlspecialchars($row['livesUsed']).'</td>';
    echo '</tr>';
}
 
echo '            </tbody>';
echo '        </table>';
echo '    </div>';
echo '</body>';
echo '</html>';
?>