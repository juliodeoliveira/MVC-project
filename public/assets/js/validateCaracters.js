const phoneNumberInput = document.getElementById("telephone");
phoneNumberInput.addEventListener('input', function(event) {
    let phoneNumber = phoneNumberInput.value.replace(/\D/g, '');
    let formattedNumber = "";

    if (phoneNumber.length > 0) {
        formattedNumber += "(" + phoneNumber.substring(0, 2);
    }

    if (phoneNumber.length >= 3) {
        formattedNumber += ") " + phoneNumber.substring(2, 7);
    }

    if (phoneNumber.length >= 8) {
        formattedNumber += "-" + phoneNumber.substring(7, 11);
    }

    phoneNumberInput.value = formattedNumber;
});

const cep = document.getElementById("cep");
cep.addEventListener("input", function(event) {
    let cepValue = cep.value.replace(/\D/g, '');
    let formattedCep = "";
    
    if (cepValue.length > 5) {
        formattedCep += cepValue.substring(0, 5) + "-" + cepValue.substring(5, 8);
    } else {
        formattedCep = cepValue;
    }

    cep.value = formattedCep;
});

function sanitizeInput(input) {
    return input.replace(/[`~!@#$%*()_|+\=?;:'"<>\{\}\[\]\\\/]/gi, '');
}

const enterpriseNameInput = document.getElementById("enterprisename");
enterpriseNameInput.addEventListener('input', function(event) {
    enterpriseNameInput.value = sanitizeInput(enterpriseNameInput.value);
});

const emailInput = document.getElementById("email");
emailInput.addEventListener('input', function(event) {
    emailInput.value = emailInput.value.replace(/[`~!#$%*()\[\]_|+\=?;:'"<>\{\}\[\]\\\/]/gi, '');
});

const streetInput = document.getElementById("street");
streetInput.addEventListener('input', function(event) {
    streetInput.value = sanitizeInput(streetInput.value);
});

const houseNumberInput = document.getElementById("house");
houseNumberInput.addEventListener('input', function(event) {
    houseNumberInput.value = sanitizeInput(houseNumberInput.value);
});

const neighInput = document.getElementById("neightborhood");
neighInput.addEventListener('input', function(event){
    neighInput.value = sanitizeInput(neighInput.value);
});

const cityInput = document.getElementById("city");
cityInput.addEventListener('input', function(event) {
    cityInput.value = sanitizeInput(cityInput.value);
});

const complementInput = document.getElementById("complement");
complementInput.addEventListener('input', function(event) {
    complementInput.value = sanitizeInput(complementInput.value);
});   
