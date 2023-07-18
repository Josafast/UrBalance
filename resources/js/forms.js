class FormSubmitter {
  constructor(){
    this.submitOK = true;
    this.forms = document.querySelectorAll('.form');
    this.formsController();
  }

  formsController(){
    for (const form of this.forms) {
      form.addEventListener('submit', (e) => {
        e.preventDefault();
        this.formSettings(e);
        if (this.submitOK == true) this.submit();
      });
    }
  }

  formSettings(e){
    this.setRequestData(e.target);

    if (e.target.id == 'balance-menu') this.balanceMenuSelector(e.submitter.getAttribute('option'));

    if (new URL(window.location.href).pathname.includes('/register')) this.updateFormDataFromRegisterForm();
  }

  setRequestData(formulary){
    this.action = formulary.action;

    let params = new URLSearchParams();
    for (let [labelName, labelValue] of new FormData(formulary).entries()){
      params.append(labelName, labelValue);
    }
    this.formData = params;

    this.method = this.formData.has('_method') ? this.formData.get('_method') : formulary.method;
  
    if (this.method.toUpperCase() == 'GET'){
      let path = new URL(window.location.href);
      let pathname = "";
      for (let [labelName, labelValue] of this.formData.entries()){
        pathname += labelName + "=" + labelValue + "&";
      }
      location.replace(path.href + "?" + pathname.slice(0, pathname.length-1));
    }
  } 

  balanceMenuSelector(buttonValue){
    let path = new URL(window.location.href);
    this.method = 'put';

    if (buttonValue == "2"){
      this.formData.set('change_main', true);
    }
    
    if (buttonValue == "3"){
      document.getElementById('create_balance').removeAttribute('style');
      this.submitOK = false;
      setTimeout(()=>{
        this.submitOK = !this.submitOK;
        this.method = 'post';
      }, 200);
      return;
    }

    if (buttonValue == "4"){
      path.pathname = "/balance/delete";
      this.action = path.href;
      this.method = 'delete';  
    }

    this.submitOK = true;
  }

  updateFormDataFromRegisterForm(){
    if (document.getElementById('balance-create').parentElement.hasAttribute('style')){
      document.getElementById('balance-create').parentElement.removeAttribute('style');
      this.submitOK = false;
      return;
    }
    
    let registerData = new FormData(document.querySelector('.login_form'));
    for (let [labelName, labelValue] of registerData.entries()){
      if (labelName != '_token') this.formData.append(labelName, labelValue);
    }
  
    this.action = document.querySelector('.login_form').action;
    this.submitOK = true;
  }

  submit(){
      let options = {
        method: this.method,
        body: this.formData,
        headers: {
          'X-CSRF-TOKEN': this.formData.get('_token')
        }
      };

      fetch(this.action, options)
      .then(res=>{
        if (!res.ok){
          return res.json().then(error => { throw error; });
        }

        return res.json().then(data => location.replace(data.link));
      }).catch(err=>{
        for(let [errorField, errorMessages] of Object.entries(err)){
          document.querySelector(`.${errorField}Errors`).innerHTML = "";
          errorMessages.map(errorMessage=>{
            let smallField = document.createElement('small');
            smallField.textContent = `*${errorMessage}`;
            document.querySelector(`.${errorField}Errors`).appendChild(smallField);
          });
        }
      });
  }
}

let formSubmitter = new FormSubmitter();