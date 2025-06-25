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
      logo.src = '/data/logolol.png';
    });
}
document.addEventListener('DOMContentLoaded', loadCaptcha);
