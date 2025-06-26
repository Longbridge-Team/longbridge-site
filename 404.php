<?php
http_response_code(404);
$title = '404 Not Found - Windows Longbridge';
include __DIR__ . '/includes/header.php';
?>
<div class="panel">
  <h2><img width="80" src="https://www.iconshock.com/image/RealVista/General/error" alt="">Page Not Found (404)</h2>
  <p>The page you're looking for could not be found. It may have been moved or deleted.</p>
  <p><a href="/index.aspx">Return to the homepage</a></p>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
