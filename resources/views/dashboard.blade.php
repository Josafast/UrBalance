<x-app-layout title="{{ __('titles.dashboard') }}">
  <section class="dashboard-values">
    <x-dashboard-values :balanceValues="$balanceValues"/>
  </section>
  <section class="dashboard-charts">
    <script>
      const rootStyles = getComputedStyle(document.documentElement);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js" stye="display:none;"></script>
    <div class="glide">
      <div class="glide__track" data-glide-el="track">
        <ul class="glide__slides">
          @php $categories = App\Models\Category::all()->groupBy('type_id'); @endphp
          @foreach($balance as $typeID => $transactions)
            <x-chart--j-s :transactions="$transactions" :category="$categories[$typeID]" :sinceUntil="$sinceUntil"/>
          @endforeach
        </ul>
      </div>
    </div>
  </section>
  <section class="dashboard-select-date">
    <form action="{{ route('dashboard') }}" method="get" id="sinceUntil" class="form form_styles date_form">
      <label for="since">
        <h2>{{ __('query_fields.since') }}: </h2>
        <input type="date" name="since" id="dateSINCE"
        @if (request()->has('since'))
          value = "{{ old('since') ? old('since') : request()->input('since') }}"
        @endif>
      </label>
      <label for="until">
        <h2>{{ __('query_fields.until') }}: </h2>
        <input type="date" name="until" id="dateUNTIL"
        @if (request()->has('until'))
          value = "{{ old('until') ? old('until') : request()->input('until') }}"
        @endif>
      </label>
      <input type="submit" value="{{ __('validation_fields.buttons.filter') }}" style="position: relative; margin: 0; display: none;" id="submit">
    </form>
    <script>
      let dateSINCE = document.getElementById('dateSINCE');
      let dateUNTIL = document.getElementById('dateUNTIL');

      function showButton(){
        document.getElementById('submit').style.display = 'block';
      }

      dateSINCE.addEventListener('change',showButton);
      dateUNTIL.addEventListener('change',showButton);
    </script>
  </section>
</x-app-layout>
