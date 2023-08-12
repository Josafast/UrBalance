class FormSubmitter {
  constructor(){
    this.submitOK = true;
    this.forms = document.querySelectorAll('.form');
    this.formsController();
    if (history.state){
      this.messagesController();
    }
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
      let path = new URL(window.location);
      let pathname = "";
      for (let [labelName, labelValue] of this.formData.entries()){
        pathname += labelName + "=" + labelValue + "&";
      }
      path.search = pathname.slice(0, pathname.length-1);
      location.replace(path.href);
    }
  } 

  balanceMenuSelector(buttonValue){
    let path = new URL(window.location.href);

    if (buttonValue == "2"){
      this.formData.set('change_main', true);
    }

    if (buttonValue == "4"){
      path.pathname = "/balance/delete";
      this.action = path.href;
      this.method = 'delete';  
    }

    this.submitOK = true;
  }

  updateFormDataFromRegisterForm(){
    if (document.querySelector('.create_balance').hasAttribute('style')){
      document.querySelector('.create_balance').removeAttribute('style');
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
      .then(res=>res.json())
      .then(res => {
        if ("link" in res){
          if ("messages" in res){
            history.pushState({messages: res.messages, status: res.status}, '', res.link);
            history.go();
            return;
          }

          location.replace(res.link);
        }

        if ("notes" in res){
          document.querySelector('.notes-text').innerHTML = res.notes;
          document.querySelector('.notes-title').children[0].innerHTML = res.name;
          document.getElementById('notes-square').style.display = "flex";
        }
      }).catch(err=> this.messagesController(err));
  }

  messagesController (error = null){
    console.log(error);
    let color = 'red';
    let icon = 'close'
    if (error == null){
      error = history.state.messages;
      if (history.state.status == 'done'){
        color = 'green';
        icon = 'checkmark';
      } else if (history.state.status == 'what?'){
        color = 'purple';
        icon = 'help';
      } else if (history.state.status == 'edited'){
        color = 'orange';
        icon = 'build';
      } else {
        color = 'red';
        icon = 'trash';
      } 
    }

    let messageBox = document.querySelector('.message-box');
    let messageText = document.querySelector('.message-text');
    let messageIcon = document.querySelector('.message-icon');
    messageIcon.innerHTML = "";
    let ionIcon = document.createElement('ion-icon');
    ionIcon.setAttribute('name', icon);
    messageIcon.appendChild(ionIcon);
    messageText.innerHTML = "";
    for(let [field, messages] of Object.entries(error)){
      messages.map(message=>{
        if (message != ''){
          messageText.innerHTML += `<h3>${message}</h3>`;
        }
      });
    }
    messageBox.style.color = `var(--${color})`;
    messageBox.style.borderColor = `var(--${color})`;
    messageBox.style.backgroundColor = `var(--background-${color})`;
    messageBox.style.animation = "5s ease-out 0s show";
    setTimeout(()=> messageBox.style.animation = 'none', 6000);
  }
}

let formSubmitter = new FormSubmitter();