// public/js/money-input.js
document.addEventListener('DOMContentLoaded', function () {
    const moneyInputs = document.querySelectorAll('.money-input');

    moneyInputs.forEach(input => {
        input.addEventListener('input', function (e) {
            // Menghapus karakter selain angka
            let value = e.target.value.replace(/[^0-9]/g, '');
            // Menambahkan pemisah ribuan
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            e.target.value = value;
        });
    });
});
