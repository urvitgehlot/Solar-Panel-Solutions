let sections = document.querySelectorAll('section');
let currentSection = 0;

let totalHeight = document.documentElement.scrollHeight - window.innerHeight;;

let scrollAllow = true;

function resetScrollAllow(){
    scrollAllow = false;

    setTimeout(()=>{
        scrollAllow = true;
    },500);
}

document.addEventListener("wheel",function(event) {
    event.preventDefault();
    if(scrollAllow){
        resetScrollAllow();
        const delta = event.deltaY;
        console.log(event.deltaY)
        if(delta > 0 && currentSection < sections.length){
            console.log('down');
            currentSection++;
            const pos = sections[currentSection].getBoundingClientRect();
            console.log(pos.bottom);
            window.scroll({
                top: window.scrollY + pos.top,
                behavior: 'smooth'
            });
        }
        else if (delta < 0 && currentSection > 0){
            console.log('Up');
            currentSection--;
            const pos = sections[currentSection].getBoundingClientRect();
            console.log(pos.top);
            window.scroll({
                top: window.scrollY + pos.top,
                behavior: 'smooth'
            });
        }
    }
},{passive: false});

currentTestimonialSelected = 1;
activeTestimonial();

function activeTestimonial(){
    var testimonialContainer = document.querySelector('.testimonial-user-'+currentTestimonialSelected);
    testimonialContainer.querySelector('img').style.filter = 'opacity(100%)';
    testimonialContainer.querySelector('span').style.filter = 'opacity(100%)';
    testimonialContainer.style.backgroundColor = '#6AC949';
    var testimonialContainer = document.querySelector('.testimonial-content-'+currentTestimonialSelected);
    testimonialContainer.style.display = 'block';
    // document.querySelector('testimonial-user-'+i);
}

function changeActiveTestimonial(setTestimonial = false){
    var testimonialContainer = document.querySelectorAll('.testimonial-user');
    testimonialContainer.forEach(element => {
        element.querySelector('img').style.filter = 'opacity(56%)';
        element.querySelector('span').style.filter = 'opacity(56%)';
        element.style.backgroundColor = '#E7E7E7';
        var testimonialContainer = document.querySelectorAll('.testimonial-content');
        testimonialContainer.forEach(element => {
            element.style.display = 'none';
        });
    });
    if(!setTestimonial){
        currentTestimonialSelected++;
        if(currentTestimonialSelected > 3){
            currentTestimonialSelected = 1;
        }
        activeTestimonial();
    }

}

let testimonialInterval = setInterval(changeActiveTestimonial,1500);


var testimonialUsers = document.querySelectorAll('.testimonial-user');
for (let index = 0; index < testimonialUsers.length; index++) {
    testimonialUsers[index].addEventListener('click', function (event) {
        changeActiveTestimonial(true);
        testimonialUsers[index].querySelector('img').style.filter = 'opacity(100%)';
        testimonialUsers[index].querySelector('span').style.filter = 'opacity(100%)';
        testimonialUsers[index].style.backgroundColor = '#6AC949';
        var testimonialContainer = document.querySelector('.testimonial-content-'+(index+1));
        testimonialContainer.style.display = 'block';
        currentTestimonialSelected = index+1;
        // clearInterval(testimonialInterval);

        
    });
}