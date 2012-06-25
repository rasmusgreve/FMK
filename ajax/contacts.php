<?php
include "../config.php";
session_start();
include "../classes/User.php";
if (User::Current() == User::USERTYPE_NONE) return;
if (!isset($_GET['venue']) || !is_numeric($_GET['venue'])) return;
?>

<option value='0'>V&aelig;lg kontaktperson</option>
<?php
$venue_id = $_GET['venue'];
$contact_type = $_GET['type'];
$contacts_query = mysql_query("SELECT * FROM `contact` WHERE `venue` = '$venue_id' ORDER BY `name` DESC;");

$selected_id = 0;
$venue_query = mysql_query("SELECT * FROM `venue` WHERE `id` = '$venue_id' LIMIT 1;");
$venue = mysql_fetch_assoc($venue_query);
if (isset($venue[$contact_type]))
	$selected_id = $venue[$contact_type];

while ($res = mysql_fetch_assoc($contacts_query))
{
	if ($selected_id == $res['id'])
	{
		echo "<option value='{$res['id']}' selected>{$res['name']} - {$res['phone']}</option>";
	}
	else
	{
		echo "<option value='{$res['id']}'>{$res['name']} - {$res['phone']}</option>";
	}
}
?>