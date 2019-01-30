function copyTextToClipboard(copyText) {

    let regex = /<br\s*[\/]?>/gi; // the regular expression to to find <br> tags

    copyText = copyText.replace(regex, "\n\n"); // do the replacement of <br> tags

    // console.log(copyText);

    let textArea = document.createElement('textarea'); // create a text area

    // set some values for the text area that allow us to select it, copy the text we want, and also hide it from the page
    textArea.value = copyText;
    textArea.setAttribute('readonly', ''); // for page readers (probably not needed here, but eh)
    textArea.style.position = 'absolute';
    textArea.style.left = '-9999px';

    document.body.appendChild(textArea); // append the invisible text area

    textArea.select(); // select it so we can copy the text

    // copy the text to the clipboard and remove the text area from the screen
    document.execCommand('copy');
    document.body.removeChild(textArea);

}