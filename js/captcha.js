function loadCaptcha() {
  const img = document.querySelector('.captcha-img');
  if (!img) return;
  fetch('captcha.php')
    .then(r => r.json())
    .then(d => {
      const canvas = document.createElement('canvas');
      canvas.width = 130;
      canvas.height = 40;
      const ctx = canvas.getContext('2d');
      ctx.fillStyle = 'rgb(224,236,244)';
      ctx.fillRect(0, 0, canvas.width, canvas.height);
      ctx.font = 'bold 22px "Comic Sans MS", Tahoma, sans-serif';
      ctx.textBaseline = 'middle';
      for (let i = 0; i < d.code.length; i++) {
        ctx.fillStyle = `hsl(${Math.floor(Math.random()*360)},70%,40%)`;
        ctx.fillText(d.code[i], 10 + i * 22, 20);
      }
      const logo = new Image();
      logo.crossOrigin = 'anonymous';
      logo.onload = () => {
        ctx.drawImage(logo, 104, 8, 24, 24);
        img.src = canvas.toDataURL('image/png');
      };
      logo.src = '/data/logolol.png';
    });
}
document.addEventListener('DOMContentLoaded', loadCaptcha);
