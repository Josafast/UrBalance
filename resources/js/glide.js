import Glide from '@glidejs/glide'

const options = location.pathname == '/' ?
  {
    type: 'carousel',
    gap: 0,
    height: 'max-content',
    startAt: 4
  } :
  {
    type: 'carousel',
    gap: '20px',
    perView: 3,
    swipeThreshold: false,
    dragThreshold: false,
    keyboard: false,
    perTouch: 1,
    breakpoints: {
      1980: {
        perView: 3
      },
      1000: {
        rewind: 0,
        perView: 2,
        peek: 0,
        bound: true,
        swipeThreshold: true,
        dragThreshold: true,
        keyboard: true
      },
      720: {
        perView: 1,
        swipeThreshold: true,
        dragThreshold: true
      }
    }
  }

const glide = new Glide('.glide', options);

glide.mount();

if (location.pathname == '/'){
  let optionsGlide = document.querySelector('.glide__slides');
  let listOptionsGlide = document.querySelectorAll('.glide__slide');

  function changeOptionsGlideListHeight(){
    let optionsHeight = optionsGlide.scrollHeight;
    listOptionsGlide.forEach(listOption => {
      listOption.style.height = `${optionsHeight}px`;
    });
  }

  glide.on('run', function(){
    changeOptionsGlideListHeight();
  });

  glide.on('resize', function(){
    listOptionsGlide.forEach(listOption => {
      listOption.style.height = "min-content";
    });
    changeOptionsGlideListHeight();
    glide.update();
  });

  glide.go('>');
}