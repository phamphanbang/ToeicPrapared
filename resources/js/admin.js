let adminAlert = document.getElementsByClassName('admin-top-message');

let timers = {};

timers.marco = setTimeout(function() {
    document.getElementsByClassName('admin-top-message')[0].remove();
  }, 3000);

  if (document.getElementsByClassName('admin-top-message').length == 0) {
    clearTimeout(timers.marco);
  };
