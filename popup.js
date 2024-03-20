(function () {
    const popupOpenButtons = document.querySelectorAll('.popup-open-button');
    const popupCloseButtons = document.querySelectorAll('.close-popup-button');

    // function to open popups
    function openPopup(ev) {
        document.getElementById(this.dataset.popup).classList.add('open');
    }

    // function to close popups
    function closePopup(ev) {
        this.closest(".popup").classList.remove('open');
    }

    // add event handlers to the open and close buttons
    for (var i = 0; i < popupOpenButtons.length; i++) {
        popupOpenButtons[i].addEventListener('click', openPopup);
    }
    for (var i = 0; i < popupCloseButtons.length; i++) {
        popupCloseButtons[i].addEventListener('click', closePopup);
    }
})();
