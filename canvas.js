  function draw() {
  var ctx = document.getElementById('canvas').getContext('2d');
  ctx.font = '48px serif';
  ctx.fillText('Nombre de user', 10, 50);

  var ctx = document.getElementById('canvas').getContext('2d');
  var img = new Image();
  img.onload = function() {
    ctx.drawImage(img, 0, 0);
    ctx.beginPath();
    ctx.moveTo(30, 96);
    ctx.lineTo(0, 0);
    ctx.lineTo(103, 76);
    ctx.lineTo(170, 15);
    ctx.stroke();
  };
  img.src = 'https://mdn.mozillademos.org/files/5395/backdrop.png';
}
