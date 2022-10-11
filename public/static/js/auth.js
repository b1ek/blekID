// hash the password
document.getElementById('pass').onchange = function() {
    setTimeout(hash_pwd, 32);
};

// sign up button
document.getElementById('signup_btn').onclick = function() {
    document.getElementById('action').value = 'signup';
    document.getElementById('main-form').submit();
};
