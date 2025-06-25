<?php
$title = 'About - Windows Longbridge';
$currentPage = 'about';
include __DIR__ . '/includes/header.php';
?>
<div class="panel">
  <h2><img width="100" src="https://www.iconshock.com//image/SUPERVISTA/general/help" alt="">What Is Longbridge?</h2>
  <p>Longbridge is a passion project, imagining a "final" Longhorn built on modern Windows foundations. It combines the best of pre-reset build 5048 with Vista-era polish.</p>
  <ul>
    <li>Hybrid DWM/Aero visuals with WinFS-inspired touches</li>
    <li>Classic apps and retro widgets revived</li>
    <li>Longhorn and Vista sounds for nostalgia</li>
    <li>Stable Windows 10 base without bloat</li>
  </ul>
</div>
<div class="panel">
  <h2><img width="80" src="https://www.iconshock.com/image/RealVista/Mobile/info" alt="">Reminder</h2>
  <p>Longbridge is not affiliated with Microsoft. Use it at your own risk and please credit the project if you redistribute modifications.</p>
</div>
<div class="panel">
  <h2><img width="80" src="https://www.iconshock.com/image/RealVista/Mobile/faq" alt="">FAQ</h2>
  <p><strong>How do I activate Windows?</strong><br>Run the following PowerShell command with the KMS option:</p>
  <pre>irm https://get.activated.win/ | iex</pre>
  <p><strong>VirtualBox product key error?</strong><br>Power off the VM, uncheck Floppy in System &gt; Boot Order, delete the <em>Unattended</em> files from your VM folder and start the VM again.</p>
  <p><strong>Guide for best experience?</strong><br>Make sure to read the included <code>buildinfo.txt</code>.</p>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>