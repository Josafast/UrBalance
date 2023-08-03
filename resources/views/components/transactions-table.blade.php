<table>
  <thead>
    <tr>
      <th>{{ __('transactions.table.name') }}</th>
      <th>{{ __('transactions.table.quantity') }}</th>
      <th>{{ __('transactions.table.type') }}</th>
      <th>{{ __('transactions.table.category') }}</th>
      <th>{{ __('transactions.table.state') }}</th>
      <th>{{ __('transactions.table.date') }}</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <x-transactions-rows />
  </tbody>
</table>
<script>
  let rows = document.querySelectorAll('.transaction-row');

  rows.forEach(row=>{
    row.addEventListener('click', function(){
      if (this.classList.contains('visible')){
        this.classList.remove('visible');
      } else {
        rows.forEach(row=>{
          row.classList.remove('visible');
        });

        this.classList.add('visible');
      }
    });
  });
</script>