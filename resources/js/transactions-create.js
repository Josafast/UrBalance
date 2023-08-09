let quantityInput = document.getElementById('quantity-input');

function quantityFieldSet() {
  quantityInput.style.width = "40px";
  quantityInput.style.width = quantityInput.scrollWidth + "px";
}

quantityInput.addEventListener('input', quantityFieldSet);
quantityFieldSet();

let types = document.querySelector('.type-selector');
let categories = document.querySelectorAll('.category-selector');

function categoryTarget() {
  let data = types.value.split('|');
  let typeValue = data[0];
  let colorValue = data[1];
  document.querySelector('.transaction_span').style.backgroundColor = colorValue;
  document.querySelector('.transaction_submit').style.backgroundColor = colorValue;

  if (typeValue != "") {
    document.querySelector('.category-selector-main').children[0].removeAttribute('selected')
    categories.forEach(category => {
      category.style.display = "none";
      console.log(category);
      if (category.id == typeValue) {
        category.removeAttribute('style');
        category.children[0].setAttribute('selected', '');
      } else {
        category.style.display = "none";
        let Children = category.children;
        for (let categoryChild of Children) {
          categoryChild.removeAttribute('selected');
        }
      };
    });
  } else {
    categories.forEach(category => {
      category.style.display = "none";
    });
    document.querySelector('.category-selector-main').children[0].setAttribute('selected', '');
  };
}

types.addEventListener('change', categoryTarget);
categoryTarget();