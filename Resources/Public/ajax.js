(() => {
    const containers = document.querySelectorAll('[data-ajaxify]');

    containers.forEach(container => {
        loadContainer(container);
    });

    async function loadContainer(container) {
        const url = container.href;
        try {
            const response = await fetch(url);
            if (response.ok) {
                container.outerHTML = await response.text();
            } else {
                container.innerHTML = 'Content failed to load, please refresh the page';
            }
        } catch (error) {
            container.innerHTML = 'Content failed to load, please refresh the page';
        }
    }
})();
