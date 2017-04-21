(function () {
  var containers = document.querySelectorAll('[data-ajaxify]');

  [].slice.call(containers).forEach(function(el) {
    loadContainer(el);
  });

  function loadContainer(container) {
    var request = new XMLHttpRequest();
    var url = container.href;
    request.open('GET', url, true);

    request.onload = function() {
      if (request.status >= 200 && request.status < 400) {
        container.outerHTML = request.responseText;
      } else {
        container.innerHTML = 'Content failed to load, please refresh the page';
      }
    };

    request.onerror = function() {
      container.innerHTML = 'Content failed to load, please refresh the page';
    };

    request.send();
  }
})();
