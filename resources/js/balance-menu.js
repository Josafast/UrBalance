document.getElementById('closeFloatMenu').addEventListener('click',(e)=>{
  e.target.parentElement.parentElement.style.display = "none";
});

let list = document.querySelectorAll('.list-element'); 

list.forEach(option=>{
  option.addEventListener('click', function(){
    list.forEach(option=>{
      option.classList.remove('selected');
    });
    this.classList.add('selected');
    document.getElementById('main-id').value = this.getAttribute('id');
  });
});