(function () {
  var containers = document.querySelectorAll('[data-ajaxify]');

  Array.from(containers).forEach(i => loadContainer(i));

  function loadContainer(container) {
    var request = new XMLHttpRequest();
    var url = container.href;
    request.open('GET', url, true);

    request.onload = function() {
      if (request.status >= 200 && request.status < 400) {
        // Success!
        container.outerHTML = request.responseText;
      } else {
        container.innerHTML = 'Content failed to load, please refresh the page';
      }
    };

    request.onerror = function() {
      // There was a connection error of some sort
      container.innerHTML = 'Content failed to load, please refresh the page';
    };

    request.send();
  }
})();
