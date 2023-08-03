<x-app-layout title="{{ __('titles.transactions.index') }}">
  <section style="flex-direction: column">
    <x-transactions-filter />
  </section>
  <section class="transactions-table">
    <x-transactions-table />
  </section>
  <x-transactions-notes />
</x-app-layout>