<!DOCTYPE html>
<html>
<body>

<?php
require_once __DIR__ . "/../db/include.php";
Users::logoutUser();
?>

<script>
window.location = "../movies.php";
</script>

</body>
</html>
