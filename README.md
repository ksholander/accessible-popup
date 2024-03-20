# Custom ACF Gutenberg Popup Block

## Basic Components
- Button that when clicked opens the dialog
- Dialog container with interactive content

## Accessibility Issues
- Keyboard navigation doesn't work to get to open button
- Open button does not have proper aria properties to indicate it's function
- Clicking button does not properly direct focus into popup
- Using keyboard to navigate - focus leaves popup after last element
- Close button has no accessible label
- Dialog does not have a title
- Keyboard controls don't work (esc key should close popup)

## Repository Branches
- main: the inaccessible code
- dialog: the reworked code making the popup accessible using the html <dialog> element
- div: the reworked code making the popup accessible using html <div> element
