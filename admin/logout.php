<?php
// Session start karna zaroori hai taaki use access karke band kiya ja sake
session_start();

// 1. Saare session variables ko khali karein
$_SESSION = array();

// 2. Agar session cookies use ho rahi hain (standard PHP behavior), toh unhe expire karein
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 3. Server se session ko puri tarah destroy (khatam) karein
session_destroy();

// 4. Logout hone ke baad user ko Login page (index.php) par bhej dein
header("location: index.php");
exit();
?>