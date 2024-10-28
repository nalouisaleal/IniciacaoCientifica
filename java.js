const header = document.querySelector("header");

window.addEventListener("scroll",function(){
    header.classList.toggle ("sticky",this.window.scrollY > 0);
});


function showMenu() {
    var $navbar = document.getElementById('navbar');
    var style = window.getComputedStyle($navbar);
    
    if(style.display == 'none') {
      $navbar.style.display = 'flex';
    } else {
      $navbar.style.display = 'none';
    }
  }

  window.addEventListener('scroll', function() {
    var container = document.querySelector('.intro');
    var containerTop = container.getBoundingClientRect().top;
    var windowHeight = window.innerHeight;

    if (containerTop < windowHeight) {
        container.classList.add('show');
    }
});


