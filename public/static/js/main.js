function hash_pwd() {
    let pass_hash = document.getElementById('pass_hash');
    let pass_text = document.getElementById('pass');
    pass_hash.value = sha512(pass_text.value);
}

// language change
document.getElementById('lang').onchange = function() {
    let e = document.getElementById('lang');
    if (e.value == '0') return;
    window.location.href = '/setLocale/' + e.value;
};
