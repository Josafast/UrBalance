<x-app-layout title="{{ isset($transaction) ? 'Modificar Transacción' : 'Crear Transacción' }}">
  <form action="{{ isset($transaction) ? route('transactions.update', $transaction->id) : route('transactions.store') }}" method="POST" class="transaction_form">
    @csrf 
    @method( isset($transaction) ? 'PUT' : 'POST')
    <div style="display: grid; grid-gap: 0; grid-template-columns: 1fr max-content; grid-template-rows: min-content; height: min-content;">
      <label for="name">
        <input type="text" name="name" required placeholder="Nueva Transacción" 
        @if (isset($transaction))
          value="{{ $transaction->name }}"
        @endif>
      </label>
      <label for="quantity">
        <span class="transaction_span">
          <input type="number" step="0.01" min="0.01" name="quantity" id="quantity-input" value="{{ isset($transaction) ? number_format($transaction->quantity, 2) : '0.00' }}" class="number">&nbsp;{{ App\Models\Exchange::where('id', request()->session()->get('main'))->first()->sign }}
          <script>
            let quantityInput = document.getElementById('quantity-input');
            
            function quantityFieldSet(){
              inputWidth = quantityInput.scrollWidth;
              quantityInput.style.width = "40px";
              quantityInput.style.width = quantityInput.scrollWidth + "px";
            }

            quantityInput.addEventListener('input', quantityFieldSet);
            quantityFieldSet();
          </script>
        </span>
      </label>
    </div>
    <div style="padding: 5px 0; display: flex; gap: 10px; height: min-content">
        @php

        $types = App\Models\Type::all();

        @endphp
        <select style="width: min-content" class="type-selector">
          <option value="|#333">Tipo</option>
          @foreach($types as $type)
            <option value="{{ $type->name }}|var(--{{ $type->color }})" 
              @if (isset($transaction))
                @if ($type->id == $transaction->category->type_id)
                  selected
                @endif
              @endif>{{ $type->name }}</option>
          @endforeach
        </select>
      <label for="status" style="width: min-content;">
        <select name="status" required style="width: min-content">
          <option value="">Estado</option>
          <option value="true" 
          @if (isset($transaction))
            @if ($transaction->status == "true")
              selected
            @endif
          @endif>Completo</option>
          <option value="false"
          @if (isset($transaction))
            @if ($transaction->status == "false")
              selected
            @endif
          @endif>Sin completar</option>
        </select>
      </label>
      <label for="category_id" style="width: min-content;">
        <select name="category_id" required style="width: min-content" class="category-selector-main">
          <option value="">Categoría</option>
          @foreach($types as $type)
            <optgroup label="{{ $type->name }}" class="category-selector">
            @foreach($type->categories as $category)
              <option value="{{ $category->id }}"
                @if (isset($transaction))
                  @if ($category->id == $transaction->category_id)
                    selected
                  @endif
                @endif>{{ $category->name }}</option>
            @endforeach
            </optgroup>
          @endforeach
        </select>
      </label>
    </div>
    <div style="height: 100%; display: flex; flex-direction: column; margin-top: auto;">
      <label for="notes" style="height: 100%">
        <textarea name="notes" placeholder="Notas">@if(isset($transaction)){{trim($transaction->notes)}}@endif</textarea>
      </label>
      <input type="submit" value="{{ isset($transaction) ? 'MODIFICAR TRANSACCION' : 'CREAR TRANSACCION' }}" style="margin-top: auto;" class="transaction_submit">
    </div>
  </form>
  <script>
    let types = document.querySelector('.type-selector');
    let categories = document.querySelectorAll('.category-selector');

    function categoryTarget(){
      let data = types.value.split('|');
      typeValue = data[0];
      colorValue = data[1];
      document.querySelector('.transaction_span').style.backgroundColor = colorValue;
      document.querySelector('.transaction_submit').style.backgroundColor = colorValue;

      if (typeValue != ""){
        document.querySelector('.category-selector-main').children[0].removeAttribute('selected')
        categories.forEach(category=>{
          category.style.display = "none";
          if (category.label == typeValue) {
            category.removeAttribute('style');
            category.children[0].setAttribute('selected', '');
          } else {
            category.style.display = "none";
            let Children = category.children;
            for(categoryChild of Children){
              categoryChild.removeAttribute('selected');
            }
          };
        });
      } else {
        categories.forEach(category=>{
          category.style.display = "none";
        });
        document.querySelector('.category-selector-main').children[0].setAttribute('selected', '');
      };
    }

    types.addEventListener('change',categoryTarget);
    categoryTarget();
  </script>
</x-app-layout>