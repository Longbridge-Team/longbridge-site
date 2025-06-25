function loadCaptcha() {
  const img = document.querySelector('.captcha-img');
  if (!img) return;
  fetch('captcha.php')
    .then(r => r.json())
    .then(d => {
      const canvas = document.createElement('canvas');
      canvas.width = 100;
      canvas.height = 30;
      const ctx = canvas.getContext('2d');
      ctx.fillStyle = 'rgb(224,236,244)';
      ctx.fillRect(0, 0, canvas.width, canvas.height);
      ctx.font = '20px sans-serif';
      ctx.fillStyle = '#000';
      ctx.textBaseline = 'middle';
      ctx.fillText(d.code, 15, 15);
      const logo = new Image();
      logo.crossOrigin = 'anonymous';
      logo.onload = () => {
        ctx.drawImage(logo, 70, 5, 20, 20);
        img.src = canvas.toDataURL('image/png');
      };
      logo.src = 'https://external-content.duckduckgo.com/iu/?u=http%3A%2F%2Fwww.rw-designer.com%2Ficon-image%2F18707-256x256x8.png&f=1&nofb=1&ipt=b7def74a4ed775993db380fcb1e532c8b8c30f362d7761086b2f9dec3a67ff22';
    });
}
document.addEventListener('DOMContentLoaded', loadCaptcha);
