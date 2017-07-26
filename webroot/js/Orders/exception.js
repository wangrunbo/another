$(function () {
    redirectToCart();
});

function redirectToCart() {
    var counter = $("#counter");

    var i = setInterval(function () {
        if (counter.text() === '0') {
            clearInterval(i);
        } else {
            if (counter.text() === '1') {
                window.location.href = $("#link-cart").attr('href')
            }

            counter.text(counter.text() - 1)
        }
    }, 1000)
}