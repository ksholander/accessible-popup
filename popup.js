(function () {
    const html = document.querySelector('html');

    /**
     * Open a popup
     */
    function openPopup(ev) {
        const popup = document.getElementById(this.getAttribute('aria-controls'));
        popup.showModal();
        this.setAttribute('aria-expanded', 'true');
        html.classList.add('has-modal-open');
    }

    /**
     * Close a popup
     */
    function closePopup(ev) {
        const popup = this.closest(".popup");
        popup.close();
        const openButton = document.querySelector(
            '.popup-open-button[aria-controls="' + popup.id + '"]'
        );
        openButton.setAttribute('aria-expanded', 'false');
        html.classList.remove('has-modal-open');
    }

    // find all of the open and close buttons and attach event listeners
    const popupOpenButtons = document.querySelectorAll('.popup-open-button');
    const popupCloseButtons = document.querySelectorAll('.close-popup-button');
    for (var i = 0; i < popupOpenButtons.length; i++) {
        popupOpenButtons[i].addEventListener('click', openPopup);
    }
    for (var i = 0; i < popupCloseButtons.length; i++) {
        popupCloseButtons[i].addEventListener('click', closePopup);
    }
})();
