function toggleCountryDropdown() {
    var otherCountrySelected = document.getElementById('otherCountry').checked;
    var philippinesSelected = document.getElementById('philippines').checked;

    if (otherCountrySelected) {
        document.querySelector('.philippines-dropdown').style.display = 'none';
        document.querySelector('.other-country-dropdown').style.display = 'block';
    } else if (philippinesSelected) {
        document.querySelector('.other-country-dropdown').style.display = 'none';
        document.querySelector('.philippines-dropdown').style.display = 'block';
    }
}

// Call the function initially to set the initial state
toggleCountryDropdown();
