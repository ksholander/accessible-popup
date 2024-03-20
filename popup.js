(function () {
    const popupOpenButtons = document.querySelectorAll('.popup-open-button');
    const popupCloseButtons = document.querySelectorAll('.close-popup-button');
    const popups = document.querySelectorAll('.popup');
    const html = document.querySelector('html');

    // function to open popups
    function openPopup(ev) {
        const popup = document.getElementById(this.getAttribute('aria-controls'));

        // use class to target css for open/close
        popup.classList.add('open');

        // force focus into the dialog
        popup.querySelector('.close-popup-button').focus();

        // control the aria state of the button
        this.setAttribute('aria-expanded', 'true');

        // prevent main page scroll while popup is open
        html.classList.add('has-modal-open');
    }

    function closePopup(ev) {
        const popup = this.closest(".popup");

        // remove class to hide the dialog
        popup.classList.remove('open');

        // control the aria state of the associated button
        const openButton = document.querySelector('.popup-open-button[aria-controls="' + popup.id + '"]');
        openButton.setAttribute('aria-expanded', 'false');

        // force focus back onto the open button
        openButton.focus();

        // allow main page scroll after popup is closed
        html.classList.remove('has-modal-open');
    }

    // keypress handler to detect esc key and close the popup
    function popupKeydown(ev) {
        switch (ev.key) {
            case 'Escape':
                this.querySelector('.close-popup-button').click();
                break;
        }
    }

    /**
     * Gets keyboard-focusable elements within a specified element
     * @param {HTMLElement} [element=document] element
     * @returns {Array}
     */
    function getKeyboardFocusableElements(element = document) {
        return [
            ...element.querySelectorAll(
                'a[href], button, input, textarea, select, details,[tabindex]:not([tabindex="-1"])',
            ),
        ].filter(
            el => !el.hasAttribute('disabled') &&
                !el.getAttribute('aria-hidden') &&
                !el.hidden &&
                el.style.display !== "none",
        )
    }

    /**
     * blur event handler to manage focus when user tabs out of the modal dialog
     */
    function popupBlur(ev) {
        // if focus leaves the popup, force the focus back in
        // get all the keyboard focusable elements in the popup
        const keyboardFocusableElements = getKeyboardFocusableElements(this);
        if (!this.contains(ev.relatedTarget)) {
            // focus is outside of dialog. Did it land on the open button (immediately before the dialog)?
            if (ev.relatedTarget == document.querySelector('.popup-open-button[aria-controls="' + this.id + '"]')) {
                // focus the last element in the popup
                keyboardFocusableElements[keyboardFocusableElements.length - 1].focus();
            } else {
                // focus the first element in the popup
                keyboardFocusableElements[0].focus();
            }
        }
    }

    // add event handlers to the open and close buttons
    for (var i = 0; i < popupOpenButtons.length; i++) {
        popupOpenButtons[i].addEventListener('click', openPopup);
    }
    for (var i = 0; i < popupCloseButtons.length; i++) {
        popupCloseButtons[i].addEventListener('click', closePopup);
    }

    // add event handlers to the dialog popup
    for (var i = 0; i < popups.length; i++) {
        popups[i].addEventListener('keydown', popupKeydown);
        popups[i].addEventListener('focusout', popupBlur);
    }
})();
