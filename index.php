<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<!-- Page Title -->
<title>Windows Longbridge - The Longhorn Experience Reimagined</title>

<!-- Meta Description -->
<meta name="description" content="An immersive recreation of Windows Longhorn on modern os arhitecture, featuring legacy aesthetics with modern enhancements." />
<meta property="og:title" content="Windows Longbridge - The Longhorn Experience Reimagined" />
<meta property="og:description" content="An immersive recreation of Windows Longhorn on modern os architecture, featuring legacy aesthetics with modern enhancements." />
<meta property="og:image" content="https://external-content.duckduckgo.com/iu/?u=http%3A%2F%2Fwww.rw-designer.com%2Ficon-image%2F18837-256x256x4.png&f=1&nofb=1&ipt=f7d794f16772d7f4e0c9a6e94728373825d3c62652593016b99b5592e6f2ea32" />
<meta property="og:type" content="website" />
<meta property="og:url" content="https://ms-longhorn.me" />

<!-- Favicon  -->
<link rel="icon" href="https://external-content.duckduckgo.com/iu/?u=http%3A%2F%2Fwww.rw-designer.com%2Ficon-image%2F18837-256x256x4.png&f=1&nofb=1&ipt=f7d794f16772d7f4e0c9a6e94728373825d3c62652593016b99b5592e6f2ea32" type="image/x-icon" />

<!-- XP-era CSS for legacy look -->
<link rel="stylesheet" href="xp.css">

<style>
  body {
    font-family: Tahoma, "Trebuchet MS", Verdana, sans-serif;
    margin: 0;
    background: #c0d6ff;
    color: #000;
  }
  a { color: #003399; text-decoration: none; }
  a:hover { text-decoration: underline; }

  .top-banner {
    background: #e8ecf4;
    padding: 5px 0;
    text-align: center;
    font-size: 13px;
    border-bottom: 1px solid #779fd9;
  }

  header, footer {
    background: #e8ecf4;
    border-top: 1px solid #779fd9;
    border-bottom: 1px solid #779fd9;
  }
  header {
    display: flex;
    justify-content: center;
    padding: 10px;
  }
  nav ul {
    display: flex;
    gap: 12px;
    list-style: none;
    margin: 0;
    padding: 0;
  }
  nav li a {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    background: linear-gradient(to bottom,#fff,#d4d9e0);
    border: 1px solid #a0a5b0;
    font-size: 13px;
    color: #003399;
  }
  nav li a.active, nav li a:hover {
    background: #d0e4ff;
    border-color: #3a62a0;
    color: #000;
  }

  .container {
    max-width: 1150px;
    margin: 20px auto;
    padding: 0 15px;
  }

  .panel {
    background: linear-gradient(to bottom,#eef4fe,#c0d6ff);
    border: 2px solid #316ac5;
    margin-bottom: 20px;
    padding: 15px;
  }
  .panel h2 {
    font-size: 18px;
    color: #003399;
    border-bottom: 1px solid #779fd9;
    padding-bottom: 6px;
    margin: 0 0 10px;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .grid {
    display: grid;
    grid-template-columns: repeat(auto-fit,minmax(240px,1fr));
    gap: 15px;
  }
  .card {
    background: #fff;
    border: 1px solid #a0a5b0;
    padding: 10px;
    display: flex;
    align-items: flex-start;
    gap: 10px;
  }
  .card img {
    width: 32px;
    height: 32px;
  }
  .card h3 {
    margin: 0;
    font-size: 16px;
    color: #003399;
  }
  .card p {
    margin: 4px 0 0;
    font-size: 14px;
  }

  .sidebar {
    background: #eef4fe;
    border: 1px solid #a0a5b0;
    padding: 10px;
    margin-bottom: 20px;
  }
  .sidebar h3 {
    font-size: 16px;
    color: #003399;
    border-bottom: 1px solid #779fd9;
    padding-bottom: 4px;
    margin: 0 0 8px 0;
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .sidebar ul {
    list-style: none;
    margin: 0;
    padding: 0;
  }
  .sidebar li {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 6px 0;
    border-bottom: 1px solid #c0c5ce;
    font-size: 14px;
  }
  .sidebar li:last-child {
    border-bottom: none;
  }
  .sidebar img {
    width: 18px;
    height: 18px;
  }

  .longhorn-taskbar {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to bottom,#e0e4ea,#a0a5b0);
    border-top: 1px solid #779fd9;
    padding: 4px 8px;
    display: flex;
    gap: 4px;
  }
  .taskbar-icon {
    width: 28px;
    height: 28px;
    background: #fff;
    border: 1px solid #a0a5b0;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .taskbar-icon img {
    width: 20px;
    height: 20px;
  }

  footer {
    text-align: center;
    padding: 10px;
    font-size: 13px;
    color: #333;
  }
  .footer-logo {
    font-weight: bold;
    color: #003399;
    margin-bottom: 4px;
  }

  @media (max-width: 768px) {
    .grid {
      grid-template-columns: 1fr;
    }
  }

/* Existing styles for the download button image */
.download-button-img {
    width: 140px !important; /* Force width */
    height: 50px !important; /* Force height */
    display: block;
    transition: all 0.3s ease;

}

</style>
</head>
<body>

<div class="top-banner">Build 2 of <strong>Windows Longbridge</strong> is out!</div>

<header>
  <nav>
    <ul>
      <li><a class="active" href="/"><img height="40" width="40" src="https://external-content.duckduckgo.com/iu/?u=http%3A%2F%2Fwww.rw-designer.com%2Ficon-image%2F18837-256x256x4.png&f=1&nofb=1&ipt=f7d794f16772d7f4e0c9a6e94728373825d3c62652593016b99b5592e6f2ea32" alt="Home">Home</a></li>
      <li><a href="/features.php"><img height="40" width="40" src="https://images.freeimages.com/fic/images/icons/679/nx10/256/windows_update.png" alt="Features">Features</a></li>
      <li><a href="https://uploadnow.io/f/77m5F4p"><img height="40" width="40" src="http://www.jidesoft.com/icon/vista/vista.png" alt="Download">Download</a></li>
      <li><a href="https://discord.gg/zP9fAPxtNj"><img height="40" width="40" src="https://upload.wikimedia.org/wikipedia/en/b/bf/Windows_Live_Messenger_icon.png" alt="Community">Community</a></li>
      <li><a href="/about.php"><img height="40" width="40" src="https://www.iconshock.com/image/Vista/General/file" alt="About">About</a></li>
    </ul>
  </nav>
</header>

<div class="container">
  <div class="panel">
    <h2><img width="100" src="https://www.iconshock.com//image/SUPERVISTA/general/help" alt="">What Is Windows Longbridge?</h2>
    <div style="display:flex; gap:20px; flex-wrap: wrap;">
      <div style="flex:2; min-width:240px;">
        <ul>
          <li>Hybrid DWM/Aero visuals with WinFS flair</li>
          <li>Restored Longhorn animations</li>
          <li>Classic Movie Maker & retro gadgets</li>
          <li>Vista‑era sounds</li>
          <li>Modern Win10 base — optimized, bloatware/telemetry‑free</li>
        </ul>
      </div>
      <div style="flex:1; min-width:200px; border:1px solid #a0a5b0;">
        <img src="https://files.catbox.moe/ch64xo.webp" alt="Screenshot" style="width:100%;">
      </div>
    </div>
  </div>

  <div class="panel">
    <h2><img width="150" src="https://www.iconshock.com/image/Brilliant/General/window" alt="">Key Features</h2>
    <div class="grid">
      <div class="card">
        <img src="https://external-content.duckduckgo.com/iu/?u=http%3A%2F%2Fwww.rw-designer.com%2Ficon-image%2F18707-256x256x8.png&f=1&nofb=1&ipt=b7def74a4ed775993db380fcb1e532c8b8c30f362d7761086b2f9dec3a67ff22" alt="">
        <div><h3>“Perfect Mix” Experience</h3>
        <p>Aurora, Plex, Jade/Slate, live together.</p></div>
      </div>
      <div class="card">
        <img src="https://www.iconshock.com/image/Vista/General/hourglass" alt="">
        <div><h3>Custom Animations</h3>
        <p>Longhorn/Vista-style fluidity revived.</p></div>
      </div>
      <div class="card">
        <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fbetawiki.net%2Fimages%2F7%2F77%2FWindows_Sidebar_beta_logo.png%3F20220519010711&f=1&nofb=1&ipt=db24783fd35f6c21c8d9c2510fce6e5e845c198c2c6b06b7974771b5cc28aaa9" alt="">
        <div><h3>Hidden Gems</h3>
        <p>WinFS search, sidebar gadgets, prototype UI.</p></div>
      </div>
      <div class="card">
        <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fvectorified.com%2Fimages%2Fwindows-movie-maker-icon-28.png&f=1&nofb=1&ipt=2e2d8a905613682193d89bdc4fac2913629d0ba880b5b23fddc5d2c91aea7549" alt="">
        <div><h3>Legacy Restored</h3>
        <p>Movie Maker, Photo Gallery, classic widgets.</p></div>
      </div>
    </div>
  </div>

  <aside class="sidebar">
    <h3><img src="https://www.iconshock.com/image/Vista/General/computer" alt="">Build Details</h3>
    <ul>
      <li><img src="https://www.iconshock.com/image/Vista/General/info" alt="">Version: 2.0.0 (Plex) SHA-1 Hash: 3d93908223076f37f329fd778e8784cc7ef1e2cd</li>
      <li><img src="https://www.iconshock.com//image/REALVISTA/web_design/storage_4" alt="">Size: 7.18 GB ISO</li>
      <li><img src="https://www.iconshock.com/image/RealVista/Computer_gadgets/cpu_fan" alt="">Req: 2 GHz CPU, 2 GB RAM</li>
      <li><img src="https://www.iconshock.com/image/RealVista/Mobile/calendar" alt="">Release: June 14, 2025</li>
<a href="https://uploadnow.io/f/77m5F4p">
    <img class="download-button-img" width="200" height="70" src="https://files.catbox.moe/fa5vuy.png" alt="Download">
</a>
    </ul>
  </aside>

  <aside class="sidebar">
    <h3><img src="https://www.iconshock.com/image/Vista/General/group" alt="">Community</h3>
    <ul>
      <li><img src="https://img.icons8.com/?size=80&id=LoL4bFzqmAa0&format=png" alt=""> <a href="https://github.com/Longbridge-Team">GitHub</a></li>
      <li><img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.redd.it%2Flne7g32kas2c1.png&f=1&nofb=1&ipt=1d67f20a42f2bc0901f6d1c4e7cedbe700edbbff8f4cf0c716d53327873b7d8c" alt=""> <a href="https://discord.gg/zP9fAPxtNj">Discord</a></li>
      <li><img src="https://www.iconshock.com/image/Vista/General/book" alt=""> <a href="#">Docs</a></li>
    </ul>
  </aside>
</div>

<footer>
  <div class="footer-logo">Windows Longbridge</div>
  <p>An independent reimagining of Longhorn on modern foundations.</p>
  <p>&copy; 2025 Windows Longbridge Project. Not affiliated with Microsoft.</p>
</footer>


</body>
</html>
