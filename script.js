const signInForm = document.getElementById('signin');
const signUpForm = document.getElementById('signup');
const showSignUpLink = document.getElementById('showSignUp');
const showSignInLink = document.getElementById('showSignIn');
const signUpFormElement = document.getElementById('signUpForm');
const popup = document.getElementById('popup');

showSignUpLink.addEventListener('click', (event) => {
    event.preventDefault();
    signInForm.style.display = 'none';
    signUpForm.style.display = 'block';
});

showSignInLink.addEventListener('click', (event) => {
    event.preventDefault();
    signInForm.style.display = 'block';
    signUpForm.style.display = 'none';
});
