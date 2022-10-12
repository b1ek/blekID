// language change
document.getElementById('lang').onchange = function() {
    let e = document.getElementById('lang');
    if (e.value == '0') return;
    window.location.href = '/setLocale/' + e.value;
};
