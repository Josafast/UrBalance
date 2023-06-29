<div class="float" style="display: none;">
    <form action="" id="balance-create">
        <span class="close" id="closeFloat">
            <img src="{{ asset('img/close.svg') }}" alt="close-icon" style="pointer-events: none; user-select: none;">
        </span>
        <label for="initial">
            <h4>Selecciona el valor inicial de tu cuenta:</h4>
            <input type="number" name="initial">
        </label>
        <label for="exchange_id">
            <h4>Selecciona la tasa de cambio</h4>
            <select name="exchange_id" style="width: min-content">
                @foreach (App\Models\Exchange::all() as $exchange)
                    <option value="{{ $exchange->id }}">{{ $exchange->name }}</option>
                @endforeach
            </select>
        </label>
        <input type="submit" value="Registrarse" style="margin: 10px 0 0 auto; position: relative;">
    </form>
    <script>
        let div = document.querySelector('.float');

        document.getElementById('closeFloat').addEventListener('click',(e)=>{
            e.target.parentElement.parentElement.style.display = "none";
        });

        @if (request()->routeIs('register.view'))
            let submiter = false;

            document.querySelector('.login_form').addEventListener('submit', (e)=>{
                if (!submiter){
                    e.preventDefault();
                    document.getElementById('balance-create').parentElement.removeAttribute('style');        
                }
            });
        @endif

        document.getElementById('balance-create').addEventListener('submit', (e)=>{
            e.preventDefault();
            @if (request()->routeIs('register.view'))
                let balanceCreateForm = new FormData(document.getElementById('balance-create'));


                let labels = [document.createElement('label'), document.createElement('label')];
                let inputs = [document.createElement('input'), document.createElement('input')];

                labels[0].setAttribute('for', 'initial');
                labels[1].setAttribute('for', 'exchange_id');

                inputs[0].name = 'initial';
                inputs[1].name = 'exchange_id';

                inputs[0].setAttribute('value', balanceCreateForm.get('initial'));
                inputs[1].setAttribute('value', balanceCreateForm.get('exchange_id'));

                for(let i = 0; i < 2; i++){
                    inputs[i].type = 'hidden';
                    labels[i].appendChild(inputs[i]);
                    document.querySelector('.login_form').appendChild(labels[i]);
                }

                document.querySelector('.login_form').submit();
            @endif
        });
    </script>
</div>