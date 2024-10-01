# Custom ACF Gutenberg Popup Block

## Basic Components

- Button that when clicked opens the dialog
- Dialog container with interactive content

## Accessibility Considerations

- Use of semantic HTML for buttons and dialog
- Proper labelling of buttons, especially those that only contain icons
- Proper labeling of dialog element
- Addition of ARIA properties to indicate presence of a popup
- Maintaining ARIA states to indicate current state of the popup
- Keyboard controls work to open and close popup
- Focus is trapped in modal when open

## ACF Features

- Button label controlled through ACF field
- Popup title controlled through ACF field

## Gutenberg Features

- Allows setting of anchor id
- Allows for additional HTML classes
- Padding styling can be set on popup container
- Innerblocks allow for adding Gutenberg blocks into the container in the editor
 
## Using the Block

- Add the code to your theme or plugin
- Add `require_once __DIR__ . "/plugin/plugin.php"` to your functions.php or plugin php code
- Insert the block in the block or page editor
- Add button label and popup title using ACF fields
- Add content to the popup using the editor tools
