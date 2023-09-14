const passwordInput = document.getElementById('registration_form_plainPassword');
const passwordMessage = document.getElementById('password-message');

passwordInput.addEventListener('input', function() {
    let password = passwordInput.value;
    
    // Special password characters
    const minLength = 8;
    const hasUpperCase = /[A-Z]/.test(password);
    const hasLowerCase = /[a-z]/.test(password);
    const hasNumber = /\d/.test(password);
    const hasSpecialCharacter = /[!@#$%^&*]/.test(password);

    // Checking password criterias 
    if (password.length < minLength) {
        passwordMessage.textContent = 'Le mot de passe doit contenir au moins ' + minLength + ' caractères.';
        passwordMessage.style.color = 'red';
    } else if (!hasUpperCase || !hasLowerCase || !hasNumber || !hasSpecialCharacter) {
        passwordMessage.textContent = 'Le mot de passe doit contenir une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.';
        passwordMessage.style.color = 'red';
    } else {
        passwordMessage.textContent = 'Le mot de passe est valide. ✓';
        passwordMessage.style.color = 'green';
    }
});

