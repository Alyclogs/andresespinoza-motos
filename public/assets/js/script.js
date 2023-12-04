document.addEventListener('DOMContentLoaded', function() {

    var overlay = document.getElementById('overlay');
    var btnLogin = document.getElementById('btn-login');
    var btnClose = document.getElementById('btn-close');

    btnLogin.addEventListener('click', function() {
      overlay.style.display = 'flex';
    });

    btnClose.addEventListener('click', function() {
      overlay.style.display = 'none';
    });
  });

  window.addEventListener('load', function() {
    setTimeout(function() {
        document.querySelector('.loader-wrapper').style.display = 'none';
        document.querySelector('.content').style.display = 'block';
    }, 1000)
});
  