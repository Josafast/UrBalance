<div class="float" id="menu_balance" style="display: none;">
  <script>
    let mainSubmiter = false;
  </script>
  <form action="{{ route('balance.change-main') }}" method="post" id="balance-menu" class="form">
    @csrf
    <span class="close" id="closeFloatMenu">
      <img src="{{ asset('img/close.svg') }}" alt="close-icon" style="pointer-events: none; user-select: none;">
    </span>
    <h2 style="margin: 0 100px 30px 0;">Elige tu balance</h2>
    <label for="change_main" style="margin: 0;">
      <input type="hidden" name="change_main" id="change_main" value="false">
    </label>
    <label for="main" style="margin: 0;">
      <input type="hidden" name="main" id="main-id"value="{{ request()->session()->get('main') }}">
    </label>
    <ul>
      @php
        $balances = request()->user()->balance;
      @endphp
      @foreach ($balances as $position => $balance)
        <li style="margin-top: -1.5px; border-radius: 
        {{ $position == 0 ? '10px 10px 0 0;' : ($position == (count($balances)-1) ? '0 0 10px 10px;' : '')}}
        @if ($balance->main)
          font-weight: 500;
        @endif"
        class="list-element
        @if ($balance->exchange_id == request()->session()->get('main'))
            selected
        @endif" id="{{ $balance->exchange_id }}">
          {{ $balance->exchange->name }}
          @if ($balance->exchange_id == request()->session()->get('main'))
            (Current)
          @endif
        </li>
      @endforeach
    </ul>
    <div style="margin-top: 30px; display: flex; justify-content: space-between; gap: 20px;">
      <button style="position: relative;" id="change_balance_button">Cambiar</button>
      <button style="position: relative;" id="change_main_balance_button">Cambiar principal</button>
      <button style="position: relative;" id="create_balance_button">Crear</button>
      <button style="position: relative;" id="delete_balance_button">Eliminar</button>
    </div>
  </form>
  <script>
      function submitForm(deleteBalance = false ,changeMain = false){
        if (changeMain){
          document.getElementById('change_main').value = "true";
        }

        if (deleteBalance){
          document.getElementById('balance-menu').setAttribute('action', "{{ route('balance.delete') }}");  
        }
        
        mainSubmiter = true;
        document.getElementById('balance-menu').submit();
      }

      document.getElementById('change_balance_button').addEventListener('click',()=>submitForm());
      document.getElementById('change_main_balance_button').addEventListener('click',()=>submitForm(false, true));
      document.getElementById('create_balance_button').addEventListener('click',()=>document.getElementById('create_balance').removeAttribute('style'));
      document.getElementById('delete_balance_button').addEventListener('click',()=>submitForm(true));

      document.getElementById('closeFloatMenu').addEventListener('click',(e)=>{
        e.target.parentElement.parentElement.style.display = "none";
      });

      document.getElementById('balance-menu').addEventListener('submit',(e)=>{
        if (!mainSubmiter){
          e.preventDefault();
        }
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
  </script>
</div>