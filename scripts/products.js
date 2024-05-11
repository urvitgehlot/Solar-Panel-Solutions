var leftScrollBtns = document.querySelectorAll('.scrolling-arrow-left');
var rightScrollBtns = document.querySelectorAll('.scrolling-arrow-right');


leftScrollBtns.forEach(element => {
    element.addEventListener('click', function (event) {
        this.parentElement.querySelector('.scrolling-product-list').scrollLeft  -= 254;
    });
    
});


rightScrollBtns.forEach(element => {
    element.addEventListener('click', function (event) {
        this.parentElement.querySelector('.scrolling-product-list').scrollLeft  += 254;
    });
    
});
