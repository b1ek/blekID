function hash_pwd() {
    let pass_hash = document.getElementById('pass_hash');
    let pass_text = document.getElementById('pass');
    pass_hash.value = sha512(pass_text.value);
}

// hash the password
document.getElementById('pass').onchange = function() {
    setTimeout(hash_pwd, 32);
};

// login button
document.getElementById('login_btn').onclick = function() {
    document.getElementById('action').value = 'login';
    document.getElementById('main-form').submit();
}

// sign up button
document.getElementById('signup_btn').onclick = function() {
    document.getElementById('action').value = 'signup';
    document.getElementById('main-form').submit();
};
