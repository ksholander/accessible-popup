(function () {
    const popupOpenButtons = document.querySelectorAll('.popup-open-button');
    const popupCloseButtons = document.querySelectorAll('.close-popup-button');
    const popups = document.querySelectorAll('.popup');
    const html = document.querySelector('html');

    // function to open popups
    function openPopup(ev) {
        const popup = document.getElementById(this.getAttribute('aria-controls'));

        // tell the browser to open the dialog as a modal
        popup.showModal();

        // manage the aria state
        this.setAttribute('aria-expanded', 'true');

        // prevent main page from scrolling when popup is open
        html.classList.add('has-modal-open');
    }

    // function to close popups
    function closePopup(ev) {
        const popup = this.closest(".popup");

        // tell the browser to close the dialog
        popup.close();

        // find the associated open button and manage its aria state
        const openButton = document.querySelector(
            '.popup-open-button[aria-controls="' + popup.id + '"]'
        );
        openButton.setAttribute('aria-expanded', 'false');

        // allow the main page to scroll
        html.classList.remove('has-modal-open');
    }

    // keypress handler to close popup when esc key is pressed
    function popupKeydown(ev) {
        switch (ev.key) {
            case 'Escape':
                this.querySelector('.close-popup-button').click();
                break;
        }
    }

    for (var i = 0; i < popupOpenButtons.length; i++) {
        popupOpenButtons[i].addEventListener('click', openPopup);
    }
    for (var i = 0; i < popupCloseButtons.length; i++) {
        popupCloseButtons[i].addEventListener('click', closePopup);
    }
    for (var i = 0; i < popups.length; i++) {
        popups[i].addEventListener('keydown', popupKeydown);
    }
})();
