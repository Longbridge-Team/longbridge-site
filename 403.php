<?php
http_response_code(403);
$title = '403 Forbidden - Windows Longbridge';
include __DIR__ . '/includes/header.php';
?>
<div class="panel">
  <h2><img width="80" src="https://www.iconshock.com//image/REALVISTA/development/logic_error" alt="">Access Denied (403)</h2>
  <p>You do not have permission to access this page.</p>
  <p><a href="/index.aspx">Return to the homepage</a></p>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
